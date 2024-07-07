<?php
namespace App\Models\Gallery;



class Gallery {
    
    
    private string $url;
    private int $product_id;
    
    public function __construct(string $url, int $product_id){
        
        $this->url = $url;
        $this->product_id = $product_id;
    }
    
    public function getUrl():string 
    {
        return $this->url;
    }
    
    public function getProductId():int
    {
        return $this->product_id;
    }
    
}