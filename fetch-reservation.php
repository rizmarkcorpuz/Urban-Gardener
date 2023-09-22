<?php

require "function.php";
//session_destroy();
    check_login();
    include 'config.php';
if(isset($_POST['request'])){

    $request = $_POST['request'];


    
    $query = "SELECT DISTINCT order_number, user_id FROM `checkout` ORDER BY order_number";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);

?>

<?php

    if($count){
        
    }else{
        echo "Sorry! no record found!";
    }
?>



        <div class="container py-1 my-1">
            <div class="row py-3 mt-3">

            <?php
            
                $user_id =  $_SESSION['username']->user_id;
                if($request === 'First In'){
                    $select_checkouts = mysqli_query($conn, "SELECT DISTINCT reserve_number, user_id FROM `reserve_orders` WHERE user_id='$user_id' ORDER BY reserve_number");
                }elseif($request === 'First Out'){
                    $select_checkouts = mysqli_query($conn, "SELECT DISTINCT reserve_number, user_id FROM `reserve_orders` WHERE user_id='$user_id' ORDER BY reserve_number DESC");
                }else{
                    die("Sorry! no record found!");
                }
                
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
                                            <small><?php echo $fetch_order['item_brand'] ?? "Brand"; ?></small><br>
                                            <small><?php echo $fetch_order['item_size'] ?? "Small"; ?></small>


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
                                    Total(<?php echo $count_item ?? 1; ?> <?php if($count_item > 1){
                                        echo 'items):';
                                    }else{
                                        echo 'item):';
                                    }?> ₱<span class="product_price" data-id="<?php echo $fetch_cart['item_id'] ?? 0; ?>"><?php echo number_format($grand_total,2); ?></span>
                                </div>
                            </div>

                        </div>

                        <?php
                    };
                }else{
                    echo "<div class='empty'>No products in your reservation</div>";
                };
                ?>

        <?php
        }
        ?>

            </div>
        </div>
    </div>



