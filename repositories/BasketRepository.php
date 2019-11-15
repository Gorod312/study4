<?php

namespace app\repositories;

class BasketRepository extends Repository
{

    public function tableName(){
        return 'basket';
    }

    public function getBasket($session = null)
    {
        $sql = "SELECT i.id id_prod, b.id id_basket, i.name, i.description, i.price FROM basket b,item i WHERE b.product_id=i.id AND session_id = :session";
        return $this->db->queryAll($sql, [':session' => $session]);
    }

}