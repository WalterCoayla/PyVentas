<?php
require_once SYS . DIRECTORY_SEPARATOR . 'Modelo.php';
require_once PER . DIRECTORY_SEPARATOR . "BaseDeDatos.php";

class Graficador extends Modelo {
    private $_bd;
    public function __construct() {
        $this->_bd = new BaseDeDatos(new MySQL());
    }
    public function getModeloXMarca(){
        $sql ="SELECT * FROM v_graf_modelos_x_marca;";    
        $datos = $this->_bd->ejecutar($sql);
        return $this->getArray($datos['data']);
    }
    private function getArray($datos){
        $labels=null;
        $data=null;
        foreach ($datos as $d) {
            $labels[]=$d['marca'];
            $data[]=$d['cant'];
        }
        return array('labels'=>$labels,'data'=>$data);
    }

}