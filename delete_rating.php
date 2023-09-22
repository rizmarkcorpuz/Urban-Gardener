<?php 

include('config.php');
if(isset($_POST['delete_id'])){
    $review_id = $_POST['delete_id'];
    mysqli_query($conn, "DELETE FROM `review_table` WHERE review_id ='$review_id'") or die("query failed");

    echo "Your Review & Rating Successfully Deleted";
}
?>