<?php
//include header.php file
include ('./includes/header.php');

?>

<?php

//include navbar.php file
include('./includes/navbar.php')
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

if(isset($_POST['confirm_order'])){
    $reserve_number = $_POST['reserve_input'];
    $date_delivery = $_POST['date_delivery'];

    $query ="SELECT order_number FROM `checkout` ORDER BY order_number desc" or die("query failed");
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $last_order = $row['order_number'];
    if(empty($last_order)){
        $order_number = "Order: 000001";
    }else{
        $idd = str_replace("Order: ", "",$last_order);
        $id = str_pad($idd + 1,6,0,STR_PAD_LEFT);
        $order_number = 'Order: ' .$id;
    }

    $update_query = mysqli_query($conn, "UPDATE `reserve_orders` SET reserve_number='$order_number' WHERE reserve_number='$reserve_number'");

    $confirm_query = mysqli_query($conn, "INSERT INTO `checkout` (user_id, item_id, item_brand, item_name, item_price, item_size, pot, item_image, item_quantity, order_number, mode_of_payment, date_delivery) SELECT user_id, item_id, item_brand, item_name, item_price, item_size, pot, item_image, item_quantity, '$order_number', mode_of_payment, '$date_delivery' FROM `reserve_orders` WHERE reserve_number = '$order_number'") or die("query failed");

    $delete_query = mysqli_query($conn, "DELETE FROM `reserve_orders` WHERE reserve_number='$order_number'");

    echo '<script type="text/javascript">';
    echo 'alert("Reservation moved to Orders")';  //not showing an alert box.
    echo '</script>';
    echo "<script>window.top.location='./reservation'</script>";
}

if(isset($_POST['cancel_reserve'])){
    $reserve_number = $_POST['reserve_input'];
    mysqli_query($conn, "DELETE FROM `reserve_orders` WHERE reserve_number ='$reserve_number'") or die("query failed");

    echo '<script type="text/javascript">';
    echo 'alert("Delete Reservation Successfully")';  //not showing an alert box.
    echo '</script>';
    echo "<script>window.top.location='./reservation'</script>";
}

if(isset($_POST['search_submit'])){
    $_SESSION['search'] = $_POST['search'];
    $search = $_SESSION['search'];

    //header("Location: ");
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
            <h4 class="font-eduvic font-size-24" style="color:black;">List of Reservation</h4>
            <div class="filters">
            Filter by: <select name="fetchreservation" id="fetchreservation" >
                <option value="" disabled="" selected="">Select Filter</option>
                <option value="First In">First In</option>
                <option value="First Out">First Out</option>
            </select>
            </div>
            <hr>
        </div>
        <div class="containers py-1" style="width: 1300px; height: 550px;overflow: auto">

            <div class="container py-1 my-1 ">
                <div class="row  font-rale">

                    <?php

                    if(isset($search)){
                        $search = $_SESSION['search'];
                        $reserve_query = mysqli_query($conn, "SELECT DISTINCT reserve_number, user_id FROM `reserve_orders` WHERE reserve_number LIKE '%$search%' or mode_of_payment LIKE '%$search%' or item_status LIKE '%$search%' or customer_name LIKE '%$search%'  ORDER BY reserve_number") or die('query failed');
                        $grand_total = 0;
                        if(mysqli_num_rows($reserve_query) > 0){
                            while($fetch_reserve = mysqli_fetch_assoc($reserve_query)){
                                $reserve_number = $fetch_reserve['reserve_number'];
                                $user_id = $fetch_reserve['user_id'];
                                //echo $order_number , PHP_EOL;
                                //echo 'User ID: ' .$user_id;
                                $reserve_order_query = mysqli_query($conn, "SELECT * FROM `reserve_orders` WHERE reserve_number = '$reserve_number'") or die("query failed");
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
                                        <h5 style="text-align: center;">Reserve <?php echo $reserve_number; ?></h5>
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
                            while($fetch_reserve_order = mysqli_fetch_assoc($reserve_order_query)){
                                $reserve_order_number = $fetch_reserve_order['reserve_number'];
                                $user_id = $fetch_reserve_order['user_id'];
                                $pot = $fetch_reserve_order['pot'];
                                $item_id = $fetch_reserve_order['item_id'];
                                //echo $reserve_order_number , PHP_EOL;
                                //echo 'User ID: ' .$user_id;
                                $check_row = mysqli_num_rows($reserve_order_query);
                                $item_size = $fetch_reserve_order['item_size'];
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
                                    <td class="align-content-center"><?php echo $fetch_reserve_order['item_name'] . PHP_EOL . "<br>Size: " . ucfirst($item_size) . PHP_EOL . "<br>Pot: " . $fetch_reserve_order['pot'] ?? "No Pot"; ?></td>
                                    <td class="align-content-center"><?php echo $fetch_reserve_order['item_quantity'] ?></td>
                                    <td class="align-content-center">₱<?php echo number_format($price,2) ?? 0; ?></td>
                                </tr>


                            <?php
                            $sub_total = intval($price * $fetch_reserve_order['item_quantity']);
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
                                        $order_query = mysqli_query($conn, "SELECT * FROM `reserve_orders` WHERE reserve_number = '$reserve_number'") or die("query failed");
                                        while($fetch_order = mysqli_fetch_assoc($order_query)){
                                            $reserve_order_number = $fetch_order['reserve_number'];
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
                                        $order_query = mysqli_query($conn, "SELECT * FROM `reserve_orders` WHERE reserve_number = '$reserve_order_number'") or die("query failed");
                                        while($fetch_order = mysqli_fetch_assoc($order_query)){
                                            $reserve_order_number = $fetch_order['reserve_number'];
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
                                </div> <br>

                                <div class="container" style="text-align: center; padding: 0px; padding-bottom:20px; padding-top:10px;">
                                    <form action="" method="post">
                                        <?php $startdate=strtotime("+3 days");
                                        $enddate=strtotime("+1 weeks", $startdate);
                                        //echo date("M d", $startdate) . "-";
                                        //$startdate = strtotime("+1 week", $startdate);
                                        //echo date("M d", $enddate);
                                        $delivery_date = date("M d", $startdate) . "-" . date("M d", $enddate); ?>
                                        <input type="hidden" name="date_delivery" value="<?php echo $delivery_date; ?>">
                                        <input type="hidden" name="reserve_input" value="<?php echo $fetch_reserve['reserve_number'] ?? '000001' ?>">
                                        <button type="submit"  name="confirm_order" class="btn btn-success" style="font-size: 15px;">Confirm Order</button>
                                        <button type="submit"  name="cancel_reserve" class="btn btn-danger" style="font-size: 15px;">Cancel Reserve</button>
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
                        $reserve_query = mysqli_query($conn, "SELECT DISTINCT reserve_number, user_id FROM `reserve_orders` ORDER BY reserve_number") or die('query failed');
                        $grand_total = 0;
                        if(mysqli_num_rows($reserve_query) > 0){
                            while($fetch_reserve = mysqli_fetch_assoc($reserve_query)){
                                $reserve_number = $fetch_reserve['reserve_number'];
                                $user_id = $fetch_reserve['user_id'];
                                //echo $order_number , PHP_EOL;
                                //echo 'User ID: ' .$user_id;
                                $reserve_order_query = mysqli_query($conn, "SELECT * FROM `reserve_orders` WHERE reserve_number = '$reserve_number'") or die("query failed");
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
                                        <h5 style="text-align: center;">Reserve <?php echo $reserve_number; ?></h5>
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
                            while($fetch_reserve_order = mysqli_fetch_assoc($reserve_order_query)){
                                $reserve_order_number = $fetch_reserve_order['reserve_number'];
                                $user_id = $fetch_reserve_order['user_id'];
                                $pot = $fetch_reserve_order['pot'];
                                $item_id = $fetch_reserve_order['item_id'];
                                //echo $reserve_order_number , PHP_EOL;
                                //echo 'User ID: ' .$user_id;
                                $check_row = mysqli_num_rows($reserve_order_query);
                                $item_size = $fetch_reserve_order['item_size'];
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
                                <td class="align-content-center"><?php echo $fetch_reserve_order['item_name'] . PHP_EOL . "<br>Size: " . ucfirst($item_size) . PHP_EOL . "<br>Pot: " . $fetch_reserve_order['pot'] ?? "No Pot"; ?></td>
                                    <td class="align-content-center"><?php echo $fetch_reserve_order['item_quantity'] ?></td>
                                    <td class="align-content-center">₱<?php echo number_format($price,2) ?? 0; ?></td>
                                </tr>


                            <?php
                             $sub_total = intval($price * $fetch_reserve_order['item_quantity']);
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
                                        $order_query = mysqli_query($conn, "SELECT * FROM `reserve_orders` WHERE reserve_number = '$reserve_number'") or die("query failed");
                                        while($fetch_order = mysqli_fetch_assoc($order_query)){
                                            $reserve_order_number = $fetch_order['reserve_number'];
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
                                        $order_query = mysqli_query($conn, "SELECT * FROM `reserve_orders` WHERE reserve_number = '$reserve_order_number'") or die("query failed");
                                        while($fetch_order = mysqli_fetch_assoc($order_query)){
                                            $reserve_order_number = $fetch_order['reserve_number'];
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
                                </div> <br>

                                <div class="container" style="text-align: center; padding: 0px; padding-bottom:20px; padding-top:10px;">
                                    <form action="" method="post">
                                        <?php $startdate=strtotime("+3 days");
                                        $enddate=strtotime("+1 weeks", $startdate);
                                        //echo date("M d", $startdate) . "-";
                                        //$startdate = strtotime("+1 week", $startdate);
                                        //echo date("M d", $enddate);
                                        $delivery_date = date("M d", $startdate) . "-" . date("M d", $enddate); ?>
                                        <input type="hidden" name="date_delivery" value="<?php echo $delivery_date; ?>">
                                        <input type="hidden" name="reserve_input" value="<?php echo $fetch_reserve['reserve_number'] ?? '000001' ?>">
                                        <button type="submit"  name="confirm_order" class="btn btn-success" style="font-size: 15px;">Confirm Order</button>
                                        <button type="submit"  name="cancel_reserve" class="btn btn-danger" style="font-size: 15px;">Cancel Reserve</button>
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
