<?php 



namespace App\Models\Gallery;



interface GalleryInterface {


    public function getUrl():string ;
    public function getProductId():int;
}