<?php

require "function.php";
//session_destroy();
    check_login();

include 'config.php';

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
    $update_user_image = $_FILES['update_user_image']['name'];
    $update_user_image_tmp_name = $_FILES['update_user_image']['tmp_name'];
    $update_user_image_folder = 'assets/products/'.$update_user_image;
    $update_zipcode = $_POST['update_zipcode'];
    $update_username = $_POST['update_username'];
    $update_email = $_POST['update_email'];
    $update_password = hash('sha256', $_POST['update_password']);
    $update_cpassword = hash('sha256', $_POST['update_cpassword']);


    if ($update_password == $update_cpassword){
        $update_query = mysqli_query($conn, "UPDATE `user` SET first_name = '$update_firstname', last_name ='$update_lastname', contact_number ='$update_contact_number', billing_address ='$update_billing_address', zipcode ='$update_zipcode', user_image = './assets/products/$update_user_image', username ='$update_username', email ='$update_email', password ='$update_password' WHERE user_id='$update_user_id'") or die("query failed");

        if($update_query){
            move_uploaded_file($update_user_image_tmp_name, $update_user_image_folder);
            echo "<script>alert('Update Completed.') </script>";
            echo "<script>window.top.location='./logout'</script>";

        }else{
            echo "<script>alert('Woops! Something Wrong Went.')</script>";
        }

    }else{
        echo "<script>alert('Password Not Matched.')</script>";

    }

}

if(isset($_POST['cancel_order'])){
    $order_number = $_POST['select_order'];
    $item_status = 'Cancelled';
    $cancel_reason = $_POST['selected_cancel'];
    if($_POST['selected_cancel'] === "Change of Mind"){
        $cancel_reason = $_POST['cancellation_reason'];
    }

    $cancel_query = mysqli_query($conn, "INSERT INTO `transaction` (order_number, user_id, customer_name, item_id, item_brand, item_name, item_price, item_size, item_image, item_quantity, mode_of_payment, date_delivery, date_delivery_day, item_status, cancel_reason, date) 
                                               SELECT order_number, user_id, customer_name, item_id, item_brand, item_name, item_price, item_size, item_image, item_quantity, mode_of_payment, date_delivery, date_delivery_day, '$item_status', '$cancel_reason', now() FROM `checkout` WHERE order_number = '$order_number'") or die("query failed");
    mysqli_query($conn, "DELETE FROM `checkout` WHERE order_number ='$order_number'") or die("query failed");

    echo '<script type="text/javascript">';
    echo 'alert("Cancel Order Successfully")';  //not showing an alert box.
    echo '</script>';
    echo "<script>window.top.location='./welcome'</script>";
}

if(check_login(false)){
    if(!check_verified()){
        header("Location: verify");
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

<section class="edit-form-container2 justify-content-center">

    <?php

    if(isset($_GET['edit'])){
        $edit_id = $_GET['edit'];
        $edit_query = mysqli_query($conn, "SELECT * FROM `user` WHERE user_id = $edit_id");
        if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_assoc($edit_query)){
                ?>

                <form action="" method="post" enctype="multipart/form-data" style="margin-top: 100px;">
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
                            
                            <?php
                                $zipcodes = array('4100','4101','4102','4103','4104','4105','4106','4107','4108','4109','4110','4111','4112','4113','4114','4115','4116','4117','4118','4119','4120','4121','4122','4123','4124','4125');
                                $days = array('01', '02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19', '20', '21', '22','23','24','25','26','27','28','29','30', '31');

                                echo "<select name='fetchzipcode' id='fetchzipcode' class='form-control'>";
                                echo "<option value='' disabled='' selected=''>" . $fetch_edit['zipcode'] . "</option>";

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
                            <input type="hidden" placeholder="Zipcode" name="update_zipcode" value="<?php echo $fetch_edit['zipcode']?? ""; ?>" id="zipcodehidden">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                        <input type="file" class="form-control pt-3 pb-5" name="update_user_image" accept="image/png, image/jpg, image/jpeg" value="<?php echo $fetch_edit['user_image'] ?>">
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
                        <label for="agreement" class="form-check-label font-ubuntu text-black-50">I agree <a href="#" onclick="MyWindow=window.open('Terms_And_Condition', 'MyWindow', 'width=600', 'height=300'); return false">term, conditions, and policy </a>(*) </label>
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

<section id="main-site">
    <?php

    if(isset($_GET['edit'])) {

    }else{

    ?>
    <div class="container py-5" style="margin-top: 100px;">
        <div class="row">
            <div class="col-4 offset-4 shadow py-4">
                <form action="welcome" method="post" enctype="multipart/form-data" id="welcome-form">
                <div class="user-info px-3">
                    <div class="text-center">
                    <?php echo "<h2>Welcome " . $username . "</h2>"; ?>
                    <?php 
                    $user_image = $_SESSION['username']->user_image;
                        if($user_image == "./assets/products/"){
                            echo '<img src="./assets/LOGO.png" alt="User Image" width="80" height="80">';
                        }elseif($user_image == ""){
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
                        <li class="nav-link mb-4"><b>Email: </b><span><?php echo ($_SESSION['username']->email); ?></span></li>
                    </ul>
                    <div class="submit-btn text-center my-6">
                        <a href="welcome?edit=<?php echo $_SESSION['username']->user_id; ?>" class="btn btn-warning rounded-pill text-white px-5" style="text-decoration: none"> <i class="fas fa-edit"></i> Edit </a>
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


    <section class="display-product-table">
        <h1 class="text-center py-2"> Your Order</h1>
        <div class="container py-1" style="position:relative;">
        
        <div class="filters">
            Filter by: <select name="fetchorder" id="fetchorder" >
                <option value="" disabled="" selected="">Select Filter</option>
                <option value="First In">First In</option>
                <option value="First Out">First Out</option>
            </select>
            </div>
            <div class="filters-date">
            <?php
                $months = array('Jan', 'Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
                $days = array('01', '02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19', '20', '21', '22','23','24','25','26','27','28','29','30', '31');

                echo "Filter by Date: <select name='fetchordermonth' id='fetchordermonth'>";
                echo "<option value='' disabled='' selected=''>Month</option>";

                foreach ($months as $month){
                    if($selected_month == $month){

                        echo "<option selected='selected' value='$month' name='update_month'>$month</option>";

                    }else{

                        echo "<option value='$month' name='update_month'>$month</option>";
                    }
                }
                echo "</select>" .PHP_EOL;

                echo "<select name='fetchorderday' id='fetchorderday' disabled>";
                echo "<option value='' disabled='' selected=''>Day</option>";
                foreach ($days as $day){

                    if($selected_day == $day){

                        echo "<option selected='selected' value='$day' name='update_day'>$day</option>";

                    }else{

                        echo "<option value='$day' name='update_day'>$day</option>";

                    }

                }

                echo "</select>";
            ?>
            
            </div>
        </div>
        <div class="containers py-1">
        <div class="container py-1 my-1">
            <div class="row py-3 mt-3">

            <?php
                $user_id =  $_SESSION['username']->user_id;
                $select_checkouts = mysqli_query($conn, "SELECT DISTINCT order_number, user_id FROM `checkout` WHERE user_id='$user_id' ORDER BY order_number");
                $grand_total = 0;
                $zip_code = $_SESSION['username']->zipcode;
                if($zip_code != "4100"){
                    $delivery_fee = 100;
                }else{
                    $delivery_fee = 50;
                }
                if(mysqli_num_rows($select_checkouts) > 0){
                    while($row = mysqli_fetch_assoc($select_checkouts)){
                        $order_number = $row['order_number'];
                        $user_id = $row['user_id'];
                        $grand_total = 0;
            ?>
                <div class="col-12 my-2" style="border: 5px solid #79B861">
                <div class="col-sm-12 my-2">
                    <h6><?php echo $row['order_number'] . PHP_EOL ; ?></h6>
                </div>

                    <?php
                        $order_query = mysqli_query($conn, "SELECT DISTINCT item_status, date_delivery, date_delivery_day FROM `checkout` WHERE order_number = '$order_number'") or die("query failed");
                        while($fetch_order = mysqli_fetch_assoc($order_query)){
                            $date_month = $fetch_order['date_delivery'];
                            $date_day = $fetch_order['date_delivery_day'];
                            (string)$date_delivery = $date_month . $date_day;
                            $input = ($date_delivery);
                            $startdate = strtotime($input);
                            $enddate=strtotime("+1 weeks", $startdate);
                            $delivery_date = $fetch_order['date_delivery'] . PHP_EOL . $fetch_order['date_delivery_day'] . "-" . date("M d", $enddate);

                    ?>

                <div class="col-sm-12 my-2">
                    <h6 class="text-warning">Status: <?php echo $fetch_order['item_status'] ?? "Unknown"; ?></h6>
                </div>

                <div class="col-sm-12 text-right">
                    <small>Delivery Date: <?php echo $delivery_date; ?></small>
                </div>
                            <hr style="border: 1px solid #79B861">

                    <?php
                        }
                    ?>

                    <!-- cart item -->

                        <?php
                            $count_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM `checkout` WHERE user_id='$user_id' AND order_number='$order_number'");
                            $row_count = mysqli_fetch_assoc($count_query);
                            $count_item = $row_count["total"];
                            $order_query = mysqli_query($conn, "SELECT * FROM `checkout` WHERE order_number = '$order_number'") or die("query failed");
                            while($fetch_order = mysqli_fetch_assoc($order_query)){
                                $order_number = $fetch_order['order_number'];
                                $user_id = $fetch_order['user_id'];
                                $item_status = $fetch_order['item_status'];
                                $cart_id = $fetch_order['checkout_id'];
                                $item_id = $fetch_order['item_id'];
                                //echo $order_number , PHP_EOL;
                                //echo 'User ID: ' .$user_id;
                                $check_row = mysqli_num_rows($order_query);
                                $date_month = $fetch_order['date_delivery'];
                                $date_day = $fetch_order['date_delivery_day'];
                                (string)$date_delivery = $date_month . $date_day;
                                $input = ($date_delivery);
                                $startdate = strtotime($input);
                                $enddate=strtotime("+1 weeks", $startdate);
                                $delivery_date = $fetch_order['date_delivery'] . PHP_EOL . $fetch_order['date_delivery_day'] . "-" . date("M d", $enddate);


                        ?>

                        <div class="col-12">
                            <div class="row py-3 mt-3">
                                <div class="col-sm-2">
                                    <img src="<?php echo $fetch_order['item_image'] ?? "./assets/products/product-1.jpg" ?>" style="height: 120px;" alt="cart1" class="img-fluid">
                                </div>
                                <div class="col-sm-10">
                                    <h5 class="font-baloo font-size-20"><?php echo $fetch_order['item_name'] ?? "Unknown"; ?></h5>
                                    <small>Brand: <?php echo $fetch_order['item_brand'] ?? "Brand"; ?></small><br>
                                    <small>Size: <?php echo ucfirst($fetch_order['item_size']) ?? "Small"; ?></small><br>
                                    <small>Pot: <?php echo $fetch_order['pot'] ?? "No Pot"; ?></small>


                                    <!-- product qty -->

                                    <div class="col-sm-12 text-right">
                                        <small>Quantity: <?php echo $fetch_order['item_quantity'] ?? "Brand"; ?></small>
                                    </div>

                                    <!-- !product qty -->

                                    <div class="col-sm-12 text-right">
                                        <small>
                                            <?php 
                                            
                                                $select_cart = mysqli_query($conn, "SELECT * FROM `checkout` WHERE user_id ='$user_id' AND item_id = '$item_id' AND checkout_id='$cart_id'") or die('query failed');
                                                    
                                                while($fetch_cartprice = mysqli_fetch_assoc($select_cart)){
                                                    $size = strtolower($fetch_cartprice['item_size']);
                                                    $pot = $fetch_cartprice['pot'];
                                                    
                                                }
                                            $select_product = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id = '$item_id'");

                                                while($fetch_product = mysqli_fetch_assoc($select_product)){
                                                    
                                                    if($pot != "No Pot"){
                                                        if($size === "small"){
                                                            $item_price = $fetch_product['small_price'];
                                                            $price = ($item_price + 20.00) * $fetch_order['item_quantity'];
                                                        }
                                                        elseif($size === "medium"){
                                                            $item_price = $fetch_product['medium_price'];
                                                            $price = ($item_price + 45.00) * $fetch_order['item_quantity'];
                                                        }
                                                        elseif($size === "large"){
                                                            $item_price = $fetch_product['large_price'];
                                                            $price = ($item_price + 60.00) * $fetch_order['item_quantity'];
                                                        }
                                                    }else{
                                                        if($size === "small"){
                                                            $item_price = $fetch_product['small_price'];
                                                            $price = $item_price  * $fetch_order['item_quantity'];
                                                        }
                                                        elseif($size === "medium"){
                                                            $item_price = $fetch_product['medium_price'];
                                                            $price = $item_price  * $fetch_order['item_quantity'];
                                                        }
                                                        elseif($size === "large"){
                                                            $item_price = $fetch_product['large_price'];
                                                            $price = $item_price * $fetch_order['item_quantity'];
                                                        }
                                                    }
                                                }
                                                echo "₱" . number_format($price,2) ?? 0;
                                            ?>
                                        </small>
                                    </div>

                                </div>


                            </div>
                        </div>
                                <hr style="border: 1px solid #79B861">
                    <?php
                         $totalprice = intval($price);
                         $grand_total += $totalprice;
                    }

                    ?>
                    <!-- !cart item -->

                    <div class="col-sm-12 text-right mb-4">
                        <div class="font-size-20 text-danger font-baloo">
                        <h6 style="text-align: right; color: black;">Subtotal: <span style="">₱<?php echo number_format($grand_total, 2) ?? 0; ?></span></h6>
                        <h6 style="text-align: right; color: black;">Delivery Fee: <span style="">₱<?php echo number_format($delivery_fee, 2) ?? 0; ?></span></h6>
                            Total(<?php echo $count_item ?? 1; ?> <?php if($count_item > 1){
                                echo 'items):';
                            }else{
                                echo 'item):';
                            }?> ₱<span class="product_price" data-id="<?php echo $fetch_cart['item_id'] ?? 0; ?>"><?php echo number_format($grand_total + $delivery_fee,2); ?></span>
                        </div>
                        <!-- Trigger the modal with a button -->
                        <form action="" method="post">
                            
                            <button type="button" name="cancel" class="btn btn-danger" data-toggle="modal" data-target="#cancelModal<?php echo trim(str_replace('Order: ','',$row['order_number'])); ?>">Cancel Order</button>
                            <!-- Checkout Modal-->
                            <div class="modal fade" id="cancelModal<?php echo trim(str_replace('Order: ','',$row['order_number'])); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Cancel Order?</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>

                                        <div class="modal-body text-center">Select Cancellation Reason</div>
                                            <div class="modal-footer">
                                                <div class="modal-body">
                                                    <div class="sub-total text-left">
                                                        <div class="warning" style="background-color:#FEE9CC; margin: -32px; margin-bottom: 20px; padding-left: 20px; padding-right:20px; padding-top:20px; padding-bottom:7px;">
                                                            <div class="warning-exlamation" style="width:20px;position:relative; margin-bottom: -30px; margin-left: -10px;"><i class="fas fa-exclamation-circle text-warning"></i></div>
                                                            <div class="container">
                                                                <h6 class="font-size-12 font-rale py-1" style="color:#FF9300;">Please select a cancellation reason. Take note that upon order cancellation, refund process time may take up to 24-48 hours for Urban Gardener.</h6>
                                                            </div>
                                                        </div>

                                                        <input type="radio"  onclick="hideReason()" placeholder="Cancel Select" value="Need to change delivery address" name="selected_cancel" id="ChangeDeliveryAddress<?php echo trim(str_replace('Order: ','',$row['order_number'])); ?>" value="<?php echo $cancel_reason; ?>"required checked>
                                                        <label for="ChangeDeliveryAddress<?php echo trim(str_replace('Order: ','',$row['order_number'])); ?>" onclick="hideReason()">Need to change delivery address</label><br>
                                                        <input type="radio" onclick="hideReason()" placeholder="Cancel Select" value="Seller is not responsive to my inquiries" name="selected_cancel" id="NotResponsive<?php echo trim(str_replace('Order: ','',$row['order_number'])); ?>" value="<?php echo $cancel_reason; ?>"required>
                                                        <label for="NotResponsive<?php echo trim(str_replace('Order: ','',$row['order_number'])); ?>" onclick="hideReason()">Seller is not responsive to my inquiries</label><br>
                                                        <input type="radio" onclick="showReason()" placeholder="Cancel Select" value="Change of Mind" name="selected_cancel" id="ChangeOfMind<?php echo trim(str_replace('Order: ','',$row['order_number'])); ?>" value="<?php echo $cancel_reason; ?>"required>
                                                        <label for="ChangeOfMind<?php echo trim(str_replace('Order: ','',$row['order_number'])); ?>" onclick="showReason()">Others / change of mind</label>
                                                        <?php 

                                                        ?>
                                                        <input type="hidden" name="select_order" id="orderNumber" value="<?php echo $order_number ?? '000001' ?>">
                                                        <textarea name="cancellation_reason" id="cancellationReason" style="display:none;" class="form-control" placeholder="Type Reason Here"></textarea>
                                                    </div>

                                                    <div class="container text-center">
                                                        <button class="btn btn-secondary mt-3" type="button" data-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-primary mt-3" type="submit" name="cancel_order">Confirm</button>
                                                    </div>
                                                    
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </form>

                    </div>
                    <?php
                };
            }else{
                echo "<div class='empty'>No products in your order</div>";
            };
            ?>
            
            </div>
        </div>
        </div>

    </section>

    <section class="display-product-table">
        <h1 class="text-center py-2"> Your Reservation</h1>
        <div class="container py-1" style="position:relative;">
        
        <div class="filters">
            Filter by: <select name="fetchreservation" id="fetchreservation" >
                <option value="" disabled="" selected="">Select Filter</option>
                <option value="First In">First In</option>
                <option value="First Out">First Out</option>
            </select>
            </div>
        </div>
        <div class="containerss py-1">
        <div class="container py-1 my-1">
            <div class="row py-3 mt-3">

                <?php

                $select_checkouts = mysqli_query($conn, "SELECT DISTINCT reserve_number, user_id FROM `reserve_orders` WHERE user_id='$user_id' ORDER BY reserve_number");
                $grand_total = 0;
                if(mysqli_num_rows($select_checkouts) > 0){
                    while($row = mysqli_fetch_assoc($select_checkouts)){
                        $order_number = $row['reserve_number'];
                        $user_id = $row['user_id'];
                        $grand_total = 0;
                        ?>
                        <div class="col-12 my-2" style="border: 5px solid #79B861">
                            <div class="col-sm-12 my-2">
                                <h6><?php echo $row['reserve_number'] . PHP_EOL ; ?></h6>
                            </div>

                            <?php
                            $order_query = mysqli_query($conn, "SELECT DISTINCT item_status FROM `reserve_orders` WHERE reserve_number = '$order_number'") or die("query failed");
                            while($fetch_order = mysqli_fetch_assoc($order_query)){

                                ?>

                                <div class="col-sm-12 my-2">
                                    <h6>Status: <?php echo $fetch_order['item_status'] ?? "Unknown"; ?></h6>
                                </div>

                                <hr style="border: 1px solid #79B861">

                                <?php
                            }
                            ?>

                            <!-- cart item -->

                            <?php
                            $count_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM `reserve_orders` WHERE user_id='$user_id' AND reserve_number='$order_number'");
                            $row_count = mysqli_fetch_assoc($count_query);
                            $count_item = $row_count["total"];
                            $order_query = mysqli_query($conn, "SELECT * FROM `reserve_orders` WHERE reserve_number = '$order_number'") or die("query failed");
                            while($fetch_order = mysqli_fetch_assoc($order_query)){
                                $order_number = $fetch_order['reserve_number'];
                                $user_id = $fetch_order['user_id'];
                                $item_status = $fetch_order['item_status'];
                                //echo $order_number , PHP_EOL;
                                //echo 'User ID: ' .$user_id;
                                $check_row = mysqli_num_rows($order_query);
                                //$date_month = $fetch_order['date_delivery'];
                                //$date_day = $fetch_order['date_delivery_day'];
                                //(string)$date_delivery = $date_month . $date_day;
                                //$input = ($date_delivery);
                                //$startdate = strtotime($input);
                                //$enddate=strtotime("+1 weeks", $startdate);
                                //$delivery_date = $fetch_order['date_delivery'] . PHP_EOL . $fetch_order['date_delivery_day'] . "-" . date("M d", $enddate);


                                ?>

                                <div class="col-12">
                                    <div class="row py-3 mt-3">
                                        <div class="col-sm-2">
                                            <img src="<?php echo $fetch_order['item_image'] ?? "./assets/products/product-1.jpg" ?>" style="height: 120px;" alt="cart1" class="img-fluid">
                                        </div>
                                        <div class="col-sm-10">
                                            <h5 class="font-baloo font-size-20"><?php echo $fetch_order['item_name'] ?? "Unknown"; ?></h5>
                                            <small>Brand: <?php echo $fetch_order['item_brand'] ?? "Brand"; ?></small><br>
                                            <small>Size: <?php echo ucfirst($fetch_order['item_size']) ?? "Small"; ?></small><br>
                                            <small>Pot: <?php echo $fetch_order['pot'] ?? "No Pot"; ?></small>


                                            <!-- product qty -->

                                            <div class="col-sm-12 text-right">
                                                <small>Quantity: <?php echo $fetch_order['item_quantity'] ?? "Brand"; ?></small>
                                            </div>

                                            <!-- !product qty -->

                                        </div>


                                    </div>
                                </div>

                                <hr style="border: 1px solid #79B861">
                                <?php
                                $totalprice = $fetch_order['item_price'] * $fetch_order['item_quantity'];
                                $grand_total += $totalprice;
                            }

                            ?>
                            <!-- !cart item -->

                            <div class="col-sm-12 text-right mb-4">
                                <div class="font-size-20 text-danger font-baloo">
                                <h6 style="text-align: right; color: black;">Subtotal: <span style="">₱<?php echo number_format($grand_total, 2) ?? 0; ?></span></h6>
                                <h6 style="text-align: right; color: black;">Delivery Fee: <span style="">₱<?php echo number_format($delivery_fee, 2) ?? 0; ?></span></h6>
                            
                                    Total(<?php echo $count_item ?? 1; ?> <?php if($count_item > 1){
                                        echo 'items):';
                                    }else{
                                        echo 'item):';
                                    }?> ₱<span class="product_price" data-id="<?php echo $fetch_cart['item_id'] ?? 0; ?>"><?php echo number_format($grand_total + $delivery_fee,2); ?></span>
                                </div>
                            </div>

                        </div>

                        <?php
                    };
                }else{
                    echo "<div class='empty'>No products in your reservation</div>";
                };
                ?>
            </div>
        </div>
        </div>
        <?php

        //echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";

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