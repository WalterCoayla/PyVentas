<?php
/**
 * Clase Vista
 */
abstract class Vista {
    static function mostrar($vista, $datos='', $comoContenido=FALSE) {
        $fileVista= VIS. DIRECTORY_SEPARATOR . $vista;
        if (file_exists($fileVista) == false) {
                trigger_error ('Plantilla ' . $fileVista . ' no Existe.', E_USER_NOTICE);
                return false;
        }
        //Si hay variables para asignar, las pasamos una a una.
        if (is_array($datos)) 
            foreach ($datos as $key => $value) 
                $$key = $value;

        if ($comoContenido) { //Si devolvemos el contenido a una variable
            ob_start();  // activamos el BUFFER de salida
            echo eval('?>'.preg_replace("/;*\s*\?>/", "; ?>", 
                    str_replace('<?=', '<?php echo ', file_get_contents($fileVista)
                    )));
            $buffer = ob_get_contents();
            @ob_end_clean();
            return $buffer;
        } else           //Si devolvemos la vista
            require_once $fileVista;  
    }
}
