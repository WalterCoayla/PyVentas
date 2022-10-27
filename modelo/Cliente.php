<?php
require_once SYS . DIRECTORY_SEPARATOR . 'Modelo.php';
require_once PER . DIRECTORY_SEPARATOR . "BaseDeDatos.php";
require_once 'Ciudad.php';
class Cliente extends Modelo {
    private $_id;
    private $_nombre;
    private $_apellido;
    private $_dni;
    private $_ciudad;
    private $_login;
    private $_password;
    private $_tabla="clientes";
    private $_vista="v_clientes";
    private $_bd;

    public function __construct($id=null, $nombre=null,$apellido=null,
                        $dni=null,$ciudad=null){
        $this->_bd = new BaseDeDatos(new MySQL());
        $this->_id = $id;
        $this->_nombre= $nombre;
        $this->_apellido= $apellido;
        $this->_dni= $dni;
        $this->_ciudad= new Ciudad($ciudad);
    }
    public function setCiudad (Ciudad $p){
        $this->_ciudad= $p;
    }
    public function getCiudad(){
        return $this->_ciudad;
    }
    public function leer(){
        $sql ="SELECT * FROM ". $this->_vista .";";
        return $this->_bd->ejecutar($sql);
    }
     public function leerUno(){
        $sql= "SELECT * FROM ". $this->_vista 
            . " WHERE idcliente=".$this->_id;
        
        $datos= $this->_bd->ejecutar($sql);  
        // var_dump($datos);exit();
        if (is_array($datos['data'])){
            $this->_id = $datos['data'][0]["idcliente"];
            $this->_nombre = $datos['data'][0]["nombres"];
            $this->_apellido = $datos['data'][0]["apellidos"];
            $this->_dni = $datos['data'][0]["dni"];
            $this->_ciudad = new Ciudad ($datos['data'][0]["idciudad"]);
        }
    
        return $datos; 
    }
    public function eliminar(){
        $sql= "Delete FROM ". $this->_tabla 
            . " WHERE idcliente=".$this->_id;
        return $this->_bd->ejecutar($sql);    
    }
    public function editar(){
        $sql ="UPDATE ". $this->_tabla 
            . " SET nombres='".$this->_nombre."',"
            . " apellidos='".$this->_apellido ."',"
            . " dni='".$this->_dni ."',"
            . " idciudad=".$this->_ciudad->getId() 
            ." WHERE idcliente=".$this->_id;
        // var_dump($sql); exit();
        return $this->_bd->ejecutar($sql);
    }

    public function nuevo(){
        $sql = "INSERT INTO ". $this->_tabla 
            ." (idcliente, nombres,apellidos, dni, idciudad) VALUES (".
                $this->_id .",'"
                . $this->_nombre ."','"
                . $this->_apellido ."','"
                . $this->_dni ."',"
                . $this->_ciudad->getId()
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
    public function getApellido(){
        return $this->_apellido;
    }
    public function getDni(){
        return $this->_dni;
    }
    public function validar($login,$clave){
        $sql= "SELECT * FROM ". $this->_tabla 
            . " WHERE login='".$login ."' and pasword='".$clave ."'";
        
        return $this->_bd->ejecutar($sql);
    }
}
