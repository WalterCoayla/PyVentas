<?php 
require_once 'configuracion.php'; 
abstract class Index {
    static function run(){
        # Si se ha definido algún Controlador
        $controlador = ! empty($_GET['ctrl'])?$_GET['ctrl']:'CtrlPrincipal';
        # Si se ha definido alguna acción a ejecutar
        $accion = ! empty($_GET['accion'])?$_GET['accion']:'index';

        self::runControlador($controlador,$accion);
    }
    static private function runControlador($controlador,$accion){
        $fileControlador= CON . DIRECTORY_SEPARATOR .$controlador.'.php';  
        if (is_file($fileControlador)){  # Si existe el Controlador
            require_once $fileControlador;  #Lo cargamos (Requerimos)
            eval ( '$controlador= new '.$controlador.'();' );   # Lo instanciamos
            self::runAccion($controlador,$accion);
        }else
            self::error();
    } 
    static private function runAccion($controlador,$accion){
        if(method_exists($controlador,$accion)){    # Si existe el método
            $metodo = array($controlador, $accion);
            if(is_callable($metodo,false))          # Verificamos que se pueda llamar 
                eval ( '$controlador->' . $accion . '();' );    #Ejecutamos la acción
            else
                eval ( '$controlador->index(\'<br />ADVERTENCIA: 
                        Se detectó INTENTO DE ACCESO NO AUTORIZADO..., 
                        <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Evita divulgar tus contraseñas ...\');');
        }else{
            self::error();
        }
        # echo "Hola mundo";
        # die('La acción <b>'.$accion.'</b> no existe en el controlador '.$controlador.'  - 404 not found');
    }
    static function error($controlador='CtrlPrincipal',$accion='index'){
        # Redireccionamos a error 404
            $fileControlador= CON . DIRECTORY_SEPARATOR .'CtrlPrincipal.php';
            require_once $fileControlador;  #Lo cargamos (Requerimos)
            $controlador= new CtrlPrincipal() ;   # Lo instanciamos
            
            $controlador->error404();
    }
}
Index::run();