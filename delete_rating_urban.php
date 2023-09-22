<?php 

include('config.php');
if(isset($_POST['delete_urban_id'])){
    $review_id = $_POST['delete_urban_id'];
    mysqli_query($conn, "DELETE FROM `review_urban` WHERE review_id ='$review_id'") or die("query failed");

    echo "Your Review & Rating Successfully Deleted";
}
?>