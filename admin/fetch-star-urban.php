<?php

include('config.php');

if(isset($_POST['rating_data'])){

    echo "Working";

    $user_rating = $_POST['rating_data'];
    //$reviewHTML .= $user_rating . 'asdasda';

    $i = 0;
    while($i < $user_rating){

        echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
        $i++;
    }
    

}else{
    echo "not working";
}
?>
