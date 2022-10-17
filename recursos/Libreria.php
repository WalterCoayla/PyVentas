<?php
session_start();

abstract class Libreria {
    static function getMenu(){  # Generamos el MENU de opciones
        return array(
            array(
                'icono'=>'globe',
                'enlace'=>'CtrlPais',
                'texto'=>'Paises'
            ),
            array(
                'icono'=>'city',
                'enlace'=>'CtrlCiudad',
                'texto'=>'Ciudades'
            ),
            array(
                'icono'=>'users',
                'enlace'=>'CtrlCliente',
                'texto'=>'Clientes'
            )
        );
    }
    static function cssGlobales(){
        return array(
                array(
                    'nombre'=>'Google Font: Source Sans Pro',
                    'url'=>'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback'
                ),
                
                array(
                    'nombre'=>'Font Awesome',
                    'url'=>'plugins/fontawesome-free/css/all.min.css'
                ),
                array(
                    'nombre'=>'Ionicons',
                    'url'=>'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'
                ),
                array(
                    'nombre'=>'Tempusdominus Bootstrap 4',
                    'url'=>'recursos/css/bootstrap.min.css'
                    # 'url'=>'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'
                ),
                array(
                    'nombre'=>'iCheck',
                    'url'=>'plugins/icheck-bootstrap/icheck-bootstrap.min.css'
                ),
                array(
                    'nombre'=>'JQVMap',
                    'url'=>'plugins/jqvmap/jqvmap.min.css'
                ),
                array(
                    'nombre'=>'Theme style',
                    'url'=>'dist/css/adminlte.min.css'
                ),
                array(
                    'nombre'=>'overlayScrollbars',
                    'url'=>'plugins/overlayScrollbars/css/OverlayScrollbars.min.css'
                ),
                array(
                    'nombre'=>'Daterange picker',
                    'url'=>'plugins/daterangepicker/daterangepicker.css'
                ),
                array(
                    'nombre'=>'summernote',
                    'url'=>'plugins/summernote/summernote-bs4.min.css'
                ),
                array(
                    'nombre'=>'jsToast',
                    'url'=>'recursos/css/jquery/jquery-toast.css'
                )
            );
    }
    
    static function jsGlobales(){
        return array(
            array(
                'url'=>'plugins/jquery/jquery.min.js'
            ),
            array(
                'url'=>'plugins/jquery-ui/jquery-ui.min.js'
            ),
            array(
                'url'=>'plugins/bootstrap/js/bootstrap.bundle.min.js'
            ),
            array(
                'url'=>'dist/js/adminlte.js'
            ),
            array(
                'url'=>'dist/js/demo.js'
            ),
            array(
                'url'=>'dist/js/pages/dashboard3.js'
            ),
            array(
                'url'=>'recursos/js/jq-toast.min.js'
            ),
        );
    }

}
