<?php
require_once SYS . DIRECTORY_SEPARATOR . 'Controlador.php';
require_once MOD .DIRECTORY_SEPARATOR . 'Ciudad.php';
require_once REC . DIRECTORY_SEPARATOR . 'Libreria.php';
/*
* Clase CtrlCiudad
*/
class CtrlCiudad extends Controlador {
    
    public function index($msg=''){
        $menu= Libreria::getMenu();
        $migas = array(
            '?'=>'Inicio',
        );

        $obj = new Ciudad();
        $resultado = $obj->leer();

        $datos = array(
            'titulo'=>"Ciudades",
            'contenido'=>Vista::mostrar('ciudad/mostrar.php',$resultado,true),
            'menu'=>$menu,
            'migas'=>$migas,
            'msg'=>$msg
        );
        
        $this->mostrarVista('template.php',$datos);
    }
    public function nuevo(){
        $menu = Libreria::getMenu();
        // $msg='';
        $migas = array(
            '?'=>'Inicio',
            '?ctrl=CtrlCiudad'=>'Listado',
            '#'=>'Nuevo',
        );
        $obj = new Ciudad();
        $datos1=array(
            'encabezado'=>'Nueva Ciudad',
            'ciudad'=>$obj
            );

        $datos = array(
                'titulo'=>'Nueva Ciudad',
                'contenido'=>Vista::mostrar('ciudad/frmNuevo.php',$datos1,true),
                'menu'=>$menu,
                'migas'=>$migas,
                'msg'=>''
            );
        $this->mostrarVista('template.php',$datos);
    }

    public function guardarNuevo(){
        $obj = new Ciudad (
                $_POST["id"],
                $_POST["ciudad"],
                $_POST["pais"],
                );
        $respuesta=$obj->nuevo();

        $this->index($respuesta['msg']);
    }
    public function eliminar(){
        if (isset($_REQUEST['id'])) {
            $obj = new Ciudad($_REQUEST['id']);
            $resultado=$obj->eliminar();
            $this->index($resultado['msg']);
        } else {
            echo "...El Id a ELIMINAR es requerido";
        }
    }
    public function editar(){
        #Mostramos el Formulario de Editar
        $menu = Libreria::getMenu();
        $msg='Editando...';
        $migas = array(
            '?'=>'Inicio',
            '?ctrl=CtrlCiudad'=>'Listado',
            '#'=>'Editar',
        );
        if (isset($_REQUEST['id'])) {
            $obj = new Ciudad($_REQUEST['id']);
            $obj->leerUno();

            $datos1 = array(
                    'ciudad'=>$obj
                );

            $datos = array(
                'titulo'=>'Editando Ciudad: '. $_REQUEST['id'],
                'contenido'=>Vista::mostrar('ciudad/frmEditar.php',$datos1,true),
                'menu'=>$menu,
                'migas'=>$migas,
                'msg'=>$msg
            );
        }else {
            $datos = array(
                'titulo'=>'Editando Ciudad... DESCONOCIDO',
                'contenido'=>'...El Id a Editar es requerido',
                'menu'=>$menu,
                'migas'=>$migas,
                'msg'=>'Error!!!');
        }
        
        $this->mostrarVista('template.php',$datos);

        
    }
    public function guardarEditar(){
        $obj = new Ciudad (
                $_POST["id"],    #El id que enviamos
                $_POST["ciudad"],
                $_POST["pais"],
                );
        $respuesta=$obj->editar();
        
        $this->index($respuesta['msg']);
    }
}