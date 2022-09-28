<?php
require_once SYS . DIRECTORY_SEPARATOR . 'Controlador.php';

/*
* Clase CtrlPrincipal
*/
class CtrlPrincipal extends Controlador {
    
    public function index(){
        $menu= array(
            'CtrlPais'=>'Paises',
        );
        $migas = array(
            '?'=>'Inicio',
        );
        $datos = array(
            'titulo'=>"Sistema de Ventas",
            'contenido'=>Vista::mostrar('principal.php','',true),
            'menu'=>$menu,
            'migas'=>$migas,
            'msg'=>''
        );
        
        $this->mostrarVista('template.php',$datos);

    }
}