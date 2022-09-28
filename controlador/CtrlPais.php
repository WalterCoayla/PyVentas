<?php
require_once SYS . DIRECTORY_SEPARATOR . 'Controlador.php';
require_once MOD .DIRECTORY_SEPARATOR . 'Pais.php';
/*
* Clase CtrlPais
*/
class CtrlPais extends Controlador {
    
    public function index($msg=''){
        $menu= $this->getMenu();
        $migas = array(
            '?'=>'Inicio',
        );

        $paises = new Pais();
        $resultado = $paises->leer();

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
        $menu = $this->getMenu();
        // $msg='';
        $migas = array(
            '?'=>'Inicio',
            '?ctrl=CtrlPais'=>'Listado',
            '#'=>'Nuevo',
        );
        $datos1=array(
            'encabezado'=>'Nuevo Pais'
            );

        $datos = array(
                'titulo'=>'Nuevo Pais',
                'contenido'=>Vista::mostrar('pais/frmNuevo.php',$datos1,true),
                'menu'=>$menu,
                'migas'=>$migas,
                'msg'=>''
            );
        $this->mostrarVista('template.php',$datos);
    }

    public function guardarNuevo(){
        $pais = new Pais (
                $_POST["id"],
                $_POST["pais"],
                );
        $respuesta=$pais->nuevo();

        $this->index($respuesta['msg']);
    }
    public function eliminar(){
        if (isset($_REQUEST['id'])) {
            $obj = new Pais($_REQUEST['id']);
            $resultado=$obj->eliminar();
            $this->index($resultado['msg']);
        } else {
            echo "...El Id a ELIMINAR es requerido";
        }
    }
    public function editar(){
        #Mostramos el Formulario de Editar
        $menu = $this->getMenu();
        $msg='Editando...';
        $migas = array(
            '?'=>'Inicio',
            '?ctrl=CtrlPais'=>'Listado',
            '#'=>'Editar',
        );
        if (isset($_REQUEST['id'])) {
            $obj = new Pais($_REQUEST['id']);
            $obj->leerUno();

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
        }else {
            $datos = array(
                'titulo'=>'Editando Turno... DESCONOCIDO',
                'contenido'=>'...El Id a Editar es requerido',
                'menu'=>$menu,
                'migas'=>$migas,
                'msg'=>'Error!!!');
        }
        
        $this->mostrarVista('template.php',$datos);

        
    }
    public function guardarEditar(){
        $obj = new Pais (
                $_POST["id"],    #El id que enviamos
                $_POST["pais"],
                );
        $respuesta=$obj->editar();
        
        $this->index($respuesta['msg']);
    }
    private function getMenu(){
        return array(
                'CtrlPais'=>'Paises',
            );
    }
}