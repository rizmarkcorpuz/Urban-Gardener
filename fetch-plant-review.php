<?php

include('config.php');

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
if(isset($_POST['username'])){

    $username = $_POST['username'];
    $item_id = $_POST['item_id'];
    

    $product_query = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id ='$item_id'") or die("query failed");
    $row = mysqli_fetch_assoc($product_query);
    $item_name = $row['item_name'];

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

<div class="container">
    <h1 class="mt-5 mb-5 font-eduvic" id="review">Review & Rating</h1>
    <input type="hidden" id="getUsername" value="<?= $username ?? 0; ?>">
    <input type="hidden" id="getItemId" value="<?= $item_id ?? 0; ?>">
    <div class="card">
        <div class="card-header font-baloo"><?php echo $row['item_name']?? "Unknown"; ?></div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4 text-center">
                    <h1 class="text-warning mt-4 mb-4">
                        <b><span id=""><?= number_format($average_rating, 1); ?></span> / 5</b>
                    </h1>
                    <div class="mb-3" style="color:#f6c23e;">
                        <?php 
                        if($average_rating >= 0 && $average_rating <= 0.49){
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                        }elseif($average_rating <= 0.99 && $average_rating >= 0.5){
                            echo '<i class="fas fa-star-half-alt mr-1"></i>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                        }elseif($average_rating >= 1 && $average_rating <= 1.49){
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                        }elseif($average_rating <= 1.99 && $average_rating >= 1.5){
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star-half-alt mr-1"></i>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                        }elseif($average_rating >= 2 && $average_rating <= 2.49){
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                        }elseif($average_rating <= 2.99 && $average_rating >= 2.5){
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<span><i class="fas fa-star-half-alt mr-1"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                        }elseif($average_rating >= 3 && $average_rating <= 3.49){
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                        }elseif($average_rating <= 3.99 && $average_rating >= 3.5 ){
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star-half-alt mr-1"></i>';
                            echo '<i class="fas fa-star star-light mr-1 main_star"></i>';
                        }elseif($average_rating >= 4 && $average_rating <= 4.49){
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                        }elseif($average_rating <= 4.99 && $average_rating >= 4.5){
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star-half-alt mr-1 main_star"></i>';
                        }elseif($average_rating == 5){
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        }else{
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                            echo '<span><i class="fas fa-star star-light mr-1 main_star"></i></span>';
                        }
                        ?>
                    </div>
                    <h3 class="font-baloo"><span id=""><?= $total_review; ?></span> Review</h3>
                </div>
                <div class="col-sm-4">
                    <p>
                    <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>

                    <div class="progress-label-right">(<span id=""><?= $five_star_review; ?></span>)</div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="" style="width:<?= $five_star_progress; ?>"></div>
                    </div>
                    </p>
                    <p>
                    <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>

                    <div class="progress-label-right">(<span id=""><?= $four_star_review; ?></span>)</div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="" style="width:<?= $four_star_progress; ?>"></div>
                    </div>
                    </p>
                    <p>
                    <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>

                    <div class="progress-label-right">(<span id=""><?= $three_star_review; ?></span>)</div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="" style="width:<?= $three_star_progress; ?>"></div>
                    </div>
                    </p>
                    <p>
                    <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>

                    <div class="progress-label-right">(<span id=""><?= $two_star_review; ?></span>)</div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="" style="width:<?= $two_star_progress; ?>"></div>
                    </div>
                    </p>
                    <p>
                    <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>

                    <div class="progress-label-right">(<span id=""><?= $one_star_review; ?></span>)</div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="" style="width:<?= $one_star_progress; ?>"></div>
                    </div>
                    </p>
                </div>
                <div class="col-sm-4 text-center">
                    <h3 class="mt-4 mb-3 font-baloo">Write Review Here</h3>
                    <button type="button" name="add_review" id="add_review" class="btn btn-success font-baloo">Review</button>
                </div>
            </div>
        </div>
    </div>

    <?php 
    $select_user = mysqli_query($conn, "SELECT * FROM `user` WHERE username = '$username'") or die("query failed");
    if(mysqli_num_rows($select_user) > 0){
        while($fetch_user = mysqli_fetch_assoc($select_user)){
            $username = $fetch_user['username'];
            $user_image = $fetch_user['user_image'];
            $first_name = $fetch_user['first_name'];
            $last_name = $fetch_user['last_name'];
            $full_name = $first_name . " " . $last_name;
        }
    }  
    ?>

    <div id="review_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Submit Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center mt-2 mb-4">
                        <i class="fas fa-star text-warning submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                    </h4>
                    <div class="form-group">
                        <input type="hidden" name="item_id" id="item_id" value="<?php echo $item_id ?? 0; ?>">
                        <input type="hidden" name="item_name" id="item_name" value="<?php echo $item_name ?? 0; ?>">

                        <input type="hidden" name="user_name" id="user_name" value="<?php echo $username ?? "Unknown"; ?>" class="form-control" placeholder="Enter Your Name" />
                        <input type="hidden" name="first_name" id="first_name" value="<?php echo $first_name ?? "Unknown"; ?>" class="form-control" placeholder="Enter Your Name" />
                        <input type="hidden" name="last_name" id="last_name" value="<?php echo $last_name ?? "Unknown"; ?>" class="form-control" placeholder="Enter Your Name" />
                        <input type="hidden" name="user_image" id="user_image" value="<?= $user_image ?? "Unknown"; ?>" class="form-control" placeholder="Enter Your Name" />
                    </div>
                    <div class="form-group">
                        <textarea name="user_review" id="user_review" class="form-control" placeholder="Type Review Here"></textarea>
                    </div>
                    <div class="form-group text-center mt-4">
                        <button type="button" class="btn btn-success" id="save_review">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php
            $reviewHTML = '';

            $review_query = mysqli_query($conn, "SELECT * FROM `review_table` WHERE item_id = '$item_id' AND parent_id = '0' ") or die("query failed");
            $total_rating = 0;
            $average_rating = 0;
            $total_review = 0;
            $rounded_rating = 0;
            $i = 0;

            while($fetch_review = mysqli_fetch_assoc($review_query)){
                $user_rating = $fetch_review['user_rating'];
                $user_review = $fetch_review['user_review'];
                $review_id = $fetch_review['review_id'];
                $first_name = $fetch_review['first_name'];
                $last_name = $fetch_review['last_name'];
                $full_name = $first_name . " " . $last_name;

                $total_rating = $total_rating + $user_rating;
                $total_review++;
                $average_rating = $total_rating/$total_review;
                $rounded_rating = (round($average_rating,1));
                $time_ago = $fetch_review['datetime'];
            
            }

            
                //item id need to declare
                $product_query = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id = '$item_id'") or die('query failed');
                $row = mysqli_fetch_assoc($product_query);
                $item_name = $row['item_name'];         
                
                $select_user = mysqli_query($conn, "SELECT * FROM `user` WHERE username = '$username'") or die("query failed");
                    if(mysqli_num_rows($select_user) > 0){
                        while($fetch_user = mysqli_fetch_assoc($select_user)){
                            $username = $fetch_user['username'];
                            $user_image = $fetch_user['user_image'];
                            $first_name = $fetch_user['first_name'];
                            $last_name = $fetch_user['last_name'];
                            $full_name = $first_name . " " . $last_name;
                        }
                    }  


            // item id need to declare
            $review_query = mysqli_query($conn, "SELECT * FROM `review_table`  WHERE item_id = '$item_id' AND parent_id = '0' ORDER BY datetime DESC") or die("query failed");
            $total_rating = 0;
            $average_rating = 0;
            $total_review = 0;
            $rounded_rating = 0;
            $reviewPlantHTML = '';
            $i = 0;

            while($fetch_review = mysqli_fetch_assoc($review_query)){
                $user_name = $fetch_review['user_name'];
                $user_rating = $fetch_review['user_rating'];
                $user_review = $fetch_review['user_review'];
                $id_review = $fetch_review['review_id'];
                $first_name = $fetch_review['first_name'];
                $last_name = $fetch_review['last_name'];
                $user_image = $fetch_review['user_image'];
                //$parent_id = $fetch_review['parent_id'];
                $full_name = $first_name . " " . $last_name;

                $total_rating = $total_rating + $user_rating;
                $total_review++;
                $average_rating = $total_rating/$total_review;
                $rounded_rating = (round($average_rating,1));
                $time_ago = $fetch_review['datetime'];

            $reviewHTML .= '<div class="row mb-3">';


                if($user_image == ""){
                    $reviewHTML .= '<div class="col-sm-1" style="display:flex; justify-content:center;align-items:center;"><img src="./assets/LOGO.png" style="border-radius: 50%;" alt="User Image" width="80" height="80"></div>';
                }else{
                    $reviewHTML .= '<div class="col-sm-1" style="display:flex; justify-content:center;align-items:center;"><img src="'. $user_image . '" style="border-radius: 50%;" alt="User Image" width="80" height="80"></div>';
                }
                
                $reviewHTML .= '<div class="col-sm-11">';
                $review_time = date('Y-m-d H:i:s', $time_ago);
                

                $reviewHTML .= '<div class="card">
                <div class="card-header"><b>'. $full_name .'</b><h6 style="float:right; font-size:14px; color:gray;">' . review_time_ago($review_time) . '</h6></div>
                <div class="card-body">';
            
                $i = 0;
                    //echo number_format($user_rating,1) . PHP_EOL;
                    while($i < $user_rating){

                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $i++;
                    }
                   
 
                    //echo review_time_ago('2016-03-11 04:58:00'); 
                    //echo $review_time;
                    //$reviewHTML .= $id_review;
                                        
                    $reviewHTML .='
                    <br/ >
                    '. $user_review .'
                    </div>
                    <div class="card-footer text-right" style="">
                    ';
                    

                    if($username === $user_name){
                        //$reviewHTML .= $user_name;
                            
                    $reviewHTML .='
                        <div class="dropdown" style="float:right;">
                            <div class="select">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                </svg>
                                
                            </div>
                            <ul class="menu border">
                                <form action="" method="post">
                                    <input type="hidden" name="review_id" value="' . $fetch_review['review_id'] .' ">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="no-style-button" data-toggle="modal" data-target="#deleteReview' . $review_id .'">
                                    Delete
                                    </button>
                                </form>           
                            </ul>
                        </div>';
                    }else{
                        $reviewHTML .='
                        <div class="dropdown" style="float:right;">
                            <div class="select">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16" style="opacity:0;cursor:default;">
                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                </svg>
                                
                            </div>
                        </div>';
                    }

                    $reviewHTML .= '
                    
                    </div>';

                    $reviewHTML .='
                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteReview' . $review_id . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:black;">Delete Review</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body" style="color:black;">
                                        Are you sure you want to delete this review?
                                    </div>

                                    <div class="modal-footer">

                                        <form action="reload_page" method="post">
                                            <input type="hidden" name="review_id" id="deleteReviewId" value="' . $review_id .' ">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" name="delete_review" id="delete_review" class="btn btn-danger">Delete</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>';

                $reviewHTML .= '
                            
                        </div>
                    </div>
                </div>';
                
                $reviewHTML .= getCommentReply($conn, $fetch_review['review_id']);
            }     
            $reviewHTML .= '</div>' ;
    
    echo $reviewHTML;           
           
}

function getCommentReply($conn, $parentId = 0, $marginLeft = 0){
    $username = $_POST['username'];
    $reviewHTML = '';
    $total_rating = 0;
    $average_rating = 0;
    $total_review = 0;
    $rounded_rating = 0;
    $i = 0;
    $review_all_query = mysqli_query($conn, "SELECT * FROM `review_table` WHERE parent_id = '".$parentId."'");
    $reviewCount = mysqli_num_rows($review_all_query);
    if($parentId == 0){
        $marginLeft = 0;
    }else{
        $marginLeft = $marginLeft + 48;
    }
    if($reviewCount > 0){
        while($fetch_review = mysqli_fetch_assoc($review_all_query)){
            $full_name = $fetch_review['first_name'] . " " . $fetch_review['last_name'];
            $time_ago = $fetch_review['datetime'];
            $review_time = date('Y-m-d H:i:s', $time_ago);
            $user_review = $fetch_review['user_review'];
            $user_name = $fetch_review['user_name'];
            $user_image = $fetch_review['user_image'];
            $review_id = $fetch_review['review_id'];
            $user_rating = $fetch_review['user_rating'];
            $total_rating = $total_rating + $user_rating;
            $total_review++;
            $average_rating = $total_rating/$total_review;

            
            $reviewHTML .= '<div class="row mb-3" style="margin-left:'. $marginLeft .'px">';


                if($user_image == ""){
                    $reviewHTML .= '<div class="col-sm-1" style="display:flex; justify-content:center;align-items:center;"><img src="./assets/LOGO.png" style="border-radius: 50%;" alt="User Image" width="80" height="80"></div>';
                }else{
                    $reviewHTML .= '<div class="col-sm-1" style="display:flex; justify-content:center;align-items:center;"><img src="'. $user_image . '" style="border-radius: 50%;" alt="User Image" width="80" height="80"></div>';
                }
                
                $reviewHTML .= '<div class="col-sm-11">';
                $review_time = date('Y-m-d H:i:s', $time_ago);
                

                $reviewHTML .= '<div class="card">
                <div class="card-header" style="background-color:#e0f2d8;">Replied by <b>'. $full_name .'</b><h6 style="float:right; font-size:14px; color:gray;">' . review_time_ago($review_time) . '</h6></div>
                <div class="card-body" style="background-color:#cff7be;">';
                
                    //echo review_time_ago('2016-03-11 04:58:00'); 
                    //echo $review_time;
                    //$reviewHTML .= $id_review;
                                        
                    $reviewHTML .='
                    '. $user_review .'
                    </div>
                    <div class="card-footer text-right" style="background-color:#e0f2d8;">
                    ';
                    

                    if($username === $user_name){
                        //$reviewHTML .= $user_name;
                            
                    $reviewHTML .='
                        <div class="dropdown" style="float:right;">
                            <div class="select">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                </svg>
                                
                            </div>
                            <ul class="menu border">
                                <form action="" method="post">
                                    <input type="hidden" name="review_id" value="' . $fetch_review['review_id'] .' ">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="no-style-button" data-toggle="modal" data-target="#deleteReview' . $review_id .'">
                                    Delete
                                    </button>
                                </form>           
                            </ul>
                        </div>';
                    }else{
                        $reviewHTML .='
                        <div class="dropdown" style="float:right;">
                            <div class="select">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16" style="opacity:0;cursor:default;">
                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                </svg>
                                
                            </div>
                        </div>';
                    }

                    $reviewHTML .= '
                    
                    </div>';

                    $reviewHTML .='
                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteReview' . $review_id . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:black;">Delete Review</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body" style="color:black;">
                                        Are you sure you want to delete this review?
                                    </div>

                                    <div class="modal-footer">

                                        <form action="" method="post">
                                            <input type="hidden" name="review_id" value="' . $review_id .' ">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" name="delete_review" class="btn btn-danger">Delete</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>';

                $reviewHTML .= '
                            
                        </div>
                    </div>
                </div>';
                
                $reviewHTML .= getCommentReply($conn, $fetch_review['review_id']);
        }
    }
    return $reviewHTML;
}
?>


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
                        alert(data);
                        //window.stop();
                        //window.location.reload(true);
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


<script>

    $('#delete_review').click(function(){

        var delete_id = $('#deleteReviewId').val();


        $.ajax({
            url:"delete_rating.php",
            method:"POST",
            data:{delete_id:delete_id},
            success:function(data)
            {
                $('#modal').modal('hide'); 
                $('body').removeClass('modal-open'); 
                $('.modal-backdrop').remove();

                showPlantReviews();
                alert(data);
                //window.stop();
                //window.location.reload(true);
            }
        })
        

    });

$(document).ready(function(){
    dropdown();
    console.log('working');
});

function dropdown (){
    const dropdowns = document.querySelectorAll('.dropdown');

    dropdowns.forEach(dropdown => {

    const select = dropdown.querySelector('.select');
    //const caret = dropdown.querySelector('.caret');
    const menu = dropdown.querySelector('.menu');
    const options = dropdown.querySelectorAll('.menu li');
    const selected = dropdown.querySelector('.selected');

        document.addEventListener('mousedown', (event) => {
            if (select?.contains(event.target)) {
                select.classList.toggle('select-clicked');
                //caret.classList.toggle('caret-rotate');
                menu.classList.toggle('menu-open');
            }else if(menu?.contains(event.target)){
                

            }else{
                select.classList.remove('select-clicked');
                menu?.classList.remove('menu-open');
            }
            
        })

    });
}

</script>
