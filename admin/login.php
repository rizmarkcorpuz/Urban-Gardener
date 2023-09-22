<?php

//include header.php file
include ('./includes/header.php');

?>

<?php

include 'config.php';

error_reporting(0);

if (isset($_SESSION['username'])) {
    //header("Location: index.php");
}

if (isset($_POST['login_submit'])) {
    $admin_username = $_POST['admin_username'];
    $admin_password = hash('sha256', $_POST['admin_password']);

    $sql = "SELECT * FROM user WHERE username='$admin_username' AND password='$admin_password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        session_start();
        $row = mysqli_fetch_assoc($result);
        $user_type = $row['user_type'];
        if($user_type == 32){
            $_SESSION['admin_username'] = $row['username'];
            $_SESSION['admin_user_id'] = $row['user_id'];
            $admin_user_id = $_SESSION['user_id'];
            echo "<script>alert('Login Successfully.')</script>";
            echo "<script>window.top.location='./index'</script>";
        }else{
            $admin_username = "";
            $admin_password = "";
            echo "<script>alert('You are not admin of this page.')</script>";
        }




    } else {
        echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
    }
}

?>

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-4 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                <form class="user" method="POST">
                                    <div class="form-group">
                                        <input type="name" class="form-control form-control-user"
                                               id="exampleInputEmail" aria-describedby="emailHelp"
                                               placeholder="Enter Username..." name="admin_username" value="<?php echo $admin_username ?? ""; ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                               id="exampleInputPassword" placeholder="Password" name="admin_password" value="<?php echo $admin_password ?? ""; ?>">

                                    </div>

                                    <div class="submit-btn text-center">
                                        <button type="submit" name="login_submit" class="btn btn-primary btn-user btn-block">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>


<?php

//include scripts.php file
include('./includes/scripts.php')
?>


