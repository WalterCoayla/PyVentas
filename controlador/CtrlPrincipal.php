<?php
require_once SYS . DIRECTORY_SEPARATOR . 'Controlador.php';
require_once REC . DIRECTORY_SEPARATOR . 'Libreria.php';
/*
* Clase CtrlPrincipal
*/
class CtrlPrincipal extends Controlador {
    
    public function index(){
        $menu= Libreria::getMenu();
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