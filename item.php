<?php

if(isset($_POST['item_id'])){

    $item_id = $_POST['item_id'];

    echo json_encode($item_id);
}
?>

