<?php

    if(isset($_POST['size'])){

        $sizes = ($_POST['size'] + $_POST['potvalue']) * $_POST['input'];
    

        $size = number_format($sizes, 2, '.', '');

        echo json_encode($size);
    }

    if(isset($_POST['size_popup'])){

        $size_popup = $_POST['size_popup'];

        echo json_encode($size_popup);
    }
?>

