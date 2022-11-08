<?php
require_once SYS . DIRECTORY_SEPARATOR . 'Controlador.php';
require_once MOD .DIRECTORY_SEPARATOR . 'Carrito.php';
require_once REC . DIRECTORY_SEPARATOR . 'Libreria.php';
require_once MOD .DIRECTORY_SEPARATOR . 'Graficador.php';
/*
* Clase CtrlPrincipal
*/
class CtrlPrincipal extends Controlador {
    
    public function index(){
        $menu= Libreria::getMenu();
        $migas = array(
            '?'=>'Inicio',
        );
        $datosGraf= $this->getGraficoModelosXMarcas();
        //var_dump($datosGraf);
        // echo json_encode($datosGraf);
        //exit();
        $datos = array(
            'titulo'=>"Sistema de Ventas",
            'contenido'=>Vista::mostrar('principal.php','',true),
            'menu'=>$menu,
            'migas'=>$migas,
            'msg'=>array(
                    'titulo'=>'',
                    'cuerpo'=>''
            ),
            'data'=>null,
            'grafico'=>$datosGraf
        );
        
        $this->mostrarVista('template.php',$datos);

    }
    
    private function getGraficoModelosXMarcas(){
        $g = new Graficador();
        $datos = $g->getModeloXMarca();
        return $datos;
    }
    public function error404()
    {
        $datos= array(
            'controlador'=>isset($_GET['ctrl'])?$_GET['ctrl']:'CtrlPrincipal',
            'accion'=>isset($_GET['accion'])?$_GET['accion']:'index'
        );
        $this->mostrarVista('404.php',$datos);
    }
}