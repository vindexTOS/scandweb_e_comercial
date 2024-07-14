<?php 
namespace App\Models\Category;


use App\Database\DatabaseContext;





 interface CategoryInterface {
    public static function getCategory(DatabaseContext $dbContext, int $id = null);
    public static function getAllCategories(DatabaseContext $dbContext) ;
 }