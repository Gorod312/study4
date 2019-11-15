<?php

namespace app\repositories;

class ProductRepository extends Repository
{
    public function tableName(){
        return 'item';
    }
}