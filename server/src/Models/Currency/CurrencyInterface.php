<?php

namespace App\Models\Currency;

use App\Database\DatabaseContext;

interface CurrencyInterface { 


   public function toArray():array; 
   static public function getCurrency(DatabaseContext $dbContext, int $id = null);
   static public function getAllCurrencies(DatabaseContext $dbContext);
}