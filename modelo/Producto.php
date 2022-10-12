<?php
require_once SYS . DIRECTORY_SEPARATOR . 'Modelo.php';
require_once PER . DIRECTORY_SEPARATOR . "BaseDeDatos.php";
require_once 'Pais.php';
class Producto extends Modelo {
    private $_id;
    private $_nombre;
    private $_descripcion;
    private $_pu;
    private $_modelo;
    private $_tabla="productos";
    private $_vista="v_producto01";
    private $_bd;

    public function __construct($id=null, $nombre=null,
                $descripcion=null, $pu=null, $modelo=null){
        $this->_bd = new BaseDeDatos(new MySQL());
        $this->_id = $id;
        $this->_nombre= $nombre;
        $this->_descripcion= $descripcion;
        $this->_pu= $pu;
       // $this->_modelo= new Modelo($modelo);
    }
    public function setPais (Pais $p){
        $this->_pais= $p;
    }
    public function getPais(){
        return $this->_pais;
    }
    public function leer(){
        $sql ="SELECT * FROM ". $this->_vista .";";    
        return $this->_bd->ejecutar($sql);
    }
    public function leerXMarca($id){
        $sql ="SELECT * FROM ". $this->_tabla
            . " WHERE idmodelo=".$id;
        return $this->_bd->ejecutar($sql);
    }
     public function leerUno(){
        $sql= "SELECT * FROM ". $this->_vista 
            . " WHERE idproducto=".$this->_id;
        
        $datos= $this->_bd->ejecutar($sql);  
        // var_dump($datos);exit();
        if (is_array($datos['data'])){
            $this->_id = $datos['data'][0]["idciudad"];
            $this->_nombre = $datos['data'][0]["ciudad"];
            $this->_pais = new Pais ($datos['data'][0]["idpais"]);
        }
    
        return $datos; 
    }
    public function getDetalles(){
        $sql= "SELECT * FROM ". $this->_vista 
            . " WHERE idproducto=".$this->_id;
        
        $datos= $this->_bd->ejecutar($sql);  

        $sql= "SELECT * FROM imagenes_producto" 
           . " WHERE idproducto=".$this->_id;
        $datos['imagenes']= $this->_bd->ejecutar($sql);
    
        return $datos; 
    }
    public function eliminar(){
        $sql= "Delete FROM ". $this->_tabla 
            . " WHERE idciudad=".$this->_id;
        return $this->_bd->ejecutar($sql);    
    }
    public function editar(){
        $sql ="UPDATE ". $this->_tabla 
            . " SET nombre='".$this->_nombre."',"
            . " idpais='".$this->_pais->getId() ."'"
            ." WHERE idciudad=".$this->_id;
        // var_dump($sql); exit();
        return $this->_bd->ejecutar($sql);
    }

    public function nuevo(){
        $sql = "INSERT INTO ". $this->_tabla 
            ." (idciudad, nombre, idpais) VALUES (".
                $this->_id .",'". $this->_nombre ."',"
                . $this->_pais->getId()
            .");";
        // var_dump($sql); exit();
        return $this->_bd->ejecutar($sql);
    }
    public function getId(){
        return $this->_id;
    }
    public function getNombre(){
        return $this->_nombre;
    }
}
