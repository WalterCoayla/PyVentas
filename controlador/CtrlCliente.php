<?php
require_once SYS . DIRECTORY_SEPARATOR . 'Controlador.php';
require_once MOD .DIRECTORY_SEPARATOR . 'Cliente.php';
require_once MOD .DIRECTORY_SEPARATOR . 'Carrito.php';
require_once REC . DIRECTORY_SEPARATOR . 'Libreria.php';
/*
* Clase CtrlCliente
*/
class CtrlCliente extends Controlador {
    
    public function index($msg=null){
        $menu= Libreria::getMenu();
        
        $obj = new Cliente();
        $resultado = $obj->leer();
        $msg = $msg==null?$this->_getMsg():$msg;
        $datos = array(
            'titulo'=>"Clientes",
            'contenido'=>Vista::mostrar('cliente/mostrar.php',$resultado,true),
            'menu'=>$menu,
            'migas'=>$this->_getMigas(),
            'msg'=>$msg
        );
        
        $this->mostrarVista('template.php',$datos);
    }
    public function nuevo(){
        $menu = Libreria::getMenu();
        
        $obj = new Cliente();
        $datos1=array(
            'encabezado'=>'Nueva Cliente',
            'cliente'=>$obj
            );
        $jsVista = array(
                array(
                'url'=>'recursos/js/jsPais.js'
                )
            );

        $datos = array(
                'titulo'=>'Nueva Cliente',
                'contenido'=>Vista::mostrar('cliente/frmNuevo.php',$datos1,true),
                'menu'=>$menu,
                'migas'=>$this->_getMigas('nuevo'),
                'msg'=>$this->_getMsg('Nuevo...','Ingrese información para nueva Cliente'),
                'js'=>$jsVista
            );
        $this->mostrarVista('template.php',$datos);
    }

    public function guardarNuevo(){
        $obj = new Cliente (
                $_POST["id"],
                $_POST["nombre"],
                $_POST["apellido"],
                $_POST["dni"],
                $_POST["ciudad"]
                );
        $respuesta=$obj->nuevo();
        // var_dump($respuesta);exit();
        $this->index($respuesta['msg']);
    }
    public function eliminar(){
        if (isset($_REQUEST['id'])) {
            $obj = new Cliente($_REQUEST['id']);
            $resultado=$obj->eliminar();
            $this->index($resultado['msg']);
        } else {
            echo "...El Id a ELIMINAR es requerido";
        }
    }
    public function editar(){
        #Mostramos el Formulario de Editar
        $menu = Libreria::getMenu();
        $jsVista = array(
                array(
                'url'=>'recursos/js/jsPais.js'
                )
            );
        if (isset($_REQUEST['id'])) {
            $obj = new Cliente($_REQUEST['id']);
            $miObj = $obj->leerUno();
            if (is_null($miObj['data'])) {
                $this->index($this->_getMsg('Error',
                        'ID Requerido: '.$_REQUEST['id']. ' No Existe')
                    );
            }else{
                $datos1 = array(
                        'cliente'=>$obj
                    );

                $datos = array(
                    'titulo'=>'Editando Cliente: '. $_REQUEST['id'],
                    'contenido'=>Vista::mostrar('cliente/frmEditar.php',$datos1,true),
                    'menu'=>$menu,
                    'migas'=>$this->_getMigas('editar'),
                    'msg'=>$this->_getMsg('Editando...','Iniciando edición para: '.$_REQUEST['id']),
                    'js'=>$jsVista
                );
            }
        }else {
            $datos = array(
                'titulo'=>'Editando Cliente... DESCONOCIDO',
                'contenido'=>'...El Id a Editar es requerido',
                'menu'=>$menu,
                'migas'=>$this->_getMigas('editar'),
                'msg'=>$this->_getMsg('Error','No se encontró al ID requerido')
            );
        }
        
        $this->mostrarVista('template.php',$datos);
    }
    public function guardarEditar(){
        $obj = new Cliente (
                $_POST["id"],
                $_POST["nombre"],
                $_POST["apellido"],
                $_POST["dni"],
                $_POST["ciudad"]
                );
        $respuesta=$obj->editar();
        
        $this->index($respuesta['msg']);
    }
    private function _getMigas($operacion=null)
    {
        $retorno=null;
        switch ($operacion) {
            case 'nuevo':
                $retorno = array(
                    '?'=>'Inicio',
                    '?ctrl=CtrlCliente'=>'Listado',
                    '#'=>'Nuevo',
                );
                break;
            case 'editar':
                $retorno = array(
                    '?'=>'Inicio',
                    '?ctrl=CtrlCliente'=>'Listado',
                    '#'=>'Editar',
                );
                break;
            
            default:
                $retorno = array(
                    '?'=>'Inicio',
                );
                break;
        }
        return $retorno;
    }
    private function _getMsg($titulo=null,$msg=null){
        return array(
            'titulo'=>$titulo,
            'cuerpo'=>$msg
        );
    }
}