<?php

include('config.php');
if(isset($_POST['request'])){

    $request = $_POST['request'];


    
    $query = "SELECT user_id FROM `user` WHERE user_type = 1 ORDER BY user_id";
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
                $checkout_query = mysqli_query($conn, "SELECT user_id FROM `user` WHERE first_name LIKE '%$search%' AND user_type = 1 or last_name LIKE '%$search%' AND user_type = 1 or user_id LIKE '%$search%' AND user_type = 1 or username LIKE '%$search%' AND user_type = 1 ORDER BY user_id") or die('query failed');
                $grand_total = 0;
                if(mysqli_num_rows($checkout_query) > 0){
                while($fetch_checkout = mysqli_fetch_assoc($checkout_query)){
                $user_id = $fetch_checkout['user_id'];

                $user_query = mysqli_query($conn, "SELECT * FROM `user` WHERE user_id = '$user_id'AND user_type = '1'");
                while($fetch_user = mysqli_fetch_assoc($user_query)){
                $first_name = $fetch_user['first_name'];
                $last_name = $fetch_user['last_name'];
                $username = $fetch_user['username'];
                $email = $fetch_user['email'];
                $contact_number = $fetch_user['contact_number'];
                $billing_address = $fetch_user['billing_address'];
                ?>

                    <div class="col-auto order-pending">

                    <div class="order-number" style="padding: 10px 10px 1px 10px; background-color: green; color: white;">
                        <h5 style="text-align: center;"><b>Customer Username: <?php echo $username; ?></b></h5>
                    </div>    
                    <div class="order-body">
                        <h6 style="text-align: center;">Customer ID: #<?php echo $user_id; ?></h6><br>
                        <h6>Name: <?php echo $first_name . " ".$last_name; ?></h6><br>
                        <h6>Email: <?php echo $email; ?></h6> <br>
                        <h6>Address: <?php echo $billing_address; ?></h6> <br>
                        <h6>Contact Number: <?php echo $contact_number; ?></h6>
                    </div>




                    <?php
                    }


                    ?>


                    <div class="container w-75 " style="text-align: center; padding: 20px; margin-left:30px; position: absolute; bottom: 0px; ">
                        <form action="" method="post">
                            <input type="hidden" name="user_id" value="<?php echo $fetch_checkout['user_id'] ?? '1' ?>">
                            <button type="submit"  name="see_orders" class="btn btn-success" >See list of orders</button>

                        </form>
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
                if($request === 'Username'){
                    $checkout_query = mysqli_query($conn, "SELECT user_id FROM `user` WHERE user_type = 1 ORDER BY username") or die('query failed');
                }elseif($request === 'ID'){
                    $checkout_query = mysqli_query($conn, "SELECT user_id FROM `user` WHERE user_type = 1 ORDER BY user_id") or die('query failed');
                }elseif($request === 'First Name'){
                    $checkout_query = mysqli_query($conn, "SELECT user_id FROM `user` WHERE user_type = 1 ORDER BY first_name") or die('query failed');
                }elseif($request === 'Last Name'){
                    $checkout_query = mysqli_query($conn, "SELECT user_id FROM `user` WHERE user_type = 1 ORDER BY last_name") or die('query failed');
                }elseif($request === 'A-Z'){
                    $checkout_query = mysqli_query($conn, "SELECT user_id FROM `user` WHERE user_type = 1 ORDER BY first_name") or die('query failed');
                }elseif($request === 'Z-A'){
                    $checkout_query = mysqli_query($conn, "SELECT user_id FROM `user` WHERE user_type = 1 ORDER BY first_name DESC") or die('query failed');
                }else{
                    die("Sorry! no record found!");
                }
                $grand_total = 0;
                if(mysqli_num_rows($checkout_query) > 0){
                    while($fetch_checkout = mysqli_fetch_assoc($checkout_query)){
                        $user_id = $fetch_checkout['user_id'];

                        $user_query = mysqli_query($conn, "SELECT * FROM `user` WHERE user_id = '$user_id'");
                        while($fetch_user = mysqli_fetch_assoc($user_query)){
                            $first_name = $fetch_user['first_name'];
                            $last_name = $fetch_user['last_name'];
                            $username = $fetch_user['username'];
                            $email = $fetch_user['email'];
                            $contact_number = $fetch_user['contact_number'];
                            $billing_address = $fetch_user['billing_address'];
                            ?>

                                <div class="col-auto order-pending">

                                <div class="order-number" style="padding: 10px 10px 1px 10px; background-color: green; color: white;">
                                    <h5 style="text-align: center;"><b>Customer Username: <?php echo $username; ?></b></h5>
                                </div>    
                                <div class="order-body">
                                    <h6 style="text-align: center;">Customer ID: #<?php echo $user_id; ?></h6><br>
                                    <h6>Name: <?php echo $first_name . " ".$last_name; ?></h6><br>
                                    <h6>Email: <?php echo $email; ?></h6> <br>
                                    <h6>Address: <?php echo $billing_address; ?></h6> <br>
                                    <h6>Contact Number: <?php echo $contact_number; ?></h6>
                                </div>


                            <?php
                        }


                        ?>


                        <div class="container w-75 " style="text-align: center; padding: 20px; margin-left:30px; position: absolute; bottom: 0px; ">
                            <form action="" method="post">
                                <input type="hidden" name="user_id" value="<?php echo $fetch_checkout['user_id'] ?? '1' ?>">
                                <button type="submit"  name="see_orders" class="btn btn-success" >See list of orders</button>

                            </form>
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



