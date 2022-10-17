<?php
require_once SYS . DIRECTORY_SEPARATOR . 'Controlador.php';
require_once MOD .DIRECTORY_SEPARATOR . 'Carrito.php';
require_once MOD .DIRECTORY_SEPARATOR . 'Producto.php';
require_once REC . DIRECTORY_SEPARATOR . 'Libreria.php';
/*
* Clase CtrlCarrito
*/
class CtrlCarrito extends Controlador {
    public function agregar() {
        if (!isset($_SESSION['carrito']))
            $_SESSION['carrito'] = new Carrito();

        if (is_object($_SESSION['carrito'])){
            $_SESSION['carrito']->agregar($_GET['id'],1);
            
            if(isset($_GET['url'])){
                switch($_GET['url']){
                    case 'detalles':
                        header("Location: ?ctrl=CtrlProducto&accion=verDetalles&id=".$_GET['id']);
                        exit();
                        break;
                    case 'carrito':
                        $this->mostrar();
                        // exit();
                        break;
                    default:
                        header("Location: ?ctrl=CtrlProducto&accion=getCatalogo&id=".$_GET['id']);
                        exit();
                }
            }else{
                header("Location: ?ctrl=CtrlProducto&accion=getCatalogo&id=".$_GET['id']);
                exit();
            }
        }
        else
            echo "Error en objeto";
    }
    public function sacar() {
        if (isset($_SESSION['carrito']))
            $_SESSION['carrito']->sacar($_GET['id']);
        
        $this->mostrar();
    }
    public function mostrar() {
        $menu= Libreria::getMenu();
        $migas = array(
            '?'=>'Inicio',
            '#'=>'Carrito'
        );
        $data=null;
        if (!isset($_SESSION['carrito'])){
            $miCarrito=Vista::mostrar('carrito/vacio.php','',true);
            
        }else{
            # Recuperar PRODUCTOS según CARRITO
            $obj = new Producto();
            
            $data=$obj->getProductosCarrito();
            if (is_null($data))
                $miCarrito=Vista::mostrar('carrito/vacio.php','',true);
            else
                $miCarrito = Vista::mostrar('carrito/mostrar.php',$data,true);
        }
        // var_dump($miCarrito);exit();
        $datos = array(
            'titulo'=>"Carrito de compras",
            'contenido'=>$miCarrito,
            'menu'=>$menu,
            'migas'=>$migas,
            'msg'=>array(
                    'titulo'=>'',
                    'cuerpo'=>''
                )
        );
        
        $this->mostrarVista('template.php',$datos);

    }
}