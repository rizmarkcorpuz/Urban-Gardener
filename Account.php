<?php

session_start();
include "helper.php";
$user = array();
require ('mysqli_connect.php');

if(isset($_SESSION['userID'])){
    $user = get_user_info($con, $_SESSION['userID']);
}

if(isset($_POST['logout'])){
    unset($_SESSION['userID']);
    header("location: index");
}

// header.php
include ('header.php');

?>

<section id="main-site">
    <div class="container py-5">
        <div class="row">
            <div class="col-4 offset-4 shadow py-4">
                <div class="upload-profile-image d-flex justify-content-center pb-1">

                </div>

                <div class="user-info px-3">
                    <ul class="font-ubuntu navbar-nav">
                        <li class="nav-link"><b>First Name: </b><span><?php echo isset($user['firstName']) ? $user['firstName'] : ''; ?></span></li>
                        <li class="nav-link"><b>Last Name: </b><span><?php echo isset($user['lastName']) ? $user['lastName'] : ''; ?></span></li>
                        <li class="nav-link"><b>Email: </b><span><?php echo isset($user['email']) ? $user['email'] : ''; ?></span></li>
                        <li class="nav-link offset-3">
                            <form method="post">
                                <button type="submit" name="logout" class="btn btn-warning rounded-pill text-dark px-5">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</section>

<?php
include "footer.php";
?>
