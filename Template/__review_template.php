<?php
$user_id = $_SESSION['username']->user_id ?? 0;
$item_id = $_SESSION['item_id'];

$product_query = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id ='$item_id'") or die("query failed");
$row = mysqli_fetch_assoc($product_query);
$item_name = $row['item_name'];
$user_query = mysqli_query($conn, "SELECT * FROM `user` WHERE user_id ='$user_id'") or die("query failed");
$fetch_user = mysqli_fetch_assoc($user_query);
$first_name = $fetch_user['first_name'];
$last_name = $fetch_user['last_name'];
//echo $item_id;
//echo $user_id;


?>


<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<?php 

    $review_query = mysqli_query($conn, "SELECT * FROM review_table WHERE item_id = '$item_id' AND parent_id = '0' ORDER BY review_id DESC");
    $total_rating = 0;
    $average_rating = 0;
    $total_review = 0;
    $rounded_rating = 0;
    $five_star_review = 0;
    $four_star_review = 0;
    $three_star_review = 0;
    $two_star_review = 0;
    $one_star_review = 0;
    $total_user_rating = 0;
    $i = 0;
    while($fetch_review = mysqli_fetch_assoc($review_query)){
        $full_name = $fetch_review['first_name'] . " " . $fetch_review['last_name'];
        $time_ago = $fetch_review['datetime'];
        $review_time = date('Y-m-d H:i:s', $time_ago);
        $user_image = $fetch_review['user_image'];
        $user_review = $fetch_review['user_review'];
        $user_name = $fetch_review['user_name'];
        $review_id = $fetch_review['review_id'];
        $user_rating = $fetch_review['user_rating'];
        $total_rating = $total_rating + $user_rating;
        $total_review++;
        $average_rating = $total_rating/$total_review;

        if($fetch_review["user_rating"] == '5')
        {
            $five_star_review++;
        }

        if($fetch_review["user_rating"] == '4')
        {
            $four_star_review++;
        }

        if($fetch_review["user_rating"] == '3')
        {
            $three_star_review++;
        }

        if($fetch_review["user_rating"] == '2')
        {
            $two_star_review++;
        }

        if($fetch_review["user_rating"] == '1')
        {
            $one_star_review++;
        }
    }

    if($five_star_review != 0){
        $five_star_progress = ($five_star_review/$total_review * 100) . '%';
    }

    if($four_star_review != 0){
        $four_star_progress = ($four_star_review/$total_review * 100) . '%';
    }

    if($three_star_review != 0){
        $three_star_progress = ($three_star_review/$total_review * 100) . '%';
    }

    if($two_star_review != 0){
        $two_star_progress = ($two_star_review/$total_review * 100) . '%';
    }

    if($one_star_review != 0){
        $one_star_progress = ($one_star_review/$total_review * 100) . '%';
    }    
    
?>


    
    <input type="hidden" id="getUsername" value="<?= $username ?? 0; ?>">
    <input type="hidden" id="getItemId" value="<?= $item_id ?? 0; ?>">

    
    <div class="mt-5" id="showPlantReviews"></div>



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

<script>

    $(document).ready(function(){

        var rating_data = 1;

        $('#add_review').click(function(){

            $('#review_modal').modal('show');

        });

        $(document).on('mouseenter', '.submit_star', function(){

            var rating = $(this).data('rating');

            reset_background();

            for(var count = 1; count <= rating; count++)
            {

                $('#submit_star_'+count).addClass('text-warning');

            }

        });

        function reset_background()
        {
            for(var count = 1; count <= 5; count++)
            {

                $('#submit_star_'+count).addClass('star-light');

                $('#submit_star_'+count).removeClass('text-warning');

            }
        }

        $(document).on('mouseleave', '.submit_star', function(){

            reset_background();

            for(var count = 1; count <= rating_data; count++)
            {

                $('#submit_star_'+count).removeClass('star-light');

                $('#submit_star_'+count).addClass('text-warning');
            }

        });

        $(document).on('click', '.submit_star', function(){

            rating_data = $(this).data('rating');

        });

        $('#save_review').click(function(){

            var item_id = $('#item_id').val();

            var item_name = $('#item_name').val();

            var user_name = $('#user_name').val();

            var first_name = $('#first_name').val();

            var last_name = $('#last_name').val();

            var user_image = $('#user_image').val();

            var user_review = $('#user_review').val();


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

                        showPlantReviews();
                        dropdown();

                        alert(data);
                    }
                })
            }

        });

        //load_rating_data();

        function load_rating_data()
        {
            $.ajax({
                url:"submit_rating.php",
                method:"POST",
                data:{action:'load_data'},
                dataType:"JSON",
                success:function(data)
                {
                    $('#average_rating').text(data.average_rating);
                    $('#total_review').text(data.total_review);

                    var count_star = 0;

                    $('.main_star').each(function(){
                        count_star++;
                        if(Math.ceil(data.average_rating) >= count_star)
                        {
                            $(this).addClass('text-warning');
                            $(this).addClass('star-light');
                        }
                    });

                

                    if(data.review_data.length > 0)
                    {
                        var html = '';

                        for(var count = 0; count < data.review_data.length; count++){

                            if(data.review_data[count].parent_id == 0){

                                html += '<div class="row mb-3">';

                                if(data.review_data[count].user_image == ""){

                                    html += '<div class="col-sm-1" style="display:flex; justify-content:center;align-items:center;"><img src="./assets/LOGO.png" style="border-radius: 50%;" alt="User Image" width="80" height="80"></div>';

                                }else{
                                    html += '<div class="col-sm-1" style="display:flex; justify-content:center;align-items:center;"><img src="'+data.review_data[count].user_image+'" style="border-radius: 50%;" alt="User Image" width="80" height="80"></div>';
                                }

                                html += '<div class="col-sm-11">';

                                html += '<div class="card">';

                                html += '<div class="card-header"><b>'+data.review_data[count].first_name + " " + data.review_data[count].last_name+'</b></div>';

                                html += '<div class="card-body">';

                                for(var star = 1; star <= 5; star++)
                                {
                                    var class_name = '';

                                    if(data.review_data[count].rating >= star)
                                    {
                                        class_name = 'text-warning';
                                    }
                                    else
                                    {
                                        class_name = 'star-light';
                                    }

                                    html += '<i class="fas fa-star '+class_name+' mr-1"></i>';
                                }

                                html += '<br />';

                                html += data.review_data[count].user_review;

                                html += '</div>';

                                html += '<div class="card-footer text-right">'+data.review_data[count].datetime+'</div>';

                                html += '</div>';

                                html += '</div>';

                                html += '</div>';

                                $review_id = data.review_data[count].review_id;
                                $parent_id = data.review_data[count].parent_id;
                                //console.log($review_id);
                                
                            }
                            
                        }

                        $('#review_content').html(html);
                    }
                }
            })
        }

    });

</script>
