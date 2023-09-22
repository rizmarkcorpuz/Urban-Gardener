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
    $toggleName = $_POST['toggleName'];

    if($username == ""){

        if($toggleName == "Product Reviews"){

            $review_all_query = mysqli_query($conn, "SELECT DISTINCT item_id FROM `review_table` ORDER BY review_id") or die('query failed');
            $reviewHTML = '';
            $total_rating = 0;
            $average_rating = 0;
            $total_review = 0;
            $rounded_rating = 0;
            $i = 0;
            //$reviewHTML = '';

            if(mysqli_num_rows($review_all_query) > 0){

                while($fetch_review = mysqli_fetch_assoc($review_all_query)){

                    $item_id = $fetch_review['item_id'];

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

            $reviewHTML .= '<div class="container m-2 p-4" style="background-color:white;">';
        ?>
            <?php 
                //item id need to declare
                $product_query = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id = '$item_id'") or die('query failed');
                $row = mysqli_fetch_assoc($product_query);
                $item_name = $row['item_name'];         
                
                $select_user = mysqli_query($conn, "SELECT * FROM `user` WHERE username = '$username'") or die("query failed");
                    if(mysqli_num_rows($select_user) > 0){
                        while($fetch_user = mysqli_fetch_assoc($select_user)){
                            $username = $fetch_user['username'];
                            $first_name = $fetch_user['first_name'];
                            $last_name = $fetch_user['last_name'];
                            $full_name = $first_name . " " . $last_name;
                        }
                    }  
                
    $reviewHTML .= '

        <div class="row">
            <div class="col">
            <div class="margin" style="margin-bottom:-20px;">
                <input type="hidden" id="getUsername" value="' . $username . '">
            <form action="" method="post" target="_blank">
                <h6 style="font-size:17px; color:black;"><b>Ratings & Reviews for ' . $item_name . '</b>
                    <input type="hidden" name="review_item_id" value="' . $item_id . '">
                    <button type="submit" name="review_link" class="hyperlink-style-button px-2 font-rale font-size-14">' . $total_review . ' reviews</button>
                </h6>
            </form>
                
                <p style="font-size:17px; color:black;display:inline-block;">Average: ' . number_format($average_rating, 1) . '/5.0</p>
                <h6 style="color:#f6c23e; display:inline;">';
            ?>
                    <?php 
                    //echo (round($average_rating,1) . PHP_EOL);
        
                    if($average_rating >= 0 && $average_rating <= 0.49){
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    }elseif($average_rating <= 0.99 && $average_rating >= 0.5){
                        $reviewHTML .= '<i class="fas fa-star-half-alt mr-1"></i>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    }elseif($average_rating >= 1 && $average_rating <= 1.49){
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    }elseif($average_rating <= 1.99 && $average_rating >= 1.5){
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star-half-alt mr-1"></i>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    }elseif($average_rating >= 2 && $average_rating <= 2.49){
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    }elseif($average_rating <= 2.99 && $average_rating >= 2.5){
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<span><i class="fas fa-star-half-alt mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    }elseif($average_rating >= 3 && $average_rating <= 3.49){
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    }elseif($average_rating <= 3.99 && $average_rating >= 3.5 ){
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star-half-alt mr-1"></i>';
                        $reviewHTML .= '<i class="far fa-star mr-1"></i>';
                    }elseif($average_rating >= 4 && $average_rating <= 4.49){
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    }elseif($average_rating <= 4.99 && $average_rating >= 4.5){
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star-half-alt mr-1 main_star"></i>';
                    }elseif($average_rating == 5){
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    }else{
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                        $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    }

    $reviewHTML .='
                </h6>
                </div>
            </div>
        </div>';
        ?>
        <?php
            // item id need to declare
            $review_query = mysqli_query($conn, "SELECT * FROM `review_table`  WHERE item_id = '$item_id' AND parent_id = '0' ORDER BY datetime DESC") or die("query failed");
            $total_rating = 0;
            $average_rating = 0;
            $total_review = 0;
            $rounded_rating = 0;
            $i = 0;
            while($fetch_review = mysqli_fetch_assoc($review_query)){
                $user_name = $fetch_review['user_name'];
                $user_rating = $fetch_review['user_rating'];
                $review = $fetch_review['user_review'];
                $id_review = $fetch_review['review_id'];
                $first_name = $fetch_review['first_name'];
                $last_name = $fetch_review['last_name'];
                //$parent_id = $fetch_review['parent_id'];
                $user_image = $fetch_review['user_image'];
                $full_name = $first_name . " " . $last_name;

                $total_rating = $total_rating + $user_rating;
                $total_review++;
                $average_rating = $total_rating/$total_review;
                $rounded_rating = (round($average_rating,1));
                $time_ago = $fetch_review['datetime'];

            
    $reviewHTML .='
            <hr>
            <div class="row" style="position:relative;">
                <div class="" style="width:100px;display:flex; justify-content:center;align-items:center;">';
        ?>
            <?php
                if($user_image == ""){
                    $reviewHTML .= '<img src="./assets/LOGO.png" alt="User Image" width="80" height="80">';
                }else{
                    $reviewHTML .= '<img src="' . $user_image .'" style="border-radius: 50%;" alt="User Image" width="80" height="80">';
                }
                
    $reviewHTML .='</div>
                <div class="col panel panel-primary">
                
            
                <h6><i>';
            ?>
                <?php
                        $i = 0;
                        //echo number_format($user_rating,1) . PHP_EOL;
                        while($i < $user_rating){
    
                            $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            $i++;
                        }
                        $review_time = date('Y-m-d H:i:s', $time_ago);
                        $reviewHTML .= '<h6 style="float:right; font-size:14px; color:gray;">' . review_time_ago($review_time) . '</h6>';
                        //echo review_time_ago('2016-03-11 04:58:00'); 
                        //echo $review_time;
                        //$reviewHTML .= $id_review;
    $reviewHTML .='
                        </i></h6>
                        <h6 style="color:black; font-size:14px; color:gray;">By <b style="color:black;">' . $full_name . '</b></h6>
                        <div class="panel-body">'. $review .'</div>
                        <br>';
            ?>
                <?php 
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
                                    <button type="submit" name="delete_review" class="no-style-button">Delete</button> 
                                </form>           
                            </ul>
                        </div>';
                    }
        
    $reviewHTML .= '
                            </div>
                        
                   
                </div>';
                
    $reviewHTML .= getCommentReply($conn, $fetch_review['review_id']);
            }     
    $reviewHTML .= '</div>' ;
            
            
                
                }
    
    echo $reviewHTML;
    //echo $reviewPlantHTML;
            }
       
        }else if($toggleName == "Page Reviews"){

            //echo $toggleName;
        }

    }else{

        if($toggleName == "Product Reviews"){
        
            $review_all_query = mysqli_query($conn, "SELECT DISTINCT item_id FROM `review_table` ORDER BY review_id") or die('query failed');
            $reviewHTML = '';
            $total_rating = 0;
            $average_rating = 0;
            $total_review = 0;
            $rounded_rating = 0;
            $i = 0;

            if(mysqli_num_rows($review_all_query) > 0){

                while($fetch_review = mysqli_fetch_assoc($review_all_query)){

                    $item_id = $fetch_review['item_id'];

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

                $reviewHTML .= '<div class="container m-2 p-4" style="background-color:white;">';

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

                $reviewHTML .= '
                <div class="margin" style="margin-bottom:-10px;">
                    <input type="hidden" id="getUsername" value="'. $username . '">
                    <form action="" method="post" target="_blank">
                        <h6 style="font-size:17px; color:black;"><b>Ratings & Reviews for ' . $item_name . ' </b>
                            <input type="hidden" name="review_item_id" value="'. $item_id . '">
                            <button type="submit" name="review_link" class="hyperlink-style-button px-2 font-rale font-size-14">' . $total_review  .  ' reviews</button>
                        </h6>
                    </form>
                    <p style="font-size:17px; color:black;display:inline-block;">Average: ' .  number_format($average_rating, 1) . '/5.0</p>
                    <h6 style="color:#f6c23e; display:inline;">
                
                ';
                

                if($average_rating >= 0 && $average_rating <= 0.49){
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                }elseif($average_rating <= 0.99 && $average_rating >= 0.5){
                    $reviewHTML .= '<i class="fas fa-star-half-alt mr-1"></i>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                }elseif($average_rating >= 1 && $average_rating <= 1.49){
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                }elseif($average_rating <= 1.99 && $average_rating >= 1.5){
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star-half-alt mr-1"></i>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                }elseif($average_rating >= 2 && $average_rating <= 2.49){
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                }elseif($average_rating <= 2.99 && $average_rating >= 2.5){
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<span><i class="fas fa-star-half-alt mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                }elseif($average_rating >= 3 && $average_rating <= 3.49){
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                }elseif($average_rating <= 3.99 && $average_rating >= 3.5 ){
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star-half-alt mr-1"></i>';
                    $reviewHTML .= '<i class="far fa-star mr-1"></i>';
                }elseif($average_rating >= 4 && $average_rating <= 4.49){
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                }elseif($average_rating <= 4.99 && $average_rating >= 4.5){
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star-half-alt mr-1 main_star"></i>';
                }elseif($average_rating == 5){
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                    $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                }else{
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                    $reviewHTML .= '<span><i class="far fa-star mr-1"></i></span>';
                }

            $reviewHTML .= '
            </h6>
            <button type="button" name="add_review<?php echo $item_id; ?>" onclick="getReviewId(' . $item_id . ')" id="add_review' . $item_id . '" class="btn btn-success font-baloo">Write Review</button>
                <div id="review_modal'.  $item_id . '"  class="modal" tabindex="-1" role="dialog">
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
                                    <i class="fas fa-star text-warning submit_star mr-1" id="submit_star_1' . $item_id . '" data-rating="1"></i>
                                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2' . $item_id . '" data-rating="2"></i>
                                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3' . $item_id . '" data-rating="3"></i>
                                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4' . $item_id . '" data-rating="4"></i>
                                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5' . $item_id . '" data-rating="5"></i>
                                </h4>
                                <div class="form-group">
                                    <input type="hidden" name="item_id" id="item_id' . $item_id . '" value="' . $item_id  . '">
                                    <input type="hidden" name="item_name" id="item_name' . $item_id . '" value="' . $item_name  . '">

                                    <input type="hidden" name="user_name" id="user_name' . $item_id . '" value="' . $username . '" class="form-control" placeholder="Enter Your Name" />
                                    <input type="hidden" name="first_name" id="first_name' . $item_id . '" value="' . $first_name . '" class="form-control" placeholder="Enter Your Name" />
                                    <input type="hidden" name="last_name" id="last_name' . $item_id . '" value="' . $last_name . '" class="form-control" placeholder="Enter Your Name" />
                                    <input type="hidden" name="user_image" id="user_image' . $item_id . '" value="' . $user_image . '" class="form-control" placeholder="Enter Your Name" />
                                </div>
                                <div class="form-group">
                                    <textarea name="user_review" id="user_review' . $item_id . '" class="form-control" placeholder="Type Review Here"></textarea>
                                </div>
                                <div class="form-group text-center mt-4">
                                    <button type="button" class="btn btn-success" id="save_review' . $item_id . '">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            
            ';
        
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

                $reviewHTML .= '
                <div class="row">
                    <div class="col">
                    <hr>
                    <div class="row" style="position:relative;">
                    <div class="" style="width:100px;display:flex; justify-content:center;align-items:center;">';

                    if($user_image == ""){
                        $reviewHTML .= '<img src="./assets/LOGO.png" alt="User Image" width="80" height="80">';
                    }else{
                        $reviewHTML .= '<img src="' . $user_image .'" style="border-radius: 50%;" alt="User Image" width="80" height="80">';
                    }
                    
                    $reviewHTML .= '
                    </div>
                    <div class="col panel panel-primary">
                    
                    <h6><i>
                ';
            
                $i = 0;
                    //echo number_format($user_rating,1) . PHP_EOL;
                    while($i < $user_rating){

                        $reviewHTML .= '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                        $i++;
                    }
                    $review_time = date('Y-m-d H:i:s', $time_ago);
                    $reviewHTML .= '<h6 style="float:right; font-size:14px; color:gray;">' . review_time_ago($review_time) . '</h6>';
                    //echo review_time_ago('2016-03-11 04:58:00'); 
                    //echo $review_time;
                    //$reviewHTML .= $id_review;
                                        
                    $reviewHTML .='
                    </i></h6>
                    <h6 style="color:black; font-size:14px; color:gray;">By <b style="color:black;">' . $full_name . '</b></h6>
                    <div class="panel-body">'. $user_review .'</div>
                    <br>';

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
                    }

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
                    </div>
                </div>';
                
                $reviewHTML .= getCommentReply($conn, $fetch_review['review_id']);
            }     
            $reviewHTML .= '</div>' ;
            
            
                
                }
    
    echo $reviewHTML;
    //echo $reviewPlantHTML;
            }
       
        }else if($toggleName == "Page Reviews"){

            //echo $toggleName;
        }
    
    }

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

            $reviewHTML .='<hr>';
            $reviewHTML .= '
            <div class="row" style="position:relative;">
                <div class="" style="width:100px;display:flex; justify-content:center;align-items:center;margin-left:'.$marginLeft.'px;">';
                
                if($user_image == ""){
                    $reviewHTML .= '<img src="./assets/LOGO.png" alt="User Image" width="80" height="80">';
                }else{
                    $reviewHTML .= '<img src="' . $user_image .'" style="border-radius: 50%;" alt="User Image" width="80" height="80">';
                }
                    
            $reviewHTML .= '    
            </div>
            <div class="col panel panel-primary" style="background-color:#cff7be;">
            <div class="panel panel-primary">
                <h6><i>';
                $reviewHTML .= '<h6 style="float:right; font-size:14px; color:gray;">' . review_time_ago($review_time) . '</h6>';
                //echo review_time_ago('2016-03-11 04:58:00'); 
                //echo $review_time;
                //echo $id_review;
                                    
                $reviewHTML .='
                </i></h6>
                <h6 style="color:black; font-size:14px; color:gray;">Replied By <b style="color:black;">' . $full_name . '</b></h6>
                <div class="panel-body">'. $user_review .'</div>';
                
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
                                <button type="submit" name="delete_review" class="no-style-button">Delete</button> 
                            </form>                           
                        </ul>
                    </div>';
                }
                
                $reviewHTML .='
                </div>
                </div>
                </div>';

            $reviewHTML .= getCommentReply($conn, $fetch_review['review_id'], $marginLeft);
        }
    }
    return $reviewHTML;
}
?>

<script>

    $('#delete_review').click(function(){

        var delete_id = $('#deleteReviewId').val();

        console.log(delete_id);

        $.ajax({
            url:"delete_rating.php",
            method:"POST",
            data:{delete_id:delete_id},
            success:function(data)
            {
                $('#modal').modal('hide'); 
                $('body').removeClass('modal-open'); 
                $('.modal-backdrop').remove();

                showCommentss();

                alert(data);
                //window.stop();
                //window.location.reload(true);
            }
        })


    });

$(document).ready(function(){
    dropdown();
    console.log('working plant');
});
</script>
