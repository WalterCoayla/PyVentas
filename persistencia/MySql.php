<?php
require_once PER . DIRECTORY_SEPARATOR . 'ManejadorBDInterface.php';
class MySQL implements ManejadorBDInterface {
    private $_usuario= "root";
    private $_clave="";
    private $_base="bd_ventas2022";    #Aqui el nombre su "Base de Datos"
    private $_servidor = "localhost";
    private $_conexion;
    # Metodos de la Interface
    public function conectar(){
        $this->_conexion = mysqli_connect (
            $this->_servidor,
            $this->_usuario,
            $this->_clave,
            $this->_base );
        $this->_conexion->set_charset("utf8"); #Para las tildes y caracteres especiales
    }
    public function desconectar(){
        mysqli_close($this->_conexion);
    }
    public function traerDatos($sql){
        $retorno = null; 
        $msg=array(
            'titulo'=>'',
            'cuerpo'=>''
        ); 
        $data=null; $sentencia=null;
        $sentencia= explode(" ", $sql);
        $sentencia= strtoupper($sentencia[0]); #Primera PALABRA del comando
        if (!($resultado = $this->_conexion->query($sql)))
            $retorno= array(
                'data'=>null,
                'msg'=> array(
                        'titulo'=>'Error',
                        'cuerpo'=>'En la Sentencia SQL: '.$sql));
        else{
            if (is_object($resultado)){ #Si devuelve un SELECT
                // var_dump($resultado);exit();
                if($resultado->num_rows==0){
                    $data=null;
                    $msg= array(
                            'titulo'=>$sentencia,
                            'cuerpo'=>"No se Encontraron Datos")
                        ;
                } else
                    while ($row = mysqli_fetch_assoc($resultado)) 
                        $data[] = $row;
            } else # En caso de otra operación (INSERT/UPDATE/DELETE)
                $msg = array(
                        'titulo'=>$sentencia,
                        'cuerpo'=>" Sentencia realizada correctamente");
            $retorno= array(
                    'data'=>$data,
                    'msg'=> $msg
                );
        }
            
        return $retorno;
        
    }
}