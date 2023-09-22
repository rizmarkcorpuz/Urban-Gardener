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
        
        if($toggleName == "Page Reviews"){

            //echo $toggleName;
            $review_all_query = mysqli_query($conn, "SELECT * FROM `review_urban` WHERE parent_id = '0' ORDER BY review_id DESC");
            $reviewHTML = '';
            $total_rating = 0;
            $average_rating = 0;
            $total_review = 0;
            $rounded_rating = 0;
            $i = 0;
            $reviewHTML = '';
            if(mysqli_num_rows($review_all_query) > 0){

                while($fetch_review = mysqli_fetch_assoc($review_all_query)){
                    $full_name = $fetch_review['first_name'] . " " . $fetch_review['last_name'];
                    $time_ago = $fetch_review['datetime'];
                    $review_time = date('Y-m-d H:i:s', $time_ago);
                    $user_image = $fetch_review['user_image'];
                    $user_review = $fetch_review['user_review'];
                    $review_id = $fetch_review['review_id'];
                    $user_rating = $fetch_review['user_rating'];
                    $total_rating = $total_rating + $user_rating;
                    $total_review++;
                    $average_rating = $total_rating/$total_review;

                    $reviewHTML .= '
                    <hr>
                    <div class="row" style="position:relative;">
                    <div class="" style="width:100px;display:flex; justify-content:center;align-items:center;">';

                    if($user_image == ""){
                        $reviewHTML .= '<img src="./assets/LOGO.png"  alt="User Image" width="80" height="80">';
                    }else{
                        $reviewHTML .= '<img src="' . $user_image .'" style="border-radius: 50%;" alt="User Image" width="80" height="80">';
                    }
                    
                    $reviewHTML .= '
                    </div>
                    <div class="col panel panel-primary">
                    
                    <h6><i>';
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
                    //echo $id_review;
                                        
                    $reviewHTML .='
                    </i></h6>
                    <h6 style="color:black; font-size:14px; color:gray;">By <b style="color:black;">' . $full_name . '</b></h6>
                    <div class="panel-body">'. $user_review .'</div>
                    <br>
                    </div>
                    </div>';

                    $reviewHTML .= getCommentReply($conn, $fetch_review['review_id']);
                }
                $select_user = mysqli_query($conn, "SELECT * FROM `user` WHERE username = '$username'") or die("query failed");
                    if(mysqli_num_rows($select_user) > 0){
                        while($fetch_user = mysqli_fetch_assoc($select_user)){
                            $username = $fetch_user['username'];
                            $first_name = $fetch_user['first_name'];
                            $last_name = $fetch_user['last_name'];
                            $full_name = $first_name . " " . $last_name;
                        }
                    }
            ?>
            <div class="container m-2 p-4" style="background-color:white;">
            <div class="margin" style="margin-bottom:-20px;">
                <form action="" method="post" target="_blank">
                    <h6 style="font-size:17px; color:black;"><b>Ratings & Reviews for Urban Gardener</b>
                        <input type="hidden" name="review_item_id" value="<?php echo $item_id; ?>">
                        <a href="reviews" class="hyperlink-style-button px-2 font-rale font-size-14"><?php echo $total_review ?? 0; ?> reviews</a>
                    </h6>
                </form>
                    
                    <p style="font-size:17px; color:black;display:inline-block;">Average: <?= number_format($average_rating, 1); ?>/5.0</p>
                    <h6 style="color:#f6c23e; display:inline;">
                        <?php 
                        //echo (round($average_rating,1) . PHP_EOL);
            
                        if($average_rating >= 0 && $average_rating <= 0.49){
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                        }elseif($average_rating <= 0.99 && $average_rating >= 0.5){
                            echo '<i class="fas fa-star-half-alt mr-1"></i>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                        }elseif($average_rating >= 1 && $average_rating <= 1.49){
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                        }elseif($average_rating <= 1.99 && $average_rating >= 1.5){
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star-half-alt mr-1"></i>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                        }elseif($average_rating >= 2 && $average_rating <= 2.49){
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                        }elseif($average_rating <= 2.99 && $average_rating >= 2.5){
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<span><i class="fas fa-star-half-alt mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                        }elseif($average_rating >= 3 && $average_rating <= 3.49){
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                        }elseif($average_rating <= 3.99 && $average_rating >= 3.5 ){
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star-half-alt mr-1"></i>';
                            echo '<i class="far fa-star mr-1"></i>';
                        }elseif($average_rating >= 4 && $average_rating <= 4.49){
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
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
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                            echo '<span><i class="far fa-star mr-1"></i></span>';
                        }
                        ?>
                    </h6>      
            </div>      
            <?php
                echo $reviewHTML;
            }else{
                
                $select_user = mysqli_query($conn, "SELECT * FROM `user` WHERE username = '$username'") or die("query failed");
                    if(mysqli_num_rows($select_user) > 0){
                        while($fetch_user = mysqli_fetch_assoc($select_user)){
                            $username = $fetch_user['username'];
                            $first_name = $fetch_user['first_name'];
                            $last_name = $fetch_user['last_name'];
                            $full_name = $first_name . " " . $last_name;
                        }
                    }  

                echo '<form action="" method="post" target="_blank">
                        <h6 style="font-size:17px; color:black;"><b>Ratings & Reviews for Urban Gardener</b>
                            <input type="hidden" name="review_item_id" value="<?php echo $item_id; ?>">
                            <a href="reviews" class="hyperlink-style-button px-2 font-rale font-size-14"> 0 reviews</a>
                        </h6>
                    </form>';
                echo '<p style="font-size:17px; color:black;display:inline-block;">Average: ' . number_format(0, 1) . '/5.0</p>';
                echo '<h6 style="color:#f6c23e; display:inline;">';
        
                echo PHP_EOL . '<span><i class="far fa-star mr-1"></i></span>';
                echo '<span><i class="far fa-star mr-1"></i></span>';
                echo '<span><i class="far fa-star mr-1"></i></span>';
                echo '<span><i class="far fa-star mr-1"></i></span>';
                echo '<span><i class="far fa-star mr-1"></i></span>';                              
                echo '</h6>';
                echo '<hr style="margin-top: 0px;">';
                echo "No review added";

            }

    
        }else if($toggleName == "Product Reviews"){
            //echo $toggleName;
        }


    }else{
    
        if($toggleName == "Page Reviews"){

            $review_all_query = mysqli_query($conn, "SELECT * FROM `review_urban` WHERE parent_id = '0' ORDER BY review_id DESC");
            $reviewHTML = '';
            $total_rating = 0;
            $average_rating = 0;
            $total_review = 0;
            $rounded_rating = 0;
            $i = 0;
            if(mysqli_num_rows($review_all_query) > 0){

                while($fetch_review = mysqli_fetch_assoc($review_all_query)){
                    $full_name = $fetch_review['first_name'] . " " . $fetch_review['last_name'];
                    $time_ago = $fetch_review['datetime'];
                    $review_time = date('Y-m-d H:i:s', $time_ago);
                    $user_review = $fetch_review['user_review'];
                    $user_image = $fetch_review['user_image'];
                    $user_name = $fetch_review['user_name'];
                    $review_id = $fetch_review['review_id'];
                    $user_rating = $fetch_review['user_rating'];
                    $parentId = $fetch_review['parent_id'];
                    $total_rating = $total_rating + $user_rating;
                    $total_review++;
                    $average_rating = $total_rating/$total_review;

                    $reviewHTML .= '
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
                    
                    <h6><i>';
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
                    //echo $id_review;
                                        
                    $reviewHTML .='
                    </i></h6>
                    <h6 style="font-size:14px; color:gray;">By <b style="color:black;">' . $full_name . '</b></h6>
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
                                    <input type="hidden" name="review_id" id="deleteReviewUrbanId" value="' . $review_id .' ">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" name="delete_review_urban" id="delete_review_urban" class="btn btn-danger">Delete</button>
                                </form>
                                </div>
                                </div>
                            </div>
                            </div>

                        </div>
                    </div>';

                    

                    $reviewHTML .= getCommentReply($conn, $fetch_review['review_id']);
                }

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

                    echo '
                    <div class="container m-2 p-4" style="background-color:white;">
                    <div class="margin" style="margin-bottom:-10px;">
                        <form action="" method="post" target="_blank">
                            <h6 style="font-size:17px; color:black;"><b>Ratings & Reviews for Urban Gardener</b>
                                <input type="hidden" name="review_item_id" value="<?php echo $item_id; ?>">
                                <a href="reviews" class="hyperlink-style-button px-2 font-rale font-size-14">' . $total_review . ' reviews</a>
                            </h6>
                        </form>
                            
                            <p style="font-size:17px; color:black;display:inline-block;">Average: ' . number_format($average_rating, 1) . '/5.0</p>
                            <h6 style="color:#f6c23e; display:inline;">';

                            if($average_rating >= 0 && $average_rating <= 0.49){
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                            }elseif($average_rating <= 0.99 && $average_rating >= 0.5){
                                echo '<i class="fas fa-star-half-alt mr-1"></i>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                            }elseif($average_rating >= 1 && $average_rating <= 1.49){
                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                            }elseif($average_rating <= 1.99 && $average_rating >= 1.5){
                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                echo '<i class="fas fa-star-half-alt mr-1"></i>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                            }elseif($average_rating >= 2 && $average_rating <= 2.49){
                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                            }elseif($average_rating <= 2.99 && $average_rating >= 2.5){
                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                echo '<span><i class="fas fa-star-half-alt mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                            }elseif($average_rating >= 3 && $average_rating <= 3.49){
                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                            }elseif($average_rating <= 3.99 && $average_rating >= 3.5 ){
                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                echo '<i class="fas fa-star-half-alt mr-1"></i>';
                                echo '<i class="far fa-star mr-1"></i>';
                            }elseif($average_rating >= 4 && $average_rating <= 4.49){
                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
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
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                echo '<span><i class="far fa-star mr-1"></i></span>';
                            }
                        echo'         
                        </h6>
                        <button type="button" name="add_review" id="add_review" class="btn btn-success font-baloo">Write Review</button>
                            <div id="review_modal"  class="modal" tabindex="-1" role="dialog">
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

                                                <input type="hidden" name="user_name" id="user_name" value="' . $username . '" class="form-control" placeholder="Enter Your Name" />
                                                <input type="hidden" name="first_name" id="first_name" value="' . $first_name . '" class="form-control" placeholder="Enter Your Name" />
                                                <input type="hidden" name="last_name" id="last_name" value="' . $last_name . '" class="form-control" placeholder="Enter Your Name" />
                                                <input type="hidden" name="user_image" id="user_image" value="' . $user_image . '" class="form-control" placeholder="Enter Your Name" />
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
                    </div>';

                    echo $reviewHTML;
            }else{
                
                $select_user = mysqli_query($conn, "SELECT * FROM `user` WHERE username = '$username'") or die("query failed");
                    if(mysqli_num_rows($select_user) > 0){
                        while($fetch_user = mysqli_fetch_assoc($select_user)){
                            $username = $fetch_user['username'];
                            $first_name = $fetch_user['first_name'];
                            $last_name = $fetch_user['last_name'];
                            $full_name = $first_name . " " . $last_name;
                        }
                    }  

                echo '<form action="" method="post" target="_blank">
                        <h6 style="font-size:17px; color:black;"><b>Ratings & Reviews for Urban Gardener</b>
                            <input type="hidden" name="review_item_id" value="<?php echo $item_id; ?>">
                            <a href="reviews" class="hyperlink-style-button px-2 font-rale font-size-14"> 0 reviews</a>
                        </h6>
                    </form>';
                echo '<p style="font-size:17px; color:black;display:inline-block;">Average:' . number_format(0, 1) . '/5.0</p>';
                echo '<h6 style="color:#f6c23e; display:inline;">';
        
                echo '<span><i class="far fa-star mr-1"></i></span>';
                echo '<span><i class="far fa-star mr-1"></i></span>';
                echo '<span><i class="far fa-star mr-1"></i></span>';
                echo '<span><i class="far fa-star mr-1"></i></span>';
                echo '<span><i class="far fa-star mr-1"></i></span>';                              
                echo '                        
                    </h6>
                    <button type="button" name="add_review" id="add_review" class="btn btn-success font-baloo">Write Review</button>
                    <div id="review_modal"  class="modal" tabindex="-1" role="dialog">
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

                                        <input type="hidden" name="user_name" id="user_name" value="' . $username . '" class="form-control" placeholder="Enter Your Name" />
                                        <input type="hidden" name="first_name" id="first_name" value="' . $first_name . '" class="form-control" placeholder="Enter Your Name" />
                                        <input type="hidden" name="last_name" id="last_name" value="' . $last_name . '" class="form-control" placeholder="Enter Your Name" />
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
                    </div>';
                echo '<hr style="margin-top: 0px;">';
                echo "No review added";

            }
        }else if($toggleName == "Product Reviews"){

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
    $review_all_query = mysqli_query($conn, "SELECT * FROM `review_urban` WHERE parent_id = '".$parentId."'");
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
            $user_image = $fetch_review['user_image'];
            $user_review = $fetch_review['user_review'];
            $user_name = $fetch_review['user_name'];
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
                                <button type="submit" name="delete_review_urban" class="no-style-button">Delete</button> 
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
                url:"submit_rating-urban.php",
                method:"POST",
                data:{rating_data:rating_data, user_name:user_name, first_name:first_name, last_name:last_name, user_image:user_image, user_review:user_review},
                success:function(data)
                {
                    $('#review_modal').modal('hide');
                    $('#modal').modal('hide'); 
                    $('body').removeClass('modal-open'); 
                    $('.modal-backdrop').remove();
                    
                    showComments();
                    
                    alert(data);
                    //window.stop();
                    //window.top.location='./reviews.php';
                }
            })
        }

    });

});

$('#delete_review_urban').click(function(){

var delete_urban_id = $('#deleteReviewUrbanId').val();

console.log(delete_urban_id);

$.ajax({
    url:"delete_rating_urban.php",
    method:"POST",
    data:{delete_urban_id:delete_urban_id},
    success:function(data)
    {
        $('#modal').modal('hide'); 
        $('body').removeClass('modal-open'); 
        $('.modal-backdrop').remove();

        showComments();
        alert(data);
        //window.stop();
        //window.location.reload(true);
    }
})


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
            if (select.contains(event.target)) {
                select.classList.toggle('select-clicked');
                //caret.classList.toggle('caret-rotate');
                menu.classList.toggle('menu-open');
            }else if(menu.contains(event.target)){
                

            }else{
                select.classList.remove('select-clicked');
                menu.classList.remove('menu-open');
            }
            
        })

    });
}

$(document).ready(function(){
    dropdown();
    console.log('working urban');
});

</script>