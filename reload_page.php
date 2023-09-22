<?php 

include('config.php');
if(isset($_POST['delete_review'])){
    $review_id = $_POST['review_id'];
    mysqli_query($conn, "DELETE FROM `review_table` WHERE review_id ='$review_id'") or die("query failed");

    echo '<script type="text/javascript">';
    echo 'alert("Delete Review Successfully")';  //not showing an alert box.
    echo '</script>';
    echo "<script>window.location.href='./product#review'</script>";
    
}
?>