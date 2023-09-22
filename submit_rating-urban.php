<?php

//submit_rating.php
session_start();
//$user_id = $_SESSION['user_id'];
//echo $item_id;
include 'config.php';
$connect = new PDO("mysql:host=localhost;dbname=shopee", "root", "");
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
if(isset($_POST["rating_data"]))
{

    $data = array(
        ':user_name'		=>	$_POST["user_name"],
        ':first_name'		=>	$_POST["first_name"],
        ':last_name'		=>	$_POST["last_name"],
        ':user_image'		=>	$_POST["user_image"],
        ':user_rating'		=>	$_POST["rating_data"],
        ':user_review'		=>	$_POST["user_review"],
        ':datetime'			=>	time()
    );

    $query = "
	INSERT INTO review_urban
	(user_name, first_name, last_name, user_image, user_rating, user_review, datetime) 
	VALUES (:user_name, :first_name, :last_name, :user_image, :user_rating, :user_review, :datetime)
	";

    $notification_query = mysqli_query($conn, "INSERT INTO `notifications` (text, date, url, status) VALUES ('You have a review on a product', Now(), 'reviews.php', '0')") or die("query failed");

    $statement = $connect->prepare($query);

    $statement->execute($data);

    echo "Your Review & Rating Successfully Submitted";

}

if(isset($_POST["action"]))
{
    $average_rating = 0;
    $total_review = 0;
    $five_star_review = 0;
    $four_star_review = 0;
    $three_star_review = 0;
    $two_star_review = 0;
    $one_star_review = 0;
    $total_user_rating = 0;
    $review_content = array();

    $query = "
	SELECT * FROM review_urban
	ORDER BY review_id DESC
	";

    $result = $connect->query($query, PDO::FETCH_ASSOC);

    foreach($result as $row)
    {
        $review_time = date('Y-m-d H:i:s' , $row['datetime']);
        $review_content[] = array(
            'user_name'		=>	$row["user_name"],
            'user_review'	=>	$row["user_review"],
            'rating'		=>	$row["user_rating"],
            'datetime'		=>	review_time_ago($review_time)
        );

        if($row["user_rating"] == '5')
        {
            $five_star_review++;
        }

        if($row["user_rating"] == '4')
        {
            $four_star_review++;
        }

        if($row["user_rating"] == '3')
        {
            $three_star_review++;
        }

        if($row["user_rating"] == '2')
        {
            $two_star_review++;
        }

        if($row["user_rating"] == '1')
        {
            $one_star_review++;
        }

        $total_review++;

        $total_user_rating = $total_user_rating + $row["user_rating"];

    }

    $average_rating = $total_user_rating / $total_review;

    $output = array(
        'average_rating'	=>	number_format($average_rating, 1),
        'total_review'		=>	$total_review,
        'five_star_review'	=>	$five_star_review,
        'four_star_review'	=>	$four_star_review,
        'three_star_review'	=>	$three_star_review,
        'two_star_review'	=>	$two_star_review,
        'one_star_review'	=>	$one_star_review,
        'review_data'		=>	$review_content
    );

    echo json_encode($output);

}

?>