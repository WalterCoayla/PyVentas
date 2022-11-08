<?php
require_once SYS . DIRECTORY_SEPARATOR . 'Modelo.php';
require_once PER . DIRECTORY_SEPARATOR . "BaseDeDatos.php";
require_once MOD . DIRECTORY_SEPARATOR . "Cliente.php";
require_once MOD . DIRECTORY_SEPARATOR . "DetalleBoleta.php";

class Boleta extends Modelo {
    private $_id;
    private $_nro;
    private $_fecha;
    private $_total;
    private $_cliente;
    private $_detalles;

    private $_tabla="boletas";
    private $_bd;

    public function __construct($id=null, $nro=null,$fecha=null,$total=0){
        $this->_bd = new BaseDeDatos(new MySQL());
        $this->_id = $id;
        $this->_nro= $nro;
        $this->_fecha= $fecha;
        $this->_total= $total;
    }
    public function setCliente(Cliente $c) {
        $this->_cliente=$c;
    }
    public function addDetalle(Detalle $d){
        $this->_detalles[]=$d;
    }
    public function leer(){
        $sql ="SELECT * FROM ". $this->_tabla .";";
        return $this->_bd->ejecutar($sql);
    }
     public function leerUno(){
        $sql= "SELECT * FROM ". $this->_tabla 
            . " WHERE idpais=".$this->_id;
        
        $datos= $this->_bd->ejecutar($sql);  
        //var_dump($datos);exit();
        if (is_array($datos['data'])){
            $this->_id = $datos['data'][0]["idpais"];
            $this->_nombre = $datos['data'][0]["nombre"];  
        }
        
        return $datos; 
    }
    public function eliminar(){
        $sql= "Delete FROM ". $this->_tabla 
            . " WHERE idpais=".$this->_id;
        return $this->_bd->ejecutar($sql);    
    }
    public function editar(){
        $sql ="UPDATE ". $this->_tabla 
            . " SET nombre='".$this->_nombre."'"
            ." WHERE idpais=".$this->_id;
        return $this->_bd->ejecutar($sql);
    }

    public function nuevo($total=0,$idCliente=1,$detalles=null){
        $sql = "INSERT INTO ". $this->_tabla 
            ." (total, idcliente) VALUES (".
                $total*1.18 .",". $idCliente
            .");";
        $this->_bd->ejecutar($sql);

        foreach ($detalles as $d) {
            $sql = "INSERT INTO detallesboletas" 
            ." (cantidad, pu,subtotal,idproducto) VALUES (".
                $d['cant'] .",". $d['pu'].",". $d['subtotal'].",". $d['idproducto']
            .");";
        $this->_bd->ejecutar($sql);
        }

    }
    public function getId(){
        return $this->_id;
    }
    public function getNombre(){
        return $this->_nombre;
    }
    public function getUltimaBoletaDetalleCliente($id)  {
        $sql = "SELECT * FROM `v_boletas` WHERE idboleta=idBoletaCliente(".$id.")";
        return $this->_bd->ejecutar($sql);
    }
    public function getUltimaBoletaCliente($id)  {
        $sql = "SELECT * FROM ". $this->_tabla." WHERE idboleta=idBoletaCliente(".$id.")";
        return $this->_bd->ejecutar($sql);
    }
}
