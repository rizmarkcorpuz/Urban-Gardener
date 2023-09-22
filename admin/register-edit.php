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

if (isset($_SESSION['username'])) {
    header("Location: index");
}


if (isset($_POST['update_user'])) {
    $update_user_id = $_POST['update_user_id'];
    $update_firstname = $_POST['update_first_name'];
    $update_lastname = $_POST['update_last_name'];
    $update_contact_number = $_POST['update_contact_number'];
    $update_billing_address = $_POST['update_billing_address'];
    $update_user_image = $_FILES['update_user_image']['name'];
    $update_user_image_tmp_name = $_FILES['update_user_image']['tmp_name'];
    $update_user_image_folder = 'assets/products/'. $update_user_image;
    $update_username = $_POST['update_username'];
    $update_email = $_POST['update_email'];
    $update_password = hash('sha256', $_POST['update_password']);
    $update_cpassword = hash('sha256', $_POST['update_cpassword']);


    if ($update_password == $update_cpassword){
        $update_query = mysqli_query($conn, "UPDATE `user` SET first_name = '$update_firstname', last_name ='$update_lastname', contact_number ='$update_contact_number', billing_address ='$update_billing_address', user_image ='./assets/products/$update_user_image', username ='$update_username', email ='$update_email', password ='$update_password' WHERE user_id='$update_user_id'") or die("query failed");

        if($update_query){
            move_uploaded_file($update_user_image_tmp_name, $update_user_image_folder);
            echo "<script>alert('Update Completed.') </script>";
            echo "<script>window.top.location='./register'</script>";

        }else{
            echo "<script>alert('Woops! Something Wrong Went.')</script>";
        }

    }else{
        echo "<script>alert('Password Not Matched.')</script>";

    }

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


        <div class="container-fluid" style="width: 1100px; height: 625px;overflow: auto;">

            <div class="" id="editadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
                <div class="" role="document">
                    <div class="">
                        <div class="">
                            <h5 class="" id="exampleModalLabel">Edit Admin Data</h5>

                        </div>
                        <?php
                        $user_id=$_POST['edit_id'];
                        $sql = "SELECT * FROM `user` WHERE user_id='$user_id'";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){

                            while($row = mysqli_fetch_assoc($result)){

                                ?>
                                <form action="" method="POST" enctype="multipart/form-data">

                                    <div class="modal-body">

                                        <div class="form-row my-4">
                                            <div class="col">
                                                <input type="hidden" name="update_user_id" value="<?php echo $row['user_id']; ?>">
                                                <input type="text" placeholder="First Name" name="update_first_name" id="FirstName" value="<?php echo $row['first_name']; ?>"required class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row my-4">
                                            <div class="col">
                                                <input type="text" placeholder="Last Name" name="update_last_name" id="LastName" value="<?php echo $row['last_name']; ?>"required class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row my-4">
                                            <div class="col">
                                                <input type="text" placeholder="Contact Number" name="update_contact_number" pattern="^[0-9]{6}|[0-9]{8}|[0-9]{11}$" id="ContactNumber" value="<?php echo $row['contact_number']; ?>"required class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row my-4">
                                            <div class="col">
                                                <input type="text" placeholder="Billing Address" name="update_billing_address" id="BillingAddress" value="<?php echo $row['billing_address']; ?>"required class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row my-4">
                                            <div class="col">
                                                <input type="file" class="form-control pt-3 pb-5" placeholder="Admin Image" name="update_user_image" accept="image/png, image/jpg, image/jpeg" value="<?php echo $row['user_image']; ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row my-4">
                                            <div class="col">
                                                <input type="text" placeholder="Username" name="update_username" value="<?php echo $row['username']; ?>" required class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row my-4">
                                            <div class="col">
                                                <input type="email" placeholder="Email*" name="update_email" value="<?php echo $row['email']; ?>" required class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row my-4">
                                            <div class="col">
                                                <input type="password" placeholder="Password" name="update_password" value="<?php echo $_POST['password']; ?>" required class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row my-4">
                                            <div class="col">
                                                <input type="password" placeholder="Confirm Password*" name="update_cpassword" value="<?php echo $_POST['cpassword']; ?>" required class="form-control">
                                                <small id="confirm_error" class="text-danger"></small>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <a type="button" href="register" class="btn btn-secondary" data-dismiss="modal">Close</a>
                                        <button type="submit" name="update_user" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                                <?php
                            }
                        }
                        else {
                            echo "No Record Found";
                        }
                        ?>
                    </div>
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
