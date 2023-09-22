<?php
//include header.php file
include ('./includes/header.php');

?>

<?php
include ('./config.php');

//error_reporting(0);

//print_r($_SESSION);
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

if(isset($_POST['reschedule'])){
    $order_number = $_POST['order_input'];
    $date_delivery_month = $_POST['update_month'];
    $date_delivery_day = $_POST['update_day'];

    $update_query = mysqli_query($conn, "UPDATE `checkout` SET date_delivery = '$date_delivery_month', date_delivery_day = '$date_delivery_day' WHERE order_number ='$order_number'") or die("query failed");

    echo '<script type="text/javascript">';
    echo 'alert("Reschedules Succesfully")';  //not showing an alert box.
    echo '</script>';
    echo "<script>window.top.location='./deliveries'</script>";
}

if(isset($_POST['mark_as_done'])){
    $order_number = $_POST['order_input'];

    $status_query = mysqli_query($conn, "UPDATE `checkout` SET item_status = 'Completed' WHERE order_number ='$order_number'") or die("query failed");

    $confirm_query = mysqli_query($conn, "INSERT INTO `transaction` (user_id, customer_name, item_id, item_brand, item_name, item_price, item_size, item_image, item_quantity, order_number, mode_of_payment, date_delivery, date_delivery_day, item_status, date) SELECT user_id, customer_name, item_id, item_brand, item_name, item_price, item_size, item_image, item_quantity, order_number, mode_of_payment, date_delivery, date_delivery_day, 'Completed', now() FROM `checkout` WHERE order_number = '$order_number'") or die("query failed");

    //$delete_query = mysqli_query($conn, "DELETE FROM `checkout` WHERE order_number='$order_number'");

    echo '<script type="text/javascript">';
    echo 'alert("Orders Sent to Transaction")';  //not showing an alert box.
    echo '</script>';
    echo "<script>window.top.location='./deliveries'</script>";
}

if(isset($_POST['search_submit'])){
    $_SESSION['search'] = $_POST['search'];
    $search = $_SESSION['search'];

    //header("Location: ");
}

?>



<?php

//include navbar.php file
include('./includes/navbar.php')
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
            <form method="post"
                  class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                           aria-label="Search" name="search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" name="search_submit" type="submit">
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


        <!--  Pending Orders   -->
        <div class="container py-1" style="position: relative;">
            <h4 class="font-eduvic font-size-24 py-1" style="color:black;">Scheduled Deliveries</h4>
            <div class="filters">
            Filter by: <select name="fetchdeliveries" id="fetchdeliveries" >
                <option value="" disabled="" selected="">Select Filter</option>
                <option value="First In">First In</option>
                <option value="First Out">First Out</option>
            </select>
            </div>
            <div class="filters-date">
            <?php
                $months = array('Jan', 'Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
                $days = array('01', '02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19', '20', '21', '22','23','24','25','26','27','28','29','30', '31');

                echo "Filter by Date: <select name='fetchmonthdeliveries' id='fetchmonthdeliveries'>";
                echo "<option value='' disabled='' selected=''>Month</option>";

                foreach ($months as $month){
                    if($selected_month == $month){

                        echo "<option selected='selected' value='$month' name='update_month'>$month</option>";

                    }else{

                        echo "<option value='$month' name='update_month'>$month</option>";
                    }
                }
                echo "</select>" . PHP_EOL;

                echo "<select name='fetchdaydeliveries' id='fetchdaydeliveries' disabled>";
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
            <hr>
        </div>
        <div class="containers py-1" style="width: 1300px; height: 545px; overflow: auto;">

            <div class="container py-1 my-1 col-auto">
                <div class="row font-rale">

                    <?php

                    if(isset($search)){
                        $search = $_SESSION['search'];
                        $checkout_query = mysqli_query($conn, "SELECT DISTINCT order_number, user_id, item_status FROM `checkout` WHERE order_number LIKE '%$search%' AND item_status = 'Delivering' or mode_of_payment LIKE '%$search%' AND item_status = 'Delivering'  or customer_name LIKE '%$search%' AND item_status = 'Delivering' ORDER BY order_number") or die('query failed');
                    if(mysqli_num_rows($checkout_query) > 0){
                        $grand_total = 0;
                        while($fetch_checkout = mysqli_fetch_assoc($checkout_query)){
                        $order_number = $fetch_checkout['order_number'];
                        $user_id = $fetch_checkout['user_id'];
                        $item_status = $fetch_checkout['item_status'];
                        $order_query = mysqli_query($conn, "SELECT * FROM `checkout` WHERE order_number = '$order_number'") or die("query failed");
                        $user_query = mysqli_query($conn, "SELECT * FROM `user` WHERE user_id = '$user_id'");
                        while($fetch_user = mysqli_fetch_assoc($user_query)){
                        $first_name = $fetch_user['first_name'];
                        $last_name = $fetch_user['last_name'];
                        $billing_address = $fetch_user['billing_address'];
                        $zip_code = $fetch_user['zipcode'];
                            if($zip_code != "4100"){
                                $delivery_fee = 100;
                            }else{
                                $delivery_fee = 50;
                            }
                        ?>

                            <div class="col-auto order-pending">

                            <div class="order-number" style="padding: 10px 10px 1px 10px; background-color: green; color: white;">
                                <h5 style="text-align: center;"><b><?php echo $order_number; ?></b></h5>
                            </div>

                            <div class="order-body">
                            <h6>Customer Name: <?php echo $first_name . " ".$last_name; ?></h6>
                            <h6>Address: <?php echo $billing_address; ?></h6>
                            <table class="table table-sm table-responsive" style="color: black;">

                                <thead>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                </thead>



                                <?php
                                }
                                while($fetch_order = mysqli_fetch_assoc($order_query)){
                                $order_number = $fetch_order['order_number'];
                                $user_id = $fetch_order['user_id'];
                                $item_status = $fetch_order['item_status'];
                                $check_row = mysqli_num_rows($order_query);
                                $item_size = $fetch_order['item_size'];
                                $pot = $fetch_order['pot'];
                                $item_id = $fetch_order['item_id'];
                                if($item_size == ""){
                                    $item_size = "Small";
                                }

                                $select_product = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id = '$item_id'");
                                                    
                                while($fetch_product = mysqli_fetch_assoc($select_product)){
                                
                                    if($pot != "No Pot"){
                                        if($item_size === "small" || $item_size === "Small"){
                                            $item_price = $fetch_product['small_price'];
                                            $price = ($item_price + 20.00);
                                        }
                                        elseif($item_size === "medium" || $item_size === "Medium"){
                                            $item_price = $fetch_product['medium_price'];
                                            $price = ($item_price + 45.00);
                                        }
                                        elseif($item_size === "large" || $item_size === "Large"){
                                            $item_price = $fetch_product['large_price'];
                                            $price = ($item_price + 60.00);
                                        }
                                    }else{
                                        if($item_size === "small" || $item_size === "Small"){
                                            $item_price = $fetch_product['small_price'];
                                            $price = $item_price;
                                        }
                                        elseif($item_size === "medium" || $item_size === "Medium"){
                                            $item_price = $fetch_product['medium_price'];
                                            $price = $item_price;
                                        }
                                        elseif($item_size === "large" || $item_size === "Large"){
                                            $item_price = $fetch_product['large_price'];
                                            $price = $item_price;
                                        }
                                    }

                                }

                                ?>
                                <tbody>
                                <tr>
                                    <td class="align-content-center"><?php echo $fetch_order['item_name'] . PHP_EOL . "<br>Size: " . ucfirst($item_size) . PHP_EOL . "<br>Pot: " . $fetch_order['pot'] ?? "No Pot"; ?></td>
                                    <td class="align-content-center"><?php echo $fetch_order['item_quantity'] ?></td>
                                    <td class="align-content-center">₱<?php echo number_format($price,2) ?? 0 ?></td>
                                </tr>


                                <?php
                                $sub_total = intval($fetch_order['item_price']);
                                $grand_total += intval($sub_total);
                                ?>

                                <?php
                                }
                                ?>

                                </tbody>
                            </table>
                            <hr>
                                <h6 style="text-align: right;">Subtotal: <span style="">₱<?php echo number_format($grand_total, 2) ?? 0; ?></span></h6>
                                <h6 style="text-align: right;">Delivery Fee: <span style="">₱<?php echo number_format($delivery_fee, 2) ?? 0; ?></span></h6>
                                <h6 style="text-align: right;">Total: <span style="color: Red;">₱<?php echo number_format($grand_total + $delivery_fee, 2) ?? 0; ?></span></h6><hr>
                                <h6><b>Mode of Payment:</b></h6>
                            <div class="form-check">
                                <input class="form-check-input" disabled type="checkbox" name="cash_on_delivery" value="Cash On Delivery" id="flexCheckDefault"
                                    <?php
                                    $order_query = mysqli_query($conn, "SELECT * FROM `checkout` WHERE order_number = '$order_number'") or die("query failed");
                                    while($fetch_order = mysqli_fetch_assoc($order_query)){
                                        $order_number = $fetch_order['order_number'];
                                        $user_id = $fetch_order['user_id'];
                                        $check_row = mysqli_num_rows($order_query);
                                        $mode_of_payment = $fetch_order['mode_of_payment'];
                                        if ($mode_of_payment == "Cash On Delivery") {
                                            $checker = 'checked';
                                        }else {
                                            $checker = 'unchecked';
                                        }
                                    }
                                    echo $checker; ?> >
                                <label class="form-check-label" name="cash_on_delivery" for="flexCheckDefault" style="color: black;">
                                    Cash on Delivery
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" disabled type="checkbox" name="update_item_reservation" value="Reservation" id="flexCheckDefault"
                                    <?php
                                    $order_query = mysqli_query($conn, "SELECT * FROM `checkout` WHERE order_number = '$order_number'") or die("query failed");
                                    while($fetch_order = mysqli_fetch_assoc($order_query)){
                                        $order_number = $fetch_order['order_number'];
                                        $user_id = $fetch_order['user_id'];
                                        $check_row = mysqli_num_rows($order_query);
                                        $mode_of_payment = $fetch_order['mode_of_payment'];
                                        if ($mode_of_payment == "Bank Transfer") {
                                            $checker = 'checked';
                                        }else {
                                            $checker = 'unchecked';
                                        }
                                    }
                                    echo $checker; ?>>
                                <label class="form-check-label" name="update_item_reservation" for="flexCheckDefault" style="color: black;">
                                GCash
                                </label>
                            </div><br>
                            <?php
                            $order_query = mysqli_query($conn, "SELECT * FROM `checkout` WHERE order_number ='$order_number'") or die("query failed");
                            $fetch_order = mysqli_fetch_assoc($order_query);
                            $item_status = $fetch_order['item_status'];
                            $delivery_date = $fetch_order['date_delivery'];
                            ?>

                            <div class="container" style="text-align: center; padding: 20px">
                                <form action="" method="post">
                                    <input type="hidden" name="order_input" value="<?php echo $fetch_checkout['order_number'] ?? '000001' ?>">
                                    <h6>Delivery Date: <?php

                                        $selected_month = $fetch_order['date_delivery'];
                                        $selected_day = $fetch_order['date_delivery_day'];
                                        $months = array('Jan', 'Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
                                        $days = array('1', '2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19', '20', '21', '22','23','24','25','26','27','28','29','30', '31');

                                        echo "<select id='month' name='update_month'>";
                                        foreach ($months as $month){
                                            if($selected_month == $month){
                                                echo "<option selected='selected' value='$month' name='update_month'>$month</option>";
                                            }else{
                                                echo "<option value='$month' name='update_month'>$month</option>";
                                            }


                                        }
                                        echo "</select>" . PHP_EOL;

                                        echo "<select id='day' name='update_day'>";
                                        foreach ($days as $day){

                                            if($selected_day == $day){
                                                echo "<option selected='selected' value='$day' name='update_day'>$day</option>";
                                            }else{
                                                echo "<option value='$day' name='update_day'>$day</option>";
                                            }

                                        }
                                        echo "</select>";
                                        ?>



                                    </h6>
                                    <button type="submit"  name="reschedule" class="btn btn-warning">Reschedule</button>
                                    <button type="submit"  name="mark_as_done" class="btn btn-success">Mark as Done</button>
                                </form>
                            </div>
                            </div>
                        </div>
                        <?php
                        //$grand_total += $sub_total;
                        $grand_total = 0;

                        }

                        }else {
                            echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">No Result Found</td></tr>';
                        }
                    ?>
                    <?php
                    }else{
                        $checkout_query = mysqli_query($conn, "SELECT DISTINCT order_number, user_id, item_status FROM `checkout` WHERE item_status = 'Delivering' ORDER BY order_number") or die('query failed');
                        $grand_total = 0;
                        if(mysqli_num_rows($checkout_query) > 0){
                            while($fetch_checkout = mysqli_fetch_assoc($checkout_query)){
                                $order_number = $fetch_checkout['order_number'];
                                $user_id = $fetch_checkout['user_id'];
                                //echo $order_number , PHP_EOL;
                                //echo 'User ID: ' .$user_id;
                                $order_query = mysqli_query($conn, "SELECT * FROM `checkout` WHERE order_number = '$order_number'") or die("query failed");
                                $user_query = mysqli_query($conn, "SELECT * FROM `user` WHERE user_id = '$user_id'");
                                while($fetch_user = mysqli_fetch_assoc($user_query)){
                                    $first_name = $fetch_user['first_name'];
                                    $last_name = $fetch_user['last_name'];
                                    $billing_address = $fetch_user['billing_address'];
                                    $zip_code = $fetch_user['zipcode'];
                                    if($zip_code != "4100"){
                                        $delivery_fee = 100;
                                    }else{
                                        $delivery_fee = 50;
                                    }
                                    ?>

                                    <div class="col-auto order-pending">

                                    <div class="order-number" style="padding: 10px 10px 1px 10px; background-color: green; color: white;">
                                        <h5 style="text-align: center;"><b><?php echo $order_number; ?></b></h5>
                                    </div>
                                    
                                    <div class="order-body">
                                        <h6>Customer Name: <?php echo $first_name . " ".$last_name; ?></h6>
                                        <h6>Address: <?php echo $billing_address; ?></h6>
                                    
                                    
                                    <table class="table table-sm table-responsive" style="color: black;">

                                    <thead>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    </thead>



                                    <?php
                                }
                            while($fetch_order = mysqli_fetch_assoc($order_query)){
                                $order_number = $fetch_order['order_number'];
                                $user_id = $fetch_order['user_id'];
                                $item_status = $fetch_order['item_status'];
                                $pot = $fetch_order['pot'];
                                $item_id = $fetch_order['item_id'];
                                //echo $order_number , PHP_EOL;
                                //echo 'User ID: ' .$user_id;
                                $check_row = mysqli_num_rows($order_query);
                                $item_size = strtolower($fetch_order['item_size']);
                                if($item_size == ""){
                                    $item_size = "Small";
                                }

                                $select_product = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id = '$item_id'");
                                                        
                                    while($fetch_product = mysqli_fetch_assoc($select_product)){
                                    
                                        if($pot != "No Pot"){
                                            if($item_size === "small" || $item_size === "Small"){
                                                $item_price = $fetch_product['small_price'];
                                                $price = ($item_price + 20.00);
                                            }
                                            elseif($item_size === "medium" || $item_size === "Medium"){
                                                $item_price = $fetch_product['medium_price'];
                                                $price = ($item_price + 45.00);
                                            }
                                            elseif($item_size === "large" || $item_size === "Large"){
                                                $item_price = $fetch_product['large_price'];
                                                $price = ($item_price + 60.00);
                                            }
                                        }else{
                                            if($item_size === "small" || $item_size === "Small"){
                                                $item_price = $fetch_product['small_price'];
                                                $price = $item_price;
                                            }
                                            elseif($item_size === "medium" || $item_size === "Medium"){
                                                $item_price = $fetch_product['medium_price'];
                                                $price = $item_price;
                                            }
                                            elseif($item_size === "large" || $item_size === "Large"){
                                                $item_price = $fetch_product['large_price'];
                                                $price = $item_price;
                                            }
                                        }
    
                                    }

                                ?>
                                <tbody>
                                <tr>
                                    <td class="align-content-center"><?php echo $fetch_order['item_name'] . PHP_EOL . "<br>Size: " . ucfirst($item_size) . PHP_EOL . "<br>Pot: " . $fetch_order['pot'] ?? "No Pot"; ?></td>
                                    <td class="align-content-center"><?php echo $fetch_order['item_quantity'] ?></td>
                                    <td class="align-content-center">₱<?php echo number_format($price,2) ?? 0; ?></td>
                                </tr>


                            <?php
                            $sub_total = intval($price * $fetch_order['item_quantity']);
                            $grand_total += intval($sub_total);
                            ?>

                                <?php
                            }
                                ?>

                                </tbody>
                                </table>
                                
                                <hr>
                                    <h6 style="text-align: right;">Subtotal: <span style="">₱<?php echo number_format($grand_total, 2) ?? 0; ?></span></h6>
                                    <h6 style="text-align: right;">Delivery Fee: <span style="">₱<?php echo number_format($delivery_fee, 2) ?? 0; ?></span></h6>
                                    <h6 style="text-align: right;">Total: <span style="color: Red;">₱<?php echo number_format($grand_total + $delivery_fee, 2) ?? 0; ?></span></h6><hr>
                                    <h6><b>Mode of Payment:</b></h6>
                                <div class="form-check">
                                    <input class="form-check-input" disabled type="checkbox" name="cash_on_delivery" value="Cash On Delivery" id="flexCheckDefault"
                                        <?php
                                        $order_query = mysqli_query($conn, "SELECT * FROM `checkout` WHERE order_number = '$order_number'") or die("query failed");
                                        while($fetch_order = mysqli_fetch_assoc($order_query)){
                                            $order_number = $fetch_order['order_number'];
                                            $user_id = $fetch_order['user_id'];
                                            $check_row = mysqli_num_rows($order_query);
                                            $mode_of_payment = $fetch_order['mode_of_payment'];
                                            if ($mode_of_payment == "Cash On Delivery") {
                                                $checker = 'checked';
                                            }else {
                                                $checker = 'unchecked';
                                            }
                                        }
                                        echo $checker; ?> >
                                    <label class="form-check-label" name="cash_on_delivery" for="flexCheckDefault" style="color: black;">
                                        Cash on Delivery
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" disabled type="checkbox" name="update_item_reservation" value="Reservation" id="flexCheckDefault"
                                        <?php
                                        $order_query = mysqli_query($conn, "SELECT * FROM `checkout` WHERE order_number = '$order_number'") or die("query failed");
                                        while($fetch_order = mysqli_fetch_assoc($order_query)){
                                            $order_number = $fetch_order['order_number'];
                                            $user_id = $fetch_order['user_id'];
                                            $check_row = mysqli_num_rows($order_query);
                                            $mode_of_payment = $fetch_order['mode_of_payment'];
                                            if ($mode_of_payment == "Bank Transfer") {
                                                $checker = 'checked';
                                            }else {
                                                $checker = 'unchecked';
                                            }
                                        }
                                        echo $checker; ?>>
                                    <label class="form-check-label" name="update_item_reservation" for="flexCheckDefault" style="color: black;">
                                        GCash
                                    </label>
                                </div><br>
                                <?php
                                $order_query = mysqli_query($conn, "SELECT * FROM `checkout` WHERE order_number ='$order_number'") or die("query failed");
                                $fetch_order = mysqli_fetch_assoc($order_query);
                                $item_status = $fetch_order['item_status'];
                                $delivery_date = $fetch_order['date_delivery'];
                                ?>

                                <div class="container" style="text-align: center; padding: 20px">
                                    <form action="" method="post">
                                        <input type="hidden" name="order_input" value="<?php echo $fetch_checkout['order_number'] ?? '000001' ?>">
                                        <h6>Delivery Date: <?php

                                            $selected_month = $fetch_order['date_delivery'];
                                            $selected_day = $fetch_order['date_delivery_day'];
                                            $months = array('Jan', 'Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
                                            $days = array('1', '2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19', '20', '21', '22','23','24','25','26','27','28','29','30', '31');

                                            echo "<select id='month' name='update_month'>";
                                            foreach ($months as $month){
                                                if($selected_month == $month){
                                                    echo "<option selected='selected' value='$month' name='update_month'>$month</option>";
                                                }else{
                                                    echo "<option value='$month' name='update_month'>$month</option>";
                                                }


                                            }
                                            echo "</select>" . PHP_EOL;

                                            echo "<select id='day' name='update_day'>";
                                            foreach ($days as $day){

                                                if($selected_day == $day){
                                                    echo "<option selected='selected' value='$day' name='update_day'>$day</option>";
                                                }else{
                                                    echo "<option value='$day' name='update_day'>$day</option>";
                                                }

                                            }
                                            echo "</select>";
                                            ?>



                                        </h6>
                                        <button type="submit"  name="reschedule" class="btn btn-warning">Reschedule</button>
                                        <button type="submit"  name="mark_as_done" class="btn btn-success">Mark as Done</button>
                                    </form>
                                </div>
                                </div>
                                </div>
                                <?php
                                //$grand_total += $sub_total;
                                $grand_total = 0;

                            }

                        }else {
                            echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">No Result Found</td></tr>';
                        }
                    }


                    ?>

                </div>
            </div>
        </div>
    </div>


    <!--- !Pending Orders --->



<?php

//include scripts.php file
include('./includes/scripts.php')
?>

<?php

//include footer.php file
include('./includes/footer.php')
?>
