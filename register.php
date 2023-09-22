<?php
require "function.php";

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $errors = signup($_POST);

    if(count($errors) == 0){

        header("Location: login");
        die;
    }
}

?>

<?php


//error_reporting(0);

if (isset($_SESSION['username'])) {
    header("Location: index");
}

if (isset($_POST['dsubmit'])) {
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    $contact_number = $_POST['contact_number'];
    $billing_address = $_POST['billing_address'];
    $mode_of_payment = $_POST['mode_of_payment'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = hash('sha256',$_POST['password']);
    $cpassword = hash('sha256',$_POST['cpassword']);


    if ($password == $cpassword){
        $sql = "SELECT * FROM user WHERE email='$email' or username='$username'";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0){
            echo "<script>alert('Woops! Email or Username Already Exists.')</script>";
        }elseif (!$result->num_rows > 0){
            $sql = "INSERT INTO user (first_name, last_name, contact_number, billing_address, mode_of_payment, username, email, password, user_type)
					VALUES ('$firstname', '$lastname', '$contact_number', '$billing_address', '$mode_of_payment', '$username', '$email', '$password', 1)";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('User Registration Completed.')</script>";
                $firstname = "";
                $lastname = "";
                $contact_number = "";
                $billing_address = "";
                $mode_of_payment = "";
                $username = "";
                $email = "";
                $_POST['password'] = "";
                $_POST['cpassword'] = "";
            }else{
                echo "<script>alert('Woops! Something Wrong Went.')</script>";
            }

        }

    }else{
        echo "<script>alert('Password Not Matched.')</script>";
    }

}
?>

<?php

// header.php
include ('header.php');

?>

<!-- registration area -->
<section id="register" class="m-5">
    <div class="row m-1">
        <div class="col-lg-4 offset-lg-4">
            <div class="text-center pb-3">
                <h1 class="login-title text-dark">Register</h1>
                <p class="p-1 m-0 font-ubuntu text-black-50">Register and enjoy additional features</p>
                <span class="font-ubuntu text-black-50">I already have <a href="login">Login</a></span>
            </div>

            <div class="d-flex justify-content-center">
                <div>
                    <?php if(count($errors) > 0):?>
                        <?php foreach ($errors as $error):?>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <form action="" method="POST" enctype="multipart/form-data" id="reg-form">
                    <div class="form-row my-4">
                        <div class="col">
                            <h6 class="text-danger"><?php echo $error??""; ?></h6>
                            <input type="text" placeholder="First Name" name="first_name" id="FirstName" value="<?php echo $_POST['first_name']?? ""; ?>"required class="form-control">
                        </div>
                    </div>
                    <div class="form-row my-4">
                        <div class="col">
                            <input type="text" placeholder="Last Name" name="last_name" id="LastName" value="<?php echo $_POST['last_name']?? ""; ?>"required class="form-control">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="text" placeholder="Contact Number" name="contact_number" id="ContactNumber"  pattern="^[0-9]{6}|[0-9]{8}|[0-9]{11}$" value="<?php echo $_POST['contact_number']?? ""; ?>"required class="form-control">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="text" placeholder="Street Address" name="billing_address" id="BillingAddress" value="<?php echo $_POST['billing_address']?? ""; ?>"required class="form-control">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                            
                            <?php
                                $zipcodes = array('4100','4101','4102','4103','4104','4105','4106','4107','4108','4109','4110','4111','4112','4113','4114','4115','4116','4117','4118','4119','4120','4121','4122','4123','4124','4125');
                                $days = array('01', '02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19', '20', '21', '22','23','24','25','26','27','28','29','30', '31');

                                echo "<select name='fetchzipcode' id='fetchzipcode' class='form-control'>";
                                echo "<option value='' disabled='' selected=''>Zipcode</option>";

                                foreach ($zipcodes as $zipcode){
                                    if($selected_zipcode == $zipcode){

                                        echo "<option selected='selected' value='$zipcode' name='zip_code'>$zipcode</option>";

                                    }else{

                                        echo "<option value='$zipcode' name='zip_code'>$zipcode</option>";
                                    }
                                }

                                echo "</select>" .PHP_EOL;

                            ?>

                            <br>
                            <input type='text' placeholder="Province" name="zipcodename"  id="zipcodename" value="<?php echo $_POST['zipcodename']?? ""; ?>" required class='form-control' disabled>
                            <input type="hidden" placeholder="Zipcode" name="zipcode" value="<?php echo $_POST['zipcode']?? ""; ?>" id="zipcodehidden">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                        <input type="file" class="form-control pt-3 pb-5" name="user_image" accept="image/png, image/jpg, image/jpeg" value="<?php echo $_POST['user_image'] ?>">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="text" placeholder="Username" name="username" value="<?php echo $_POST['username']?? ""; ?>" required class="form-control">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="email" placeholder="Email*" name="email" value="<?php echo $_POST['email']?? ""; ?>" required class="form-control">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                            <div class="hidden" id="hidden">
                                <p style="color:red;">Password should have letters and numbers on it!</p>
                            </div>
                            <input type="password" placeholder="Password" onfocus="showFunction()" onblur="hideFunction()" name="password" id="myPassword" value="<?php echo $_POST['password']?? ""; ?>" required class="form-control">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="password" placeholder="Confirm Password*" name="cpassword" id="mycPassword" value="<?php echo $_POST['cpassword']?? ""; ?>" required class="form-control">
                            <input type="checkbox" id="showpassword" style="margin-top:20px;" onclick="myFunction()" > <label for="showpassword" class="form-check-label font-ubuntu text-black-50">Show Password</label> 
                            <small id="confirm_error" class="text-danger"></small>
                        </div>
                    </div>

                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" required>
                        <label for="agreement" class="form-check-label font-ubuntu text-black-50">I agree <a href="#" onclick="MyWindow=window.open('Terms_And_Condition', 'MyWindow', 'width=600', 'height=300'); return false">term, conditions, and policy </a>(*) </label>
                    </div>

                    <div class="submit-btn text-center my-5">
                        <button type="submit" class="btn btn-warning rounded-pill text-dark px-5">Continue</button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</section>
<!-- #registration area -->


<?php
// footer.php
include ('footer.php');
?>