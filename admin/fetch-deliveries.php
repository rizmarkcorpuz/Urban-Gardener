<?php

include('config.php');
if(isset($_POST['request'])){

    $request = $_POST['request'];


    
    $query = "SELECT user_id FROM `supplier` ORDER BY user_id";
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
            $item_size = strtolower($fetch_order['item_size']);
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
                    echo "</select>" .PHP_EOL;

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
                        if($request === 'First In'){
                            $checkout_query = mysqli_query($conn, "SELECT DISTINCT order_number, user_id, item_status FROM `checkout` WHERE item_status = 'Delivering' ORDER BY order_number") or die('query failed');
                        }elseif($request === 'First Out'){
                            $checkout_query = mysqli_query($conn, "SELECT DISTINCT order_number, user_id, item_status FROM `checkout` WHERE item_status = 'Delivering' ORDER BY order_number DESC") or die('query failed');
                        }else{
                            die("Sorry! no record found!");
                        }
                        
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
                                            echo "</select>" .PHP_EOL;

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





        <?php
        }
        ?>

            </div>
        </div>
    </div>



