<?php
require_once SYS . DIRECTORY_SEPARATOR . 'Controlador.php';
require_once MOD .DIRECTORY_SEPARATOR . 'Producto.php';
require_once REC . DIRECTORY_SEPARATOR . 'Libreria.php';
/*
* Clase CtrlProducto
*/
class CtrlProducto extends Controlador {
    
    public function index($msg=array('titulo'=>'','cuerpo'=>'')){
        $menu= Libreria::getMenu();
        $migas = array(
            '?'=>'Inicio',
        );

        $obj = new Producto();
        $resultado = $obj->leer();

        $datos = array(
            'titulo'=>"Productos",
            'contenido'=>Vista::mostrar('producto/mostrar.php',$resultado,true),
            'menu'=>$menu,
            'migas'=>$migas,
            'msg'=>$msg
        );
        
        $this->mostrarVista('template.php',$datos);
    }
    public function nuevo(){
        $menu = Libreria::getMenu();
        $msg= array(
            'titulo'=>'Nuevo...',
            'cuerpo'=>'Ingrese información para nuevo Producto');
        $migas = array(
            '?'=>'Inicio',
            '?ctrl=CtrlProducto'=>'Listado',
            '#'=>'Nuevo',
        );
        $obj = new Producto();
        $datos1=array(
            'encabezado'=>'Nuevo Producto',
            'producto'=>$obj
            );

        $datos = array(
                'titulo'=>'Nueva Producto',
                'contenido'=>Vista::mostrar('producto/frmNuevo.php',$datos1,true),
                'menu'=>$menu,
                'migas'=>$migas,
                'msg'=>$msg
            );
        $this->mostrarVista('template.php',$datos);
    }

    public function guardarNuevo(){
        $obj = new Producto (
                $_POST["id"],
                $_POST["producto"],
                $_POST["pais"],
                );
        $respuesta=$obj->nuevo();

        $this->index($respuesta['msg']);
    }
    public function eliminar(){
        if (isset($_REQUEST['id'])) {
            $obj = new Producto($_REQUEST['id']);
            $resultado=$obj->eliminar();
            $this->index($resultado['msg']);
        } else {
            echo "...El Id a ELIMINAR es requerido";
        }
    }
    public function editar(){
        #Mostramos el Formulario de Editar
        $menu = Libreria::getMenu();
        $msg= array(
            'titulo'=>'Editando...',
            'cuerpo'=>'Iniciando edición para: '.$_REQUEST['id']);
        $migas = array(
            '?'=>'Inicio',
            '?ctrl=CtrlProducto'=>'Listado',
            '#'=>'Editar',
        );
        if (isset($_REQUEST['id'])) {
            $obj = new Producto($_REQUEST['id']);
            $miObj = $obj->leerUno();
            if (is_null($miObj['data'])) {
                $this->index(array(
                    'titulo'=>'Error',
                    'cuerpo'=>'ID Requerido: '.$_REQUEST['id']. ' No Existe')
                );
            }else{

                $datos1 = array(
                        'producto'=>$obj
                    );

                $datos = array(
                    'titulo'=>'Editando Producto: '. $_REQUEST['id'],
                    'contenido'=>Vista::mostrar('producto/frmEditar.php',$datos1,true),
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
                'titulo'=>'Editando Producto... DESCONOCIDO',
                'contenido'=>'...El Id a Editar es requerido',
                'menu'=>$menu,
                'migas'=>$migas,
                'msg'=>$msg);
        }
        
        $this->mostrarVista('template.php',$datos);

        
    }
    public function guardarEditar(){
        $obj = new Producto (
                $_POST["id"],    #El id que enviamos
                $_POST["producto"],
                $_POST["pais"]
                );
        $respuesta=$obj->editar();
        
        $this->index($respuesta['msg']);
    }
    public function getProductoesSelect(){
        $id = $_GET['id'];
        $obj = new Producto();
        $datos = $obj->leerXPais($id)['data'];
        $html = '<option value="0">Seleccionar...</option>';
        foreach ($datos as $d) {
            $html .= '<option value="'.$d['idproducto'].'">'.$d['nombre'].'</option>';
        }
        echo $html;

    }
    public function getCatalogo(){
        $menu= Libreria::getMenu();
        $migas = array(
            '?'=>'Inicio',
            '#'=>'Catálogo',
        );

        $obj = new Producto();
        $resultado = $obj->leer();
        
        $msg=array('titulo'=>'','cuerpo'=>'');
        $datos = array(
            'titulo'=>"Catálogo",
            'contenido'=>Vista::mostrar('producto/catalogo.php',$resultado,true),
            'menu'=>$menu,
            'migas'=>$migas,
            'msg'=>$msg
        );
        
        $this->mostrarVista('template.php',$datos);
    }
    public function verDetalles(){
        $menu= Libreria::getMenu();
        $migas = array(
            '?'=>'Inicio',
            '?ctrl=CtrlProducto&accion=getCatalogo'=>'Catálogo',
            '#'=>'Detalles',
        );
        $id = $_GET['id'];
        $jsVista = array(
                array(
                'url'=>'recursos/js/jsImagenes.js'
                )
            );

        $obj = new Producto($id);
        $resultado = $obj->getDetalles();

        $msg=array('titulo'=>'','cuerpo'=>'');
        $datos = array(
            'titulo'=>"Detalles",
            'contenido'=>Vista::mostrar('producto/detalles.php',$resultado,true),
            'menu'=>$menu,
            'migas'=>$migas,
            'msg'=>$msg,
            'js'=>$jsVista
        );
        
        $this->mostrarVista('template.php',$datos);
    }
}