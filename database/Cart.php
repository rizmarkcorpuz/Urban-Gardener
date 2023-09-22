<?php

//php cart class
class Cart
{
    public $db = null;

    public function __construct(DBController $db){

        if(!isset($db->con)) return null;
        $this->db = $db;
    }

    //insert into cart table
    public function insetIntoCart($params = null, $table = "cart"){
        if($this->db->con != null){
            if($params != null){
                //"Insert Into cart(user_id) values (0)"
                //get table columns
                $columns = implode(',',array_keys($params));

                $values = implode(',',array_values($params));


                //create sql query
                $query_string = sprintf("INSERT INTO %s(%s) VALUES(%s)", $table, $columns, $values);

                //execute query
                $result = $this->db->con->query($query_string);
                return $result;
            }
        }
    }

    //to get user_id and item_id and insert into cart table
    public function addToCart($userid, $itemid, $itemname, $itemprice, $itemimage){
        if(isset($userid) && isset($itemid)){
            $params = array(
                "user_id" => $userid,
                "item_id" => $itemid,
                "item_name" => $itemname,
                "item_price" => $itemprice,
                "item_image" => $itemimage
            );

            //insert data into cart
            $result = $this->insetIntoCart($params);
            if($result){
                //reload page
                header("Location: " .$_SERVER['PHP_SELF'], $itemid);
            }else{

            }
        }
    }

    //to get user_id and item_id and insert into cart table
    public function addToCartProduct($userid, $itemid, $itemname, $itemprice, $itemimage){
        if(isset($userid) && isset($itemid)){
            $params = array(
                "user_id" => $userid,
                "item_id" => $itemid,
                "item_name" => $itemname,
                "item_price" => $itemprice,
                "item_image" => $itemimage
            );

            $check_duplicate_product = $this->db->con->query("SELECT item_id FROM cart where item_id={$itemid}");

            $count = mysqli_num_rows($check_duplicate_product);

            //insert data into cart
            if($count > 0){
                echo '<script type="text/javascript">';
                echo 'alert("Item already in the cart")';  //not showing an alert box.
                echo '</script>';

            }else{
                $result = $this->insetIntoCart($params);
                if($result){
                    header("Location: " .$_SERVER['REQUEST_URI']);
                }
            }


        }
    }

    //to get user_id and item_id and insert into cart table
    public function proceedToBuyProduct($userid, $itemid){
        if(isset($userid) && isset($itemid)){
            $params = array(
                "user_id" => $userid,
                "item_id" => $itemid
            );

            $check_duplicate_product = $this->db->con->query("SELECT item_id FROM cart where item_id={$itemid}");

            $count = mysqli_num_rows($check_duplicate_product);

            //insert data into cart
            if($count > 0){
                echo '<script type="text/javascript">';
                echo 'alert("Item already in the cart")';  //not showing an alert box.
                echo '</script>';

            }else{
                $result = $this->insetIntoCart($params);
                if($result){
                    header("Refresh:0; url=cart.php");
                }
            }


        }
    }

    // delete cart item using cart item id
    public function deleteCart($cart_id = null, $table = 'cart'){
        if($cart_id != null){
            $result = $this->db->con->query("DELETE FROM {$table} WHERE cart_id={$cart_id}");
            if($result){
                header("Location:" . $_SERVER['PHP_SELF']);
            }
            return $result;
        }
    }


    //calculate sub total
    public function getSum($arr){
        if(isset($arr)){
            $sum = 0;
            foreach ($arr as $item){
                $sum += floatval($item[0]);
            }
            return sprintf('%.2f', $sum);
        }
    }

    //get item_id of shopping cart list
    public function getCartId($cartArray = null, $key = "user_id"){
        if($cartArray != null){
            $cart_id = array_map(function ($value) use($key){
                return $value[$key];
            }, $cartArray);
            return $cart_id;
        }

    }


    // Save for later
    public function saveForLater($item_id = null, $user_id = null, $saveTable = "wishlist", $fromTable = "cart"){
        if ($item_id != null){
            $query = "INSERT INTO {$saveTable} SELECT * FROM {$fromTable} WHERE item_id={$item_id} AND user_id={$user_id};";
            $query .= "DELETE FROM {$fromTable} WHERE item_id={$item_id} AND user_id={$user_id};";

            // execute multiple query
            $result = $this->db->con->multi_query($query);

            if($result){
                header("Location: " . $_SERVER['PHP_SELF']);

            }
            return $result;
        }
    }

    // delete wishlist item using wishlist item id
    public function deleteWishlist($cart_id = null, $table = 'wishlist'){
        if($cart_id != null){
            $result = $this->db->con->query("DELETE FROM {$table} WHERE cart_id={$cart_id}");
            if($result){
                header("Location:" . $_SERVER['PHP_SELF']);
            }
            return $result;
        }
    }


}