<?php
ob_start();
//include header.php file
include('header.php');

?>

<?php

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username']->username;
    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_POST['user_id'] = $row['user_id'];
        $user_id = $_POST['user_id'];
        //echo $_POST['user_id'];
    } else {
        echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
    }
}

if(isset($_POST['user_id'])){
    $sub_total = 0;
    $grand_total = 0;

    $count_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM reservation WHERE user_id='$user_id'");
    $row_count = mysqli_fetch_assoc($count_query);
    $count = $row_count["total"];
}

if(isset($_POST['review_link'])){
    $item_id = $_POST['review_item_id'];
    $_SESSION['item_id'] = $item_id;
    
    echo "<script>window.location.href='./product#review'</script>";
}

// save for later
if (isset($_POST['wishlist-submit'])){
    $user_id = $_SESSION['user_id'];
    $item_id = $_POST['item_id'];
    $item_brand = $_POST['item_brand'];
    $cart_id =$_POST['cart_id'];
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];
    $item_image = $_POST['item_image'];
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE item_name = '$item_name' AND user_id = '$user_id'") or die('query failed');
    $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE item_name = '$item_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($select_wishlist) > 0){

        echo '<script type="text/javascript">';
        echo 'alert("Item already in the Wishlist")';  //not showing an alert box.
        echo '</script>';

    }elseif(mysqli_num_rows($select_cart) > 0 ){
        mysqli_query($conn, "INSERT INTO `wishlist`(user_id, item_id, item_brand, item_name, item_price, item_image) VALUES('$user_id', '$item_id', '$item_brand', '$item_name', '$item_price', '$item_image')") or die('query failed');
        mysqli_query($conn, "DELETE FROM `cart` WHERE cart_id = '$cart_id'");

        $message[] = 'product added to cart!';
        header("Location: " .$_SERVER['PHP_SELF']);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    //delete cart item
    if (isset($_POST['delete-cart-submit'])){
        //$deletedrecord = $Cart->deleteCart($_POST['cart_id'] , $_POST['user_id']);
    }

}

//delete wishlist item
if (isset($_POST['delete-wishlist-submit'])){
    $cart_id = $_POST['cart_id'];
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE cart_id = '$cart_id'");

}

//checkout page
if(isset($_POST['reserve-payment'])){
    $user_id = $_SESSION['username']->user_id;

    $mode_of_payment = $_POST['mode_of_payment'];

    $name_query = mysqli_query($conn, "SELECT * FROM `user` WHERE user_id = $user_id") or die("query failed");
    $fetch_name = mysqli_fetch_assoc($name_query);
    $customer_name = $fetch_name['first_name'] . " " . $fetch_name['last_name'];

    $query ="SELECT reserve_number FROM `reserve_orders` ORDER BY reserve_number desc" or die("query failed");
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $last_order = $row['reserve_number'];
    if(empty($last_order)){
        $reserve_number = "Order: 000001";
    }else{
        $idd = str_replace("Order: ", "",$last_order);
        $id = str_pad($idd + 1,6,0,STR_PAD_LEFT);
        $reserve_number = 'Order: ' .$id;
    }


    $selectall_cart = mysqli_query($conn, "INSERT INTO `reserve_orders` (reserve_number, user_id, customer_name, item_id, item_brand, item_name, item_price, item_size, pot, item_image, item_quantity, mode_of_payment) SELECT '$reserve_number', user_id, '$customer_name', item_id, item_brand, item_name, item_price, item_size, pot, item_image, item_quantity, '$mode_of_payment' FROM `reservation` WHERE user_id = '$user_id'") or die("query failed");
    $notification_query = mysqli_query($conn, "INSERT INTO `notifications` (text, date, url, status) VALUES ('You have a reservation order to confirm', Now(), 'reservation.php', '0')") or die("query failed");
    $quantity_query = mysqli_query($conn, "SELECT * FROM reservation WHERE user_id='$user_id'") or die("query failed");
    while($fetch_quantity = mysqli_fetch_assoc($quantity_query)){
        $item_id = $fetch_quantity['item_id'];
        $item_quantity = $fetch_quantity['item_quantity'];
        $product_query = mysqli_query($conn, "SELECT * FROM product WHERE item_id='$item_id'");
        while ($get_quantity = mysqli_fetch_assoc($product_query)){
            $product_id = $get_quantity['item_id'];
            $product_quantity = $get_quantity['item_quantity'];
            //$product_quantity = $product_quantity - $item_quantity;
            //$update_query = mysqli_query($conn, "UPDATE `product` SET item_quantity='$product_quantity' WHERE item_id='$product_id'");
            //$order_cart = mysqli_query($conn, "UPDATE `checkout` SET order_number='$order_number' WHERE item_id='$product_id'") or die("query failed");
        }
    }

    $delete_query = mysqli_query($conn, "DELETE FROM `reservation` WHERE user_id='$user_id'");

    echo '<script type="text/javascript">';
    echo 'alert("Reserve Successfully")';  //not showing an alert box.
    echo '</script>';
    echo "<script>window.top.location='./reservation'</script>";
}

$grand_total = 0;

?>

<section id="cart" class="py-3 mb-5">

    <div class="container-fluid w-75" style="margin-top: 100px">
        <h5 class="font-baloo font-size-20">Reservation</h5>

        <div class="row">
            <div class="col-sm-8">
                <?php
                if(isset($_POST['user_id'])){
                    $reservation_query = mysqli_query($conn, "SELECT * FROM `reservation` WHERE user_id = '$user_id'") or die('query failed');
                    $user_query = mysqli_query($conn, "SELECT * FROM `user` WHERE user_id = '$user_id'") or die('query failed');
                    $grand_total = 0;
                    if(mysqli_num_rows($reservation_query) > 0){
                        while($fetch_reservation = mysqli_fetch_assoc($reservation_query)){
                            $item_id = $fetch_reservation['item_id'];
                            ?>
                            <!-- cart item -->
                            <div class="row border-top py-3 mt-3">
                                <div class="col-sm-2">
                                    <img src="<?php echo $fetch_reservation['item_image'] ?? "./assets/products/product-1.jpg" ?>" style="height: 120px;" alt="cart1" class="img-fluid">
                                </div>
                                <div class="col-sm-8">
                                    <h5 class="font-baloo font-size-20"><?php echo $fetch_reservation['item_name'] ?? "Unknown"; ?></h5>
                                    <small><?php echo $fetch_reservation['item_brand'] ?? "Brand"; ?></small><br>
                                    <small>Size: <?php echo ucfirst($fetch_reservation['item_size']) ?? "Small"; ?></small><br>
                                    <small>Quantity: <?php echo $fetch_reservation['item_quantity'] ?? "Brand"; ?></small><br>
                                    <?php 
                                        if($fetch_product['item_brand'] == "Plants"){
                                    ?> 
                                    <small>Pot: <?php echo $fetch_reservation['pot']?></small>
                                    <?php        
                                        }
                                    ?>
                                    <!-- product rating -->
                                    <div class="d-flex">
                                        <div class="rating text-warning font-size-12">
                                            <?php
                                            $review_query = mysqli_query($conn, "SELECT * FROM `review_table`  WHERE item_id = '$item_id'") or die("query failed");
                                            $total_rating = 0;
                                            $average_rating = 0;
                                            $total_review = 0;
                                            $rounded_rating = 0;
                                            $i = 0;
                                            while($fetch_review = mysqli_fetch_assoc($review_query)){
                                                $user_rating = $fetch_review['user_rating'];

                                                $total_rating = $total_rating + $user_rating;
                                                $total_review++;
                                                $average_rating = $total_rating/$total_review;
                                                $rounded_rating = (round($average_rating,1));
                                            }
                                            echo (round($average_rating,1) . PHP_EOL);
                                            if($average_rating >= 0 && $average_rating <= 0.49){
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                            }elseif($average_rating <= 0.99 && $average_rating >= 0.5){
                                                echo '<i class="fas fa-star-half-alt mr-1"></i>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                            }elseif($average_rating >= 1 && $average_rating <= 1.49){
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                            }elseif($average_rating <= 1.99 && $average_rating >= 1.5){
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star-half-alt mr-1"></i>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                            }elseif($average_rating >= 2 && $average_rating <= 2.49){
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                            }elseif($average_rating <= 2.99 && $average_rating >= 2.5){
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<span><i class="fas fa-star-half-alt mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                            }elseif($average_rating >= 3 && $average_rating <= 3.49){
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                            }elseif($average_rating <= 3.99 && $average_rating >= 3.5 ){
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star-half-alt mr-1"></i>';
                                                echo '<i class="far fa-star mr-1"></i>';
                                            }elseif($average_rating >= 4 && $average_rating <= 4.49){
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                            }elseif($average_rating <= 4.99 && $average_rating >= 4.5){
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star-half-alt mr-1 main_star"></i>';
                                            }elseif($average_rating == 5){
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                                echo '<i class="fas fa-star text-warning mr-1 main_star"></i>';
                                            }else{
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                                echo '<span><i class="far fa-star mr-1"></i></span>';
                                            }

                                            ?>
                                        </div>
                                        <form action="" method="post" target="_blank">
                                                <input type="hidden" name="review_item_id" value="<?= $item_id; ?>">
                                                <button type="submit" name="review_link" class="hyperlink-style-button px-2 font-rale font-size-14"><?= $total_review ?? 0;?> reviews</button>
                                            </h6>
                                        </form>
                                    </div>
                                    <!--  !product rating-->

                                    <!-- product qty -->
                                    <div class="qty d-flex pt-2">
                                        <div class="d-flex font-rale w-25">

                                        </div>

                                    </div>
                                    <!-- !product qty -->

                                </div>

                                <div class="col-sm-1 text-right">
                                    <div class="font-size-20 text-danger font-baloo">
                                        <?php $sub_total = ($fetch_reservation['item_price'] * $fetch_reservation['item_quantity']);?>
                                        ₱<span class="product_price" data-id="<?php echo $fetch_reservation['item_id'] ?? 0; ?>"><?php if($sub_total == 0){
                                                echo 0;
                                            }else{
                                                $select_reservation = mysqli_query($conn, "SELECT * FROM `reservation` WHERE user_id ='$user_id' AND item_id = '$item_id'");
                                                
                                                    while($fetch_reservationprice = mysqli_fetch_assoc($select_reservation)){
                                                        $size = $fetch_reservationprice['item_size'];
                                                        $pot = $fetch_reservationprice['pot'];
                                                    }
                                                    $select_product = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id = '$item_id'");

                                                    while($fetch_product = mysqli_fetch_assoc($select_product)){
                                                        if($pot != "No Pot"){
                                                            if($size === "small" || $size === "Small"){
                                                                $item_price = $fetch_product['small_price'];
                                                                $price = ($item_price + 20.00) * $fetch_reservation['item_quantity'];
                                                            }
                                                            elseif($size === "medium" || $size === "Medium"){
                                                                $item_price = $fetch_product['medium_price'];
                                                                $price = ($item_price + 45.00) * $fetch_reservation['item_quantity'];
                                                            }
                                                            elseif($size === "large" || $size === "Large"){
                                                                $item_price = $fetch_product['large_price'];
                                                                $price = ($item_price + 60.00) * $fetch_reservation['item_quantity'];
                                                            }
                                                        }else{
                                                            if($size === "small" || $size === "Small"){
                                                                $item_price = $fetch_product['small_price'];
                                                                $price = $item_price  * $fetch_reservation['item_quantity'];
                                                            }
                                                            elseif($size === "medium" || $size === "Medium"){
                                                                $item_price = $fetch_product['medium_price'];
                                                                $price = $item_price  * $fetch_reservation['item_quantity'];
                                                            }
                                                            elseif($size === "large" || $size === "Large"){
                                                                $item_price = $fetch_product['large_price'];
                                                                $price = $item_price * $fetch_reservation['item_quantity'];
                                                            }
                                                        }
                                                    }
                                                    echo number_format($price,2) ?? 0;
                                                                                    
                                                //echo number_format($total_price, 2) ?? 0;
                                            } ?></span>
                                    </div>
                                </div>
                            </div>
                            <!-- !cart item -->
                            <?php
                            $grand_total += $price;
                        }

                    }else {
                        echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
                    }}
                ?>
            </div>

            <!-- Billing Address Section-->
            <?php
            if(isset($_POST['user_id'])){
                $user_query = mysqli_query($conn, "SELECT * FROM `user` WHERE user_id = '$user_id'") or die('query failed');
                if(mysqli_num_rows($user_query) > 0){
                    while($fetch_user = mysqli_fetch_assoc($user_query)){

            ?>
                    <div class="col-sm-4">
                        <div class="border" style="padding: 20px;width: 350px;">
                        <h6 class="font-size-16 font-rale py-3" style="margin-top: -20px;"><b>Billing Details</b></h6>
                            <div class="sub-total text-center mt-2">
                                <form action="" method="post">
                                <h6 class="font-size-12 font-rale text-success py-3" style="text-align: left; margin-top: -20px; margin-left: 20px;"><i class="fas fa-user"></i> User Information</h6>
                                <p style="text-align: left; margin-left: 30px; margin-top: -20px;">Name: <?php echo $fetch_user['first_name'] ?? "Unknown" ?> <?php echo $fetch_user['last_name'] ?? "Unknown" ?></p>
                                <p style="text-align: left; margin-left: 30px; margin-top: -20px;">Mobile Number: <?php echo $fetch_user['contact_number'] ?? "Unknown" ?></p>
                                <p style="text-align: left; margin-left: 30px; margin-top: -20px;">Email: <?php echo $fetch_user['email'] ?? "Unknown" ?></p>
                                <div class="sub-total border-top mt-2">
                                    <h6 class="font-size-12 font-rale text-success py-3" style="text-align: left; margin-left: 20px;"><i class="fas fa-address-book"></i> Delivery Address</h6>
                                    <p style="text-align: left; margin-left: 20px; margin-top: -20px;"><i class="fas fa-map-marker-alt" style="color:red;"></i>   <?php echo $fetch_user['billing_address'] ?? "Unknown" ?></p>
                            </div>
                            <div class="sub-total border-top mt-2">
                                <h6 class="font-size-12 font-rale text-success py-3" style="text-align: left; margin-left: 20px;"><i class="fas fa-truck"></i> Date of Delivery</h6>
                                <p style="margin-top: -20px;">Get By <?php 
                                
                                $select_date = mysqli_query($conn, "SELECT * FROM `delivery_date` WHERE id = 1");
                                $fetch_date = mysqli_fetch_assoc($select_date);
                                $start_delivery = $fetch_date['delivery_start'];
                                $end_delivery = $fetch_date['delivery_end'];
                                        $startdate=strtotime($start_delivery);
                                        $enddate=strtotime($end_delivery, $startdate);
                                    echo date("M d", $startdate) . "-";
                                        //$startdate = strtotime("+1 week", $startdate);
                                    echo date("M d", $enddate);
                                    $delivery_month = date("M", $startdate);
                                    $delivery_day = date("d", $startdate);
                                    ?></p>
                                <h6 class="font-size-12 font-rale text-warning py-1" style="margin-top: -20px;">(Delivery usually takes 2-3 days)</h6>
                                <input type="hidden" name="date_delivery" value="<?php echo $delivery_date; ?>">
                            </div>
                            <!-- subtotal section-->
                            <div class="sub-total border-top mt-2">
                            <h6 class="font-size-12 font-rale text-success py-3" style="text-align: left; margin-left: 20px;"><i class="fas fa-money-bill"></i> Delivery Fee</h6>
                                    <h6 class="font-size-12 font-rale text-danger py-3" style="margin-top: -20px;">
                                        
                                        <?php
                                            if($fetch_user['zipcode'] === "4100" || $fetch_user['zipcode'] === "4101"){
                                                echo "Standard Delivery. ₱50.00";
                                            }else{
                                                echo "Outside of Cavite City Delivery. ₱100.00";
                                            }
                                            
                                        ?>
                                        <br><br><a href="https://www.lalamove.com/en-ph/" style="margin-top: -20px; text-decoration:none; color:orange;" target="_blank" rel="noopener" class="font-rale font-size-12">Lalamove Delivery</a>
                                    </h6>
                                </div>
                            </div>
                            <?php 
                                if($fetch_user['zipcode'] === "4100" || $fetch_user['zipcode'] === "4101"){
                                    $delivery_fee = 50;
                                }else{
                                    $delivery_fee = 100;
                                }
                            ?>
                                    <div class="border-top py-4 text-center">
                                        <h6 class="font-size-16 font-rale py-3" style="margin-top: -20px; text-align:right;">Subtotal: ₱<?= number_format($grand_total, 2); ?></h6>
                                        <h6 class="font-size-16 font-rale py-3" style="margin-top: -20px; text-align:right;">Delivery Fee: ₱<?= number_format($delivery_fee, 2); ?></h6>
                                        <!---<h5 class="font-baloo font-size-20">Subtotal ( <?php echo isset($subTotal) ? count($subTotal) : 0; ?> item):&nbsp; <span class="text-danger">₱<span class="text-danger" id="deal-price"><?php //echo isset($subTotal) ? $Cart->getSum($subTotal) : 0; ?></span> </span> </h5>--->
                                        <h5 class="font-baloo font-size-20" style="text-align:right;">Total Amount (<?php echo $count ?? 0; ?> <?php if($count > 1){
                                                echo 'items):';
                                            }else{
                                                echo 'item):';
                                            }?>&nbsp; <span class="text-danger">₱<span class="text-danger" id="deal-price"><?php
                                                    if($grand_total == 0){
                                                        echo 0;
                                                    }else{
                                                        if($fetch_user['zipcode'] === "4100" || $fetch_user['zipcode'] === "4101"){
                                                            $delivery_fee = 50;
                                                        }else{
                                                            $delivery_fee = 100;
                                                        }
                                                        $grand_total = $grand_total + $delivery_fee;
                                                        echo number_format($grand_total, 2) ?? 0;
                                                    } ?></span> </span> </h5>

                                            <button type="button" name="payment" class="btn btn-warning mt-3" data-toggle="modal" data-target="#checkoutModal">Proceed to Buy</button>
                                    </div>
                            </form>

                            <!-- Checkout Modal-->
                            <div class="modal fade text-center" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Ready to Reserve?</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">Select "Confirm" below if you are ready check out.</div>
                                        <div class="modal-footer">
                                            <form action="" method="post" class="modal-body">
                                                <div class="sub-total text-left" style="height: 150px;">
                                                    <div class="container">
                                                        <h6 class="font-size-12 font-rale text-success py-3"></i> Mode of Payment.</h6>
                                                        <input type="radio" onclick="hideGcash()" placeholder="Mode of Payment" value="Cash On Delivery" name="mode_of_payment" id="CashOnDelivery" value="<?php echo $mode_of_payment; ?>"required checked>
                                                        <label for="CashOnDelivery" onclick="hideGcash()">Cash On Delivery</label><br>
                                                        <input type="radio" onclick="showGcash()" placeholder="Mode of Payment" value="GCash" name="mode_of_payment" id="GCash" value="<?php echo $mode_of_payment; ?>"required >
                                                        <label for="GCash" onclick="showGcash()">GCash</label>
                                                        <div class="container" id="gcashPayment" style="position:relative; opacity: 0;transition: opacity 0.6s linear; width: 250px; height:100px; float:right; margin-top:-100px;">
                                                            
                                                            <img src="./qrcodes/gcash_qrcode.png"  alt="QR Code"  width="150px" height="150px" style="margin-left:40px;">
                                                            <h6 class="font-size-12 font-rale text-success" style="float:right; margin-top: 0px; margin-right:74px;">Scan to Pay</h6>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                </div>
                                                <input type="hidden" name="date_delivery" value="<?php echo $delivery_month; ?>">
                                                <input type="hidden" name="date_delivery_day" value="<?php echo $delivery_day; ?>">
                                                <button class="btn btn-secondary mt-3" type="button" data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-primary mt-3" type="submit" name="reserve-payment">Confirm</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>





                            <!-- !subtotal section-->
                        </div>
                    </div>

                        <?php
                    }
                }
            }
            ?>
            <!-- !Billing Address Section-->


        </div>
    </div>
</section>

<?php
//include footer.php file
include('footer.php');
?>

