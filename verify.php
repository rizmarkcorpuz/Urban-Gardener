<?php

require "mail.php";
require "function.php";
//session_destroy();
check_login();

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST" && !check_verified()){

    if(isset($_POST['send_code'])){

        //send email
        $vars['code'] = rand(10000,99999);

        //save to database
        $vars['expires'] = (time() + (60 * 1));
        $vars['email'] = $_SESSION['username']->email;

        $query = "insert into verify (code,expires,email) values (:code,:expires,:email)";
        database_run($query, $vars);

        $message = "Your Code Verification is " . $vars['code'];
        $subject = "Email Verification Code";
        $recipient = $vars['email'];
        send_mail($recipient,$subject,$message);

    }


}

if(isset($_POST['verify'])){

    if(!check_verified()){

        $query = "select * from verify where code = :code && email = :email";
        $vars = array();
        $vars['email'] = $_SESSION['username']->email;
        $vars['code'] = $_POST['code'];
        $row = database_run($query, $vars);

        if(is_array($row)){

            $row = $row[0];
            $time = time();

            if($row->expires > $time){

                $id = $_SESSION['username']->user_id;
                $query = "update user set email_verified = email where user_id = '$id' limit 1";
                database_run($query);

                header("Location: welcome");
                die;
            }else{
                echo "Code expired";
            }
        }else{
            echo "wrong code";
        }
    }else{
        echo "You are already verified";
    }
}


//include 'config.php';

//error_reporting(0);
//session_start();
/*if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}else{
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
        $_POST['first_name'] = $row['first_name'];
        $_POST['last_name'] = $row['last_name'];
        $_POST['contact_number'] = $row['contact_number'];
        $_POST['billing_address'] = $row['billing_address'];
        $_POST['mode_of_payment'] = $row['mode_of_payment'];
        $_POST['email'] = $row['email'];
        $user_id = $_SESSION['user_id'];
        if($row['user_type'] == 1){
            $_POST['user_type'] = 'User';
        }elseif($row['user_type'] == 32){
            $_POST['user_type'] = 'Admin';
        }
        //echo $_SESSION['user_id'];
    } else {
        echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
    }
} */



if (isset($_POST['update_user'])) {
    $update_user_id = $_POST['update_user_id'];
    $update_firstname = $_POST['update_first_name'];
    $update_lastname = $_POST['update_last_name'];
    $update_contact_number = $_POST['update_contact_number'];
    $update_billing_address = $_POST['update_billing_address'];
    $update_mode_of_payment = $_POST['update_mode_of_payment'];
    $update_username = $_POST['update_username'];
    $update_email = $_POST['update_email'];
    $update_password = md5($_POST['update_password']);
    $update_cpassword = md5($_POST['update_cpassword']);


    if ($update_password == $update_cpassword){
        $update_query = mysqli_query($conn, "UPDATE `user` SET first_name = '$update_firstname', last_name ='$update_lastname', contact_number ='$update_contact_number', billing_address ='$update_billing_address', mode_of_payment ='$update_mode_of_payment', username ='$update_username', email ='$update_email', password ='$update_password' WHERE user_id='$update_user_id'") or die("query failed");

        if($update_query){
            echo "<script>alert('Update Completed.') </script>";
            echo "<script>window.top.location='./logout'</script>";

        }else{
            echo "<script>alert('Woops! Something Wrong Went.')</script>";
        }

    }else{
        echo "<script>alert('Password Not Matched.')</script>";

    }

}



if (isset($_POST['logout'])) {
    header("Location: logout");
}


include 'header.php';

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome</title>

        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- custom css file link  -->
        <link rel="stylesheet" href="./style.css">

    </head>
    <body>



    <section id="main-site"><br><br>
        <div class="container py-5">
            <div class="row">
                <div class="col-4 offset-4 shadow py-4">
                    <?php if(count($errors) > 0):?>
                        <?php foreach ($errors as $error):?>
                            <?= $error?> <br>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <form action="" method="post" enctype="multipart/form-data" id="welcome-form">
                        <div class="user-info px-3">
                        <div class="text-center">
                            <?php echo "<h2 class='text-center'>Welcome " . $username . "</h2>"; ?>
                            <?php 
                            $user_image = $_SESSION['username']->user_image;
                                if($user_image == "./assets/products/"){
                                    echo '<img src="./assets/LOGO.png" alt="User Image" width="80" height="80">';
                                }else{
                                    echo '<img src="' . ($_SESSION["username"]->user_image). '" style="border-radius: 50%;"  height="100" width="100" alt="">';
                                }
                                
                            ?>
                            </div>
                            <ul class="font-ubuntu navbar-nav">
                                <li class="nav-link"><b>First Name: </b><span><?php echo ($_SESSION['username']->first_name); ?></span></li>
                                <li class="nav-link"><b>Last Name: </b><span><?php echo ($_SESSION['username']->last_name); ?></span></li>
                                <li class="nav-link"><b>Contact Number: </b><span><?php echo ($_SESSION['username']->contact_number); ?></span></li>
                                <li class="nav-link"><b>Billing Address: </b><span><?php echo ($_SESSION['username']->billing_address); ?></span></li>
                                <li class="nav-link"><b>Email: </b><span><?php echo ($_SESSION['username']->email); ?></span></li>
                                <li class="nav-link text-danger"><b>Verify </b><span> your email address using <a href="https://www.gmail.com" class="text-danger"><b>Gmail</b></a> to access all functions</span></li>
                                <?php

                                    if(!isset($_POST['send_code'])){

                                    }else{

                                ?>
                                <li class="nav-link"><span>an email was sent to your address. paste the code from the email here</span></li>
                                <?php } ?>
                                <li class="nav-link"><b>Code: </b><span><input type="text" style="width: 150px;" class="mr-2" name="code" placeholder="Enter your code"><input type="submit" name="send_code" class="btn btn-success rounded-pill text-white" value="Send Code"></span></li>
                            </ul>
                            <div class="submit-btn text-center my-6">
                                <input type="submit" class="btn btn-warning rounded-pill text-white px-5" name="verify" value="verify">
                                <button type="button" name="logout" class="btn btn-danger rounded-pill text-white px-5" data-toggle="modal" data-target="#logoutModal">Logout</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">

        <section class="edit-form-container2">

            <?php

            if(isset($_GET['edit'])){
                $edit_id = $_GET['edit'];
                $edit_query = mysqli_query($conn, "SELECT * FROM `user` WHERE user_id = $edit_id");
                if(mysqli_num_rows($edit_query) > 0){
                    while($fetch_edit = mysqli_fetch_assoc($edit_query)){
                        ?>

                        <form action="" method="post" enctype="multipart/form-data">
                            <h3>Edit User Information</h3>
                            <div class="form-row my-4">
                                <div class="col">
                                    <input type="hidden" name="update_user_id" value="<?php echo $fetch_edit['user_id']; ?>">
                                    <input type="text" placeholder="First Name" name="update_first_name" id="FirstName" value="<?php echo $fetch_edit['first_name']; ?>"required class="form-control">
                                </div>
                            </div>
                            <div class="form-row my-4">
                                <div class="col">
                                    <input type="text" placeholder="Last Name" name="update_last_name" id="LastName" value="<?php echo $fetch_edit['last_name']; ?>"required class="form-control">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <input type="text" placeholder="Contact Number" name="update_contact_number" pattern="^[0-9]{6}|[0-9]{8}|[0-9]{11}$" id="ContactNumber" value="<?php echo $fetch_edit['contact_number']; ?>"required class="form-control">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <input type="text" placeholder="Billing Address" name="update_billing_address" id="BillingAddress" value="<?php echo $fetch_edit['billing_address']; ?>"required class="form-control">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <input type="text" placeholder="Username" name="update_username" value="<?php echo $fetch_edit['username']; ?>" required class="form-control">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <input type="email" placeholder="Email*" name="update_email" value="<?php echo $fetch_edit['email']; ?>" required class="form-control">
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

                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="agreement" class="form-check-input" required>
                                <label for="agreement" class="form-check-label font-ubuntu text-black-50">I agree <a href="#">term, conditions, and policy </a>(*) </label>
                            </div>
                            <br>
                            <input type="submit" value="Update Information" name="update_user" class="btn-update3 offset-lg-3">

                            <a href="welcome" id="close-edit" class="option-btn3 text-white offset-lg-3" style="text-decoration: none">Cancel </a>
                        </form>

                        <?php
                    };
                };
                echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";

            };
            ?>
        </section>


    </div>


    </body>
    </html>

<?php
// footer.php
include ('footer.php');
?>