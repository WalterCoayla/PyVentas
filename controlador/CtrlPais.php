<?php
require_once SYS . DIRECTORY_SEPARATOR . 'Controlador.php';
require_once MOD .DIRECTORY_SEPARATOR . 'Pais.php';
require_once MOD .DIRECTORY_SEPARATOR . 'Carrito.php';
require_once REC . DIRECTORY_SEPARATOR . 'Libreria.php';
/*
* Clase CtrlPais
*/
class CtrlPais extends Controlador {
    
    public function index($msg=array('titulo'=>'','cuerpo'=>'')){
        if(!isset($_SESSION['nombre'])){
            header("Location: ?");
            exit();
        }
        $menu= Libreria::getMenu();
        $migas = array(
            '?'=>'Inicio',
            '#'=>'Listado'
        );

        $obj = new Pais();
        $resultado = $obj->leer();

        $datos = array(
            'titulo'=>"Paises",
            'contenido'=>Vista::mostrar('pais/mostrar.php',$resultado,true),
            'menu'=>$menu,
            'migas'=>$migas,
            'msg'=>$msg
        );
        
        $this->mostrarVista('template.php',$datos);
    }
    public function nuevo(){
        if(!isset($_SESSION['nombre'])){
            header("Location: ?");
            exit();
        }
        $menu = Libreria::getMenu();
        $msg= array(
            'titulo'=>'Nuevo...',
            'cuerpo'=>'Ingrese información para nuevo Pais');
        $migas = array(
            '?'=>'Inicio',
            '?ctrl=CtrlPais'=>'Listado',
            '#'=>'Nuevo'
        );
        $datos1=array(
            'encabezado'=>'Nuevo Pais'
            );

        $datos = array(
                'titulo'=>'Nuevo Pais',
                'contenido'=>Vista::mostrar('pais/frmNuevo.php',$datos1,true),
                'menu'=>$menu,
                'migas'=>$migas,
                'msg'=>$msg
            );
        $this->mostrarVista('template.php',$datos);
    }

    public function guardarNuevo(){
        if(!isset($_SESSION['nombre'])){
            header("Location: ?");
            exit();
        }
        $obj = new Pais (
                $_POST["id"],
                $_POST["pais"],
                );
        $respuesta=$obj->nuevo();

        $this->index($respuesta['msg']);
    }
    public function eliminar(){
        if(!isset($_SESSION['nombre'])){
            header("Location: ?");
            exit();
        }
        if (isset($_REQUEST['id'])) {
            $obj = new Pais($_REQUEST['id']);
            $resultado=$obj->eliminar();
            $this->index($resultado['msg']);
        } else {
            echo "...El Id a ELIMINAR es requerido";
        }
    }
    public function editar(){
        if(!isset($_SESSION['nombre'])){
            header("Location: ?");
            exit();
        }
        #Mostramos el Formulario de Editar
        $datos=null;
        $menu = Libreria::getMenu();
        $msg= array(
            'titulo'=>'Editando...',
            'cuerpo'=>'Iniciando edición de: '.$_REQUEST['id']);
        $migas = array(
            '?'=>'Inicio',
            '?ctrl=CtrlPais'=>'Listado',
            '#'=>'Editar',
        );
        if (isset($_REQUEST['id'])) {
            $obj = new Pais($_REQUEST['id']);
            $miObj = $obj->leerUno();
            // var_dump($obj->leerUno());exit();
            if (is_null($miObj['data'])) {
                $this->index(array(
                    'titulo'=>'Error',
                    'cuerpo'=>'ID Requerido: '.$_REQUEST['id']. ' No Existe')
                );
            }else{
                $datos1 = array(
                    'pais'=>$obj
                );
            $datos = array(
                'titulo'=>'Editando Pais: '. $_REQUEST['id'],
                'contenido'=>Vista::mostrar('pais/frmEditar.php',$datos1,true),
                'menu'=>$menu,
                'migas'=>$migas,
                'msg'=>$msg
            );
            }
            
        }else {
            $msg= array(
            'titulo'=>'Error',
            'cuerpo'=>'No se encontró al ID requerido');

            $datos = array(
                'titulo'=>'Editando Turno... DESCONOCIDO',
                'contenido'=>'...El Id a Editar es requerido',
                'menu'=>$menu,
                'migas'=>$migas,
                'msg'=>$msg);
        }
        
        $this->mostrarVista('template.php',$datos);

        
    }
    public function guardarEditar(){
        if(!isset($_SESSION['nombre'])){
            header("Location: ?");
            exit();
        }
        $obj = new Pais (
                $_POST["id"],    #El id que enviamos
                $_POST["pais"]
                );
        $respuesta=$obj->editar();
        
        $this->index($respuesta['msg']);
    }
    public function getPaisesSelect(){
        $obj = new Pais();
        $datos = $obj->leer()['data'];
        $html = '<option value="0">Seleccionar...</option>';
        foreach ($datos as $d) {
            $html .= '<option value="'.$d['idpais'].'">'.$d['nombre'].'</option>';
        }
        echo $html;
    }
}