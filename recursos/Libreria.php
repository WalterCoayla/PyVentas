<?php

abstract class Libreria {
    static function getMenu(){
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
                'enlace'=>'CtrlPersona',
                'texto'=>'Personas'
            ),
        );
    }
}
