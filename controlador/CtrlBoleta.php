<?php
require_once SYS . DIRECTORY_SEPARATOR . 'Controlador.php';
require_once MOD .DIRECTORY_SEPARATOR . 'Producto.php';
require_once MOD .DIRECTORY_SEPARATOR . 'Boleta.php';
require_once MOD .DIRECTORY_SEPARATOR . 'Carrito.php';
require_once REC . DIRECTORY_SEPARATOR . 'Libreria.php';
/*
* Clase CtrlBoleta
*/
class CtrlBoleta extends Controlador {
    
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
        // var_dump($resultado['data']);exit();
        $datos = array(
            'titulo'=>"Paises",
            'contenido'=>Vista::mostrar('pais/mostrar.php',$resultado,true),
            'menu'=>$menu,
            'migas'=>$migas,
            'msg'=>$msg,
            'data'=>$resultado['data']
        );
        
        $this->mostrarVista('template.php',$datos);
    }
    /*public function nuevo(){
        if(!isset($_SESSION['nombre'])){
            header("Location: ?");
            exit();
        }
        echo Vista::mostrar('pais/frmNuevo.php');
    }
    */
    public function guardarNuevo() {
        $obj = new Producto();
            
        $data=$obj->getProductosCarrito();
        $total=0;
        $datosDetalle=null;
        //var_dump($data);exit(); 
        foreach ($data['data'] as $p) {
            $cant = $_SESSION['carrito']->getCantidad($p['idproducto']);
            $pu = $p['pu'];
            $subTotal = $cant * $pu;
            $datosDetalle[]=array(
                'cant'=>$cant,
                'pu'=>$pu,
                'subtotal'=>$subTotal,
                'idproducto'=>$p['idproducto']
                );
            $total += $cant * $pu;
        }
        $obj = new Boleta();
        $obj->nuevo($total, $_SESSION['id'],$datosDetalle);
        
        $this->registrarCompra();
    }

    public function registrarCompra(){
        $obj = new Boleta();
        $data=$obj->getUltimaBoletaCliente($_SESSION['id']);

        $menu= Libreria::getMenu();
        $migas = array(
            '?'=>'Inicio',
        );
        // $datosGraf= $this->getGraficoModelosXMarcas();
        unset($_SESSION['carrito']);
        
        $datos = array(
            'titulo'=>"Registro de Compra realizada",
            'contenido'=>Vista::mostrar('boleta/registroCompra.php',$data,true),
            'menu'=>$menu,
            'migas'=>$migas,
            'msg'=>array(
                    'titulo'=>'',
                    'cuerpo'=>''
            ),
            'data'=>null,
            'grafico'=>null
        );
        
        $this->mostrarVista('template.php',$datos);

    }

    public function imprimir(){
        $obj = new Boleta();
        $data=$obj->getUltimaBoletaDetalleCliente($_SESSION['id']);
        Vista::mostrar('boleta/boleta.php',$data);
    }
}