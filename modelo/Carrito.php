<?php 
class Carrito {
    private $_productos=null;

    public function agregar($id,$cant=1){
        if (!isset($this->_productos[$id]))
            $this->_productos[$id]['cant']=0;       #inicializamos por lo menos 'cant'
        $this->_productos[$id]['cant'] += $cant;    #Agregamos la Cantidad
    }
    public function sacar($id,$cant=1){
        if ($cant<=$this->_productos[$id]['cant'])
            $this->_productos[$id]['cant']-= $cant;
        if ($this->_productos[$id]['cant']==0)
            unset($this->_productos[$id]);
    }
    public function getProductos(){
        return $this->_productos;
    }
    public function getCantidad($id){
        return isset($this->_productos[$id]['cant'])?$this->_productos[$id]['cant']:0;
    }
    public function calcularTotal(){
        $total = 0;
        foreach ($this->_productos as $p) 
            $total += $p['precio'] * $p['cant'] ;
        $total = number_format($total,2,"."," ");
        return $total;
    }
    public function getNroProductos(){
        $nro=0;
        if (is_array($this->_productos))
        foreach ($this->_productos as $p) {
            $nro += $p['cant'];
        }
        return $nro;
    }
}