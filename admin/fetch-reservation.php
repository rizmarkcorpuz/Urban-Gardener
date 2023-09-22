<?php

include('config.php');
if(isset($_POST['request'])){

    $request = $_POST['request'];
    
    $query = "SELECT DISTINCT reserve_number, user_id FROM `reserve_orders` ORDER BY reserve_number";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);

?>

<?php

    if($count){
        
    }else{
        echo "Sorry! no record found!";
    }
?>

        <div class="container py-1 my-1 col-auto">
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
            $item_size = strtolower($fetch_reserve_order['item_size']);
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

                        if($request === 'First In'){
                            $reserve_query = mysqli_query($conn, "SELECT DISTINCT reserve_number, user_id FROM `reserve_orders` ORDER BY reserve_number") or die('query failed');
                        }elseif($request === 'First Out'){
                            $reserve_query = mysqli_query($conn, "SELECT DISTINCT reserve_number, user_id FROM `reserve_orders` ORDER BY reserve_number DESC") or die('query failed');
                        }else{
                            die("Sorry! no record found!");
                        }
                        
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





        <?php
        }
        ?>

            </div>
        </div>
    </div>



