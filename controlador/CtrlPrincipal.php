<?php
require_once SYS . DIRECTORY_SEPARATOR . 'Controlador.php';

/*
* Clase CtrlPrincipal
*/
class CtrlPrincipal extends Controlador {
    
    public function index(){
        $datos = array(
            'titulo'=>"Sistema de Ventas"
        );
        
        $this->mostrarVista('principal.php',$datos);

    }
}