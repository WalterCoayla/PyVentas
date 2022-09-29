<?php

abstract class Libreria {
    static function getMenu(){
        return array(
            'CtrlPais'=>'Paises',
            'CtrlCiudad'=>'Ciudades',
        );
    }
}