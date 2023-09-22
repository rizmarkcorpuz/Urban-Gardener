<?php

require "function.php";

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $errors = login($_POST);

    if(count($errors) == 0){

        header("Location: login");
        die;
    }
}


//session_start();
//include 'config.php';
//error_reporting(0);
if(isset($_SESSION['username'])){
    header("Location: welcome");
}

/*if (isset($_POST['dsubmit'])) {
    $_SESSION['username'] = $_POST['username'];
    $password = md5($_POST['password']);
    $username = $_SESSION['username'];

    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        $username = $_SESSION['username'];
        echo "<script>alert('Login Successfully.') </script>";
        echo "<script>window.top.location='./welcome.php'</script>";
    } else {
        echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
    }
} */
include 'header.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">



        <title>Login Form</title>
    </head>
</html>

    <!-- registration area -->
    <section id="login-form" class="m-5">
        <div class="row m-0">
            <div class="col-lg-4 offset-lg-4">
                <div class="text-center pb-2">
                    <h1 class="login-title text-dark">Login</h1>
                </div>

                <div class="d-flex justify-content-center">
                    <?php if(count($errors) > 0):?>
                        <?php foreach ($errors as $error):?>

                        <?php endforeach; ?>
                    <?php endif; ?>
                    <form action="" method="post" enctype="multipart/form-data" id="log-form">

                        <div class="input-group form-row my-4">
                            <div class="col">
                                <h6 class="text-danger text-center"><?php echo $error??""; ?></h6>
                                <input type="name" placeholder="Username" name="username" value="<?php echo $_POST['username'] ?? ""; ?>" required class="form-control">
                            </div>
                        </div>

                        <div class="input-group form-row my-4">
                            <div class="col">
                                <input type="password" placeholder="Password" id="myPassword" name="password" value="<?php echo $_POST['password'] ?? ""; ?>" required class="form-control">
                                <input type="checkbox" style="margin-top:20px;" id="showpassword" onclick="myFunction()" > 
                                <label for="showpassword" class="form-check-label font-ubuntu text-black-50">Show Password</label> 
                            </div>
                        </div>

                        <div class="input-group row my-4 offset-lg-3">
                            <div class="submit-btn text-center my-6">
                                <button type="submit"  class="btn btn-warning rounded-pill text-dark px-5">Login</button>
                            </div>
                        </div>
                        <p class="login-register-text">Don't have an account? <a href="register">Register Here</a>.</p>
                    </form>
                </div>
            </div>
        </div>
        </div>

    </section>
    <!-- #registration area -->


<?php
// footer.php
include ('footer.php');
?>