<?php
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);

require_once PER . DIRECTORY_SEPARATOR . 'ManejadorBDInterface.php';
class MySQL implements ManejadorBDInterface {
    private $_usuario= "root";
    private $_clave="";
    private $_base="bd_ventas2022";    #Aqui el nombre su "Base de Datos"
    private $_servidor = "localhost";
    private $_conexion;
    # Metodos de la Interface
    public function conectar(){
        try {
            $this->_conexion = mysqli_connect (
                $this->_servidor,
                $this->_usuario,
                $this->_clave,
                $this->_base );
             $this->_conexion->set_charset("utf8"); #Para las tildes y caracteres especiales
        } catch (mysqli_sql_exception $e) {
            // trigger_error ('Ocurrió un error: ' .$e , E_USER_NOTICE);
            return array(
                'titulo'=>'Error',
                'msg'=>$e->getMessage()
            );
            // throw $e;
        }
        
    }
    public function desconectar(){
        if (!is_object($this->_conexion)){
            return array(
                'titulo'=>'Error',
                'msg'=>'No pude ejecutar la sentencia: mysqli_close()!!'
            );
        }
        mysqli_close($this->_conexion);
    }
    public function traerDatos($sql){
        mysqli_report (MYSQLI_REPORT_OFF);
        if (!is_object($this->_conexion)){
            return false;
        }
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