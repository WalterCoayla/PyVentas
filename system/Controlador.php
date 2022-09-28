<?php
require_once SYS . DIRECTORY_SEPARATOR . 'Vista.php';
require_once SYS . DIRECTORY_SEPARATOR . 'Modelo.php';
/**
 * Clase Controlador
 */
abstract class Controlador {
   # Código del CORE - Controlador
   static protected function mostrarVista($vista,
                                        $datos='',
                                        $comoContenido=FALSE){
       Vista::mostrar($vista,$datos,$comoContenido);
   }
}