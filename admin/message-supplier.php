<?php

//include header.php file
include ('./includes/header.php');

?>

<?php

//include navbar.php file
include('./includes/navbar.php');
?>

<?php
include ('./config.php');

require "mail.php";

error_reporting(0);

session_start();

if (!isset($_SESSION['admin_user_id'])) {
    header("Location: login");

}else{
    $admin_username = $_SESSION['admin_username'];
    $admin_user_id = $_SESSION['admin_user_id'];
    $sql = "SELECT * FROM user WHERE user_id='$admin_user_id'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];
        $_SESSION['user_image'] = $row['user_image'];
        $_POST['contact_number'] = $row['contact_number'];
        $_POST['billing_address'] = $row['billing_address'];
        $_POST['zipcode'] = $row['zipcode'];
        $_POST['email'] = $row['email'];
        $first_name = $_SESSION['first_name'];
        $last_name = $_SESSION['last_name'];
        $user_image = $_SESSION['user_image'];
        if($row['user_type'] == 1){
            $_POST['user_type'] = 'User';
        }elseif($row['user_type'] == 32){
            $_POST['user_type'] = 'Admin';
        }
        //echo $_SESSION['user_id'];
    } else {
        echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
    }
}

if (isset($_POST['send_message'])) {
    $recipient = $_POST['recipients'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    //echo $recipient;
    //echo $subject;
    //echo $message;
    //die;

    send_mail($recipient,$subject,$message);

    echo '<script type="text/javascript">';
    echo 'alert("Send Email Successfully")';  //not showing an alert box.
    echo '</script>';
    echo "<script>window.top.location='./message-supplier'</script>";

}
?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Search -->
            <form
                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                           aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                         aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small"
                                       placeholder="Search for..." aria-label="Search"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>


                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $first_name; ?> <?php echo $last_name; ?></span>
                        <?php 
                            //$user_image = $_SESSION['username']->user_image;
                            if($user_image == "./assets/products/" || $user_image == ""){
                                echo '<img class="img-profile rounded-circle" src="./assets/LOGO.png" alt="User Image" width="80" height="80">';

                            }else{
                                echo '<img img class="img-profile rounded-circle" src="' . $user_image. '" style="border-radius: 50%;"  height="100" width="100" alt="">';
                                
                            }
                             
                        ?>
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                         aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="register">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                            Admin and User
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->


        <div class="container-fluid">

            <div class="" id="editadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
                <div class="" role="document">
                    <div class="">
                        <div class="">
                            <?php
                                $user_id = $_POST['user_id'];
                                $name_query = mysqli_query($conn, "SELECT * FROM `user` WHERE user_id = '$user_id'") or die("query failed");
                                $row = mysqli_fetch_assoc($name_query);
                                $first_name = $row['first_name'];
                                $last_name = $row['last_name'];
                                $supplier_name = $first_name . PHP_EOL . $last_name;
                            ?>
                            <h5 class="" id="exampleModalLabel">Message <?php echo $supplier_name ?? "Unknown" ?></h5>

                        </div>
                        <?php

                        $sql = "SELECT * FROM `user` WHERE user_id='$user_id'";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){

                            while($row = mysqli_fetch_assoc($result)){

                                ?>
                                <form action="" method="POST">

                                    <div class="modal-body">

                                        <div class="form-row my-4">
                                            <div class="col">
                                                <input type="hidden" name="user_id" value="">
                                                <input type="text" placeholder="Recipients" name="recipients" id="recipients" value="<?php echo $row['email']; ?>"required class="form-control w-25">
                                            </div>
                                        </div>
                                        <div class="form-row my-4">
                                            <div class="col">
                                                <input type="text" placeholder="Subject" name="subject" id="subject" value=""required class="form-control w-25">
                                            </div>
                                        </div>

                                        <div class="form-row my-4">
                                            <div class="col">
                                                <textarea type="text" placeholder="Message" name="message"  id="message" value=""required class="form-control" style="height: 400px;"> </textarea>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="send_message" class="btn btn-primary">Send</button>
                                    </div>
                                </form>
                                <?php
                            }
                        }
                        else {
                            echo "Message Sent Successfully";
                            header("Location: supplier");
                        }
                        ?>
                    </div>
                </div>
            </div>

            <?php

            //include scripts.php file
            include('./includes/scripts.php');
            ?>

            <?php

            //include footer.php file
            include('./includes/footer.php');
            ?>
