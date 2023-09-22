<?php
ob_start();
//include header.php file
include ('header.php');

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username']->username;
    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_POST['user_id'] = $row['user_id'];
        //echo $_POST['user_id'];
    } else {
        echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
    }
}

if(isset($_POST['review_link'])){
    $item_id = $_POST['review_item_id'];
    $_SESSION['item_id'] = $item_id;
    
    echo "<script>window.location.href='./product#review'</script>";
}

if(isset($_POST['delete_review_urban'])){
    $review_id = $_POST['review_id'];
    mysqli_query($conn, "DELETE FROM `review_urban` WHERE review_id ='$review_id'") or die("query failed");

    echo '<script type="text/javascript">';
    echo 'alert("Delete Review Successfully")';  //not showing an alert box.
    echo '</script>';
    echo "<script>window.top.location='./reviews'</script>";
}

date_default_timezone_set("Asia/Hong_Kong");
function review_time_ago($timestamp){
    $timeago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $timeago;
    $seconds = $time_difference;
    $minutes = round($seconds / 60); // value 60 is seconds
    $hours = round($seconds / 3600); // value 3600 is 60 minutes * 60 seconds
    $days = round($seconds / 86400); // 86400 = 24 * 60 * 60
    $weeks = round($seconds / 604800); // 7*24*60*60
    $months = round($seconds / 2629440); // ((365+365+365+365+366)/5/12) * 24 * 60 * 60
    $years = round($seconds / 31553280); // (365+365+365+365+366)/5 * 24 * 60 * 60

    if($seconds <= 60){

        return "Just Now";

    }else if($minutes <=60){

        if($minutes == 1){

            return "one minute ago";

        }else{

            return "$minutes minutes ago";

        }
        
    }else if($hours <=24){

        if($hours == 1){

            return "an hour ago";

        }else{

            return "$hours hrs ago";

        }

    }else if($days <=7){

        if($days == 1){

            return "yesterday";

        }else{

            return "$days days ago";

        }
    //4.3 == 52/12
    }else if($weeks <= 4.3){

        if($weeks == 1){

            return "a week ago";

        }else{

            return "$weeks weeks ago";

        }

    }else if($months <=12){

        if($months == 1){

            return "a month ago";

        }else{

            return "$months months ago";

        }

    }else{

        if($years == 1){

            return "one year ago";

        }else{

            return "$years years ago";

        }
    }
}

?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>




<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">


        <!--  Pending Orders   -->
        <div class="container py-2">
            <h4 class="font-eduvic font-size-24" style="color:black; padding-top:100px;">Reviews</h4>
            <hr>
        </div>

        <div class="container">

            <div class="container py-1 my-1">
                <h6>Check out the below reviews for our website</h6>
                <div class="row">
                    <div class="col">
                    <label class="switchs" style="float:right;">
                        <input type="checkbox" id="toggleReview">
                        <span class="sliders"></span>
                    </label>
                    <h6 id="toggleName" style="float:right; top:0;margin-left:10px;">Page Reviews</h6>
                    <h6 style="float:right; top:0;">Filter By:</h6>
                    
                    </div>
                </div>
                
                <div class="row font-rale">

                    
                    <input type="hidden" id="getUsername" value="<?= $username; ?>">
                    <div id="showComments"></div> 
                            
                      

                    <div id="showCommentss" style="width:1120px;"></div>
                    
                </div>
            </div>
        </div>
    </div>

<style>
    .progress-label-left
    {
        float: left;
        margin-right: 0.5em;
        line-height: 1em;
    }
    .progress-label-right
    {
        float: right;
        margin-left: 0.3em;
        line-height: 1em;
    }
    .star-light
    {
        color:#e9ecef;
    }
</style>

<script src="index.js"></script>

<script>

    
function getReviewId(review_id){

    var rating_data = 1;

    review_name = "#add_review"  + review_id;
    review_modal = "#review_modal" + review_id;
    console.log(review_name);
    console.log(review_modal);

    $(review_modal).modal('show');

    $(document).on('mouseenter', '.submit_star', function(){

    var rating = $(this).data('rating');

    reset_background();

    for(var count = 1; count <= rating; count++)
    {

        $('#submit_star_'+count+review_id).addClass('text-warning');

    }

    });

    function reset_background()
        {
            for(var count = 1; count <= 5; count++)
            {

                $('#submit_star_'+count+review_id).addClass('star-light');

                $('#submit_star_'+count+review_id).removeClass('text-warning');

            }
        }

        $(document).on('mouseleave', '.submit_star', function(){

            reset_background();

            for(var count = 1; count <= rating_data; count++)
            {

                $('#submit_star_'+count+review_id).removeClass('star-light');

                $('#submit_star_'+count+review_id).addClass('text-warning');
            }

        });

        $(document).on('click', '.submit_star', function(){

            rating_data = $(this).data('rating');

        });

        $('#save_review'+review_id).click(function(){

            var item_id = $('#item_id'+review_id).val();

            var item_name = $('#item_name'+review_id).val();

            var user_name = $('#user_name'+review_id).val();

            var first_name = $('#first_name'+review_id).val();

            var last_name = $('#last_name'+review_id).val();

            var user_image = $('#user_image'+review_id).val();

            var user_review = $('#user_review'+review_id).val();


            if(user_name == '' || user_review == '')
            {
                alert("Please Fill Both Field");
                return false;
            }
            else
            {
                $.ajax({
                    url:"submit_rating.php",
                    method:"POST",
                    data:{rating_data:rating_data, item_id:item_id, item_name:item_name, user_name:user_name, first_name:first_name, last_name:last_name, user_image:user_image, user_review:user_review},
                    success:function(data)
                    {
                        $('#review_modal').modal('hide');
                        $('#modal').modal('hide'); 
                        $('body').removeClass('modal-open'); 
                        $('.modal-backdrop').remove();
                        
                        showCommentss();

                        alert(data);

                        //alert('Update Completed.');
                        //window.stop();
                        //window.top.location='./reviews.php';
                        
                    }
                })
            }

        });

}

$('#toggleReview').on('click', function (){
    var x = document.getElementById("toggleReview");
    var y = document.getElementById("toggleName");
    var username = $('#getUsername').val();
    //var toggleName = $('#toggleName').html();
    //alert(username);
    if(x.checked == true){
        //console.log(x);
    
        y.innerHTML = "Product Reviews";
        toggleName = "Product Reviews";

        $.ajax({
        url:"fetch-review-urban.php",
        method:"POST",
        data: {username: username, toggleName: toggleName},
            success:function(response) {
                $('#showComments').html(response);
                //dropdown();
            }
        })

        $.ajax({
        url:"fetch-review-plant.php",
        method:"POST",
        data: {username: username, toggleName: toggleName},
            success:function(response) {
                $('#showCommentss').html(response);
                //dropdown();
            }
        })

    }else{
        
        y.innerHTML = "Page Reviews";
        toggleName = "Page Reviews";
        //console.log(x); 

        $.ajax({
        url:"fetch-review-urban.php",
        method:"POST",
        data: {username: username, toggleName: toggleName},
            success:function(response) {
                $('#showComments').html(response);
                dropdown();
            }
        })

        $.ajax({
        url:"fetch-review-plant.php",
        method:"POST",
        data: {username: username, toggleName: toggleName},
            success:function(response) {
                $('#showCommentss').html(response);
                dropdown();
            }
        })
        
    }

    

    console.log(toggleName);
})



</script>
</body>
</html>

<?php
// footer.php
include ('footer.php');
?>