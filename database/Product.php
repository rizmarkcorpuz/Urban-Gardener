<?php

// Use to fetch product data
class Product
{
    public $db = null;

    public function __construct(DBController $db)
    {
        if (!isset($db->con)) return null;
        $this->db = $db;
    }

    // fetch product data using getData Method
    public function getData($table = 'product'){
        $result = $this->db->con->query("SELECT * FROM {$table}");

        $resultArray = array();

        // fetch product data one by one
        while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $resultArray[] = $item;
        }

        return $resultArray;
    }

    // get product using item id
    public function getProduct($item_id = null, $table= 'product'){
        if (isset($item_id)){
            $query = "SELECT * FROM {$table} WHERE item_id={$item_id}";
            $result = $this->db->con->query($query);


            $resultArray = array();

            // fetch product data one by one
            while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $resultArray[] = $item;
            }

            return $resultArray;
        }
    }

    //Get user_id on cart
    public function getUserID($user_id = null, $table = 'cart'){
        if($user_id != null){
            $query = "SELECT * FROM {$table} WHERE user_id={$user_id}";

            $result = $this->db->con->query($query);
            $row = mysqli_fetch_assoc($result);

            // fetch product data one by one
            while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $_SESSION['user_id'] = $row['user_id'];
            }
        }
    }

}