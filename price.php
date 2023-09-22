<?php

if(isset($_POST['price'])){

    $price = $_POST['price'];

    echo json_encode($price);
}
?>