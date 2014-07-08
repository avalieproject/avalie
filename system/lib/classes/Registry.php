<?php

class Registry {
    
    private static $instance;
    private $ArStorage;
    
    protected function __construct() {
        $this->ArStorage = new ArrayObject();
    }
    
    public static function getInstance(){
        if(!self::$instance)
            self::$instance = new Registry();
        
        return self::$instance;
    }
    
    public function get($StKey){
        if($this->ArStorage->offsetExists($StKey))
            return $this->ArStorage->offsetGet($StKey);
        else
            throw new RuntimeException(sprintf('Não existe um registro para a chave "%s".' , $StKey));
    }
    
    public function set($StKey, $MxValue){
        if(!$this->ArStorage->offsetExists($StKey))
            $this->ArStorage->offsetSet ($StKey, $MxValue);
        else
            throw new Exception(sprintf('Já existe um registro para a chave %s', $StKey));
    }
    
    public function __isset($StKey) {
        return $this->ArStorage->offsetExists($StKey);
    }
    
    public function unregister($StKey){
        if($this->ArStorage->offsetExists($StKey))
            $this->ArStorage->offsetUnset ($StKey);
        else
            throw new Exception(sprintf ('Não existe registro para a chave %s', $StKey));    
    }
    
}

?>
