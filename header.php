<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/LOGO.png">
    <title>Urban Gardener</title>

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Owl-carousel CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

    <!-- Custom CSS file -->
    <link rel="stylesheet" href="./styles.css">

    
    <?php
    //require functions.php file
    require('functions.php');
    error_reporting(0);
    session_start();

    require('config.php');

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username']->username;
    }

    if(isset($_SESSION['username']->user_id)){
        $user_id = $_SESSION['username']->user_id;
        $count_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM cart WHERE user_id='$user_id'");
        $count_query_reservation = mysqli_query($conn, "SELECT COUNT(*) AS total FROM reservation WHERE user_id='$user_id'");
        $row_count = mysqli_fetch_assoc($count_query);
        $row_count_reservation = mysqli_fetch_assoc($count_query_reservation);
        $count = $row_count["total"];
        $countreservation = $row_count_reservation["total"];
    }

    if(isset($_POST['search_submit'])){
        $_SESSION['search'] = $_POST['search'];
        $search = $_SESSION['search'];

        header("Location: search");
    }

    ?>

    
</head>
<body style="min-height: 100vh; display: flex; flex-direction: column; background-color: #eff0f5;">

<!-- start #header -->
<header id="header">
    <div class="strip d-flex justify-content-between px-4 py-1 position-sticky" style="background-color:#e7e8ec;">
        <p class="font-eduvic font-size-12 text-black-50 m-0"></p>
        <div class="font-eduvic font-size-20">
            <a href="welcome" class="px-3 border-right border-left text-dark"><?php echo $username ?? 'Login'; ?></a>
            <a href="reservation" class="px-3 border-right text-dark">Reserve (<?php echo $countreservation ?? 0; ?>)</a>
        </div>
    </div>

    <!-- Primary Navigation -->
    
    <input type="checkbox" name="" id="check" class="checkbox-new">
    <nav class="nav-new">
        <a class="navbar-brand font-eduvic font-size-24" style="text-decoration:none; color:#fff" href="index">Urban Gardener</a>
        <form action="" method="post">
            <div class="search_box">
                <input type="search" id="searchNew" name="search" placeholder="Search for..." class="search-new">
                <button type="submit" name="search_submit" class="button-new fa fa-search"></button>
            </div>
        </form>
        <ol>
            <li><a href="reviews" class="font-eduvic font-size-24">Reviews</a></li>
            <li><form action="#" class="font-size-14 font-rale">
                    <a href="cart" class="py-2 rounded-pill color-primary-bg" style="text-decoration:none; padding:0;">
                        <span class="font-size-16 px-2"><i class="fas fa-shopping-cart" style="margin-right:-10px;"></i></span>
                        <span class="px-3 py-2 rounded-pill text-dark bg-light" style="border: 2px solid #315c20;"><?php echo $count ?? 0; ?></span>
                    </a>
                </form>
            </li>
        </ol>
        <label for="check" class="bar">
            <span class="menu-new fa fa-bars" style="margin-top:-20px; margin-left:20px;" id="bars"></span>
            <span class="menu-new fa fa-times" style="margin-top:-20px; margin-left:20px;" id="times"></span>
        </label>
    </nav>
    <!-- !Primary Navigation -->

</header>
<!-- !start #header -->

<!-- start #main-site -->
<main id="main-site">