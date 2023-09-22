<!-- product -->
<?php

    $user_id = $_SESSION['username']->user_id ?? 0;
    //$item_id = isset($_GET['item_id']) ? $_GET['item_id'] : 1;
    $item_id = $_POST['item_id'] ?? $_SESSION['item_id'];
    $_SESSION['item_id'] = $item_id;
    //echo $item_id;
    $select_product = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id='$item_id'") or die('query failed');
    if(mysqli_num_rows($select_product) > 0){
        $fetch_product = mysqli_fetch_assoc($select_product);
        foreach ($product->getData() as $fetch_product){

    if($fetch_product['item_id'] == $item_id){
            //request method post
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                if($user_id == 0){
                    echo '<script type="text/javascript">';
                    echo 'alert("Need To Login First")';  //not showing an alert box.
                    echo '</script>';
                    echo "<script>window.top.location='./login'</script>";

                }else {

                    $verified_query = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'");
                    $row = mysqli_fetch_assoc($verified_query);

                    if($row['email_verified'] == NULL){
                        header("Location: verify");;
                    }else {
                        if (isset($_POST['product_submit'])) {
                            //call method addToCart
                            $user_id = $_SESSION['username']->user_id ?? 0;
                            $item_id = $_POST['item_id'];
                            $item_brand = $_POST['item_brand'];
                            $item_name = $_POST['item_name'];
                            $item_price = $_POST['item_price'];
                            $price_query = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id = '$item_id'") or die("query failed");
                            $row = mysqli_fetch_assoc($price_query);
                            $item_quantity = $_POST['input_quantits'];
                            $item_size = $_POST['size'];
                            $item_pot = $_POST['pot'];
                            $item_image = $_POST['item_image'];

                            //$item_quantity = $_SESSION['input_quantity'] ?? 1;
                            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE item_name = '$item_name' AND user_id = '$user_id' AND item_size = '$item_size' AND item_quantity = '$item_quantity'") or die('query failed');
                            $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE item_name = '$item_name' AND user_id = '$user_id'") or die('query failed');
                            $cart_row = mysqli_fetch_assoc($select_cart);


                            if (mysqli_num_rows($select_cart) > 0) {
                                echo '<script type="text/javascript">';
                                echo 'alert("Item already in the cart")';  //not showing an alert box.
                                echo '</script>';
                            } elseif (mysqli_num_rows($select_wishlist) > 0) {
                                echo '<script type="text/javascript">';
                                echo 'alert("Item already in the Wishlist")';  //not showing an alert box.
                                echo '</script>';
                            } elseif ($item_quantity < 1) {
                                echo '<script type="text/javascript">';
                                echo 'alert("Out of Stock")';  //not showing an alert box.
                                echo '</script>';
                            } else {
                                mysqli_query($conn, "INSERT INTO `cart`(user_id, item_id, item_brand, item_name, item_price, item_size, pot, item_image, item_quantity) VALUES('$user_id', '$item_id', '$item_brand', '$item_name', '$item_price', '$item_size' , '$item_pot' , '$item_image', '$item_quantity')") or die('query failed');
                                $message[] = 'product added to cart!';
                                echo '<script type="text/javascript">';
                                echo 'alert("Product added to cart")';  //not showing an alert box.
                                echo '</script>';
                                echo "<script>window.top.location=''</script>";

                            }
                        } elseif (isset($_POST['product_reserve'])) {
                            //call method addToReservation
                            $user_id = $_SESSION['username']->user_id ?? 0;
                            $item_id = $_POST['item_id'];
                            $item_brand = $_POST['item_brand'];
                            $item_name = $_POST['item_name'];
                            $item_price = $_POST['item_price'];
                            $price_query = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id = '$item_id'") or die("query failed");
                            $row = mysqli_fetch_assoc($price_query);
                            $item_quantity = $_POST['input_quantits'];
                            $item_size = $_POST['size'];
                            $item_pot = $_POST['pot'];
                            $item_image = $_POST['item_image'];

                            $select_cart = mysqli_query($conn, "SELECT * FROM `reservation` WHERE item_name = '$item_name' AND user_id = '$user_id' AND item_size = '$item_size'") or die('query failed');
                            $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE item_name = '$item_name' AND user_id = '$user_id'") or die('query failed');

                            if (mysqli_num_rows($select_cart) > 0) {
                                echo '<script type="text/javascript">';
                                echo 'alert("Item already in the reservation cart")';  //not showing an alert box.
                                echo '</script>';
                            } elseif (mysqli_num_rows($select_wishlist) > 0) {
                                echo '<script type="text/javascript">';
                                echo 'alert("Item already in the Wishlist")';  //not showing an alert box.
                                echo '</script>';
                            } else {
                                mysqli_query($conn, "INSERT INTO `reservation`(user_id, item_id, item_brand, item_name, item_price, item_size, pot, item_image, item_quantity) VALUES('$user_id', '$item_id', '$item_brand', '$item_name', '$item_price', '$item_size' , '$item_pot' , '$item_image', '$item_quantity')") or die('query failed');
                                $message[] = 'product added to cart!';
                                echo '<script type="text/javascript">';
                                echo 'alert("Product added to reservation cart")';  //not showing an alert box.
                                echo '</script>';
                                echo "<script>window.top.location=''</script>";

                            }
                        }
                    }


                    if(isset($_POST['top_sale_submit'])){
                        header("Refresh:0; url=");
                    }

                    if (isset($_POST['go-to-cart'])) {

                        $user_id = $_SESSION['username']->user_id ?? 0;
                        $item_id = $_POST['item_id'];
                        $item_brand = $_POST['item_brand'];
                        $item_name = $_POST['item_name'];
                        $item_price = $_POST['item_price'];
                        $price_query = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id = '$item_id'") or die("query failed");
                        $row = mysqli_fetch_assoc($price_query);
                        $item_quantity = $_POST['input_quantits'];
                        $item_size = $_POST['size'];
                        $item_pot = $_POST['pot'];
                        $item_image = $_POST['item_image'];
                        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE item_name = '$item_name' AND user_id = '$user_id' AND item_size = '$item_size'") or die('query failed');
                        $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE item_name = '$item_name' AND user_id = '$user_id'") or die('query failed');

                        if (mysqli_num_rows($select_cart) > 0) {
                            echo '<script type="text/javascript">';
                            echo 'alert("Item already in the cart")';  //not showing an alert box.
                            echo '</script>';
                        } elseif (mysqli_num_rows($select_wishlist) > 0) {
                            echo '<script type="text/javascript">';
                            echo 'alert("Item already in the Wishlist")';  //not showing an alert box.
                            echo '</script>';
                        } else {
                            mysqli_query($conn, "INSERT INTO `cart`(user_id, item_id, item_brand, item_name, item_price, item_size, pot, item_image, item_quantity) VALUES('$user_id', '$item_id', '$item_brand', '$item_name', '$item_price', '$item_size' , '$item_pot' , '$item_image', '$item_quantity')") or die('query failed');
                            $message[] = 'product added to cart!';

                        }
                        echo "<script>window.top.location='./cart'</script>";
                    }

                }
            }
        $item_quantity = $fetch_product['item_quantity'];
        $item_reservation = $fetch_product['item_reservation'];

        if(isset($_POST['update-quantity'])){
            if($_POST['input_quantity'] == ""){
                $_POST['input_quantity'] = 1;
            }
            $_SESSION['input_quantity'] = $_POST['input_quantity'] ?? 1;
            $product_quantity = $_POST['input_quantity'] ?? 1;
        }

        if(isset($_POST['update_size'])){
            $size = $_POST['size'];
            echo $size;
        }

?>
<section id="product" class="py-3">
    <div class="container" style="margin-top: 100px;">
        <div class="row">
            <div class="col-sm-6 py-5">
            <section id="product-picture">
                <div class="owl-carousel owl-theme"style="">
                    <div class="item">
                        <img src="<?php echo $fetch_product['item_image']; ?>" alt=" product" data-hash="zero" class="img-fluid">
                    </div>
                    <div class="item">
                        <img src="<?php echo $fetch_product['small_image']; ?>" alt=" product" data-hash="one" class="img-fluid">
                    </div>
                    <div class="item">
                        <img src="<?php echo $fetch_product['medium_image']; ?>" alt=" product" data-hash="two" class="img-fluid">
                    </div>
                    <div class="item">
                        <img src="<?php echo $fetch_product['large_image']; ?>" alt=" product" data-hash="three" class="img-fluid">
                    </div>
                </div>
                <div class="container" style="text-align:center; margin: 10px auto;">
                    <a class="button secondary url link" href="#zero"><img src="<?php echo $fetch_product['item_image']; ?>" alt=" product" width="100px" height="100px"></a>
                    <a class="button secondary url link" href="#one"><img src="<?php echo $fetch_product['small_image']; ?>" alt=" product" width="100px" height="100px"></a>
                    <a class="button secondary url link" href="#two"><img src="<?php echo $fetch_product['medium_image']; ?>" alt=" product" width="100px" height="100px"></a>
                    <a class="button secondary url link" href="#three"><img src="<?php echo $fetch_product['large_image']; ?>" alt=" product" width="100px" height="100px"></a>
                </div>
                
            </section>
                
                
            </div>
            <div class="col-sm-6 py-5">
                <h5 class="font-baloo font-size-20"><?php echo isset($fetch_product['item_name']) ? $fetch_product['item_name'] : "Unknown"; ?></h5>
                <small><?php echo isset($fetch_product['item_brand']) ? $fetch_product['item_brand'] : "Unknown"; ?></small>
                 <!-- product rating -->
                 <div class="d-flex">
                            <div class="rating text-warning font-size-12">

                                <?php
                                    $review_query = mysqli_query($conn, "SELECT * FROM `review_table`  WHERE item_id = '$item_id' AND parent_id = '0'") or die("query failed");
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
                                        //echo (round($average_rating,1) . PHP_EOL);
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
                            <a href="#review" class="px-2 font-rale font-size-14"><?php echo $total_review ?? 0; ?> ratings</a>
                        </div>
                        <!--  !product rating-->
                <hr class="m-0">

                <!-- product price -->
                <table class="my-3">

                    <tr class="font-rale font-size-14">
                        <td>Price:</td>
                        <td class="font-size-20 text-danger">₱<span id="item_price"><?php echo $fetch_product['small_price'] ?? 0; ?></span><small class="text-dark font-size-12">&nbsp;&nbsp;Inclusive of all taxes</small></td>
                    </tr>

                </table>
                <!-- !product price -->

                <!-- policy -->
                <div id="policy">
                    <div class="d-flex">

                        <div class="return text-center mr-5">
                            <div class="font-size-20 my-2 color-second">
                                <span class="fas fa-truck border p-3 rounded-pill"></span>
                            </div>
                            <a href="https://www.facebook.com/UrbanGardenerCC" target="_blank" rel="noopener" class="font-rale font-size-12">Urban Gardener <br> Delivery</a>
                        </div>

                        <div class="return text-center mr-5">
                            <div class="font-size-20 my-2 color-second">
                                <span class="fas fa-truck border p-3 rounded-pill"></span>
                            </div>
                            <a href="https://www.lalamove.com/en-ph/" target="_blank" rel="noopener" class="font-rale font-size-12">Lalamove <br> Delivery</a>
                        </div>

                    </div>
                </div>
                <!-- !policy-->

                <hr>
                <?php 

                    $select_user = mysqli_query($conn, "SELECT * FROM `user` WHERE user_id = '$user_id' ");
                    $fetch_user = mysqli_fetch_assoc($select_user);
                ?>

                <!-- order details-->
                <div id="order-details" class="font-rale d-flex flex-column text-dark">
                    <small>Delivery Date: 3-7 Working Days</small>
                    <small>Sold by <a href="https://www.facebook.com/UrbanGardenerCC" target="_blank" rel="noopener">Urban Gardener </a></small>
                    <small><i class="fas fa-map-marker-alt color-primary"></i>&nbsp;&nbsp;Delivery to Customer - <?= $fetch_user['billing_address']; ?></small>
                </div>
                <!-- !order details-->

                <div class="row">
                    <div class="col-6">
                        <!-- color -->
                        <div class="color my-3">
                            <div class="d-flex justify-content-between">
                                <input type="hidden" id="small_quantitys" value="<?php echo $fetch_product['small_quantity'] ?? 0; ?>">
                                <input type="hidden" id="medium_quantitys" value="<?php echo $fetch_product['medium_quantity'] ?? 0; ?>">
                                <input type="hidden" id="large_quantitys" value="<?php echo $fetch_product['large_quantity'] ?? 0; ?>">
                                <h6 class="font-baloo">Stocks: <small id="stock_quantitys"><?php echo $fetch_product['small_quantity'] ?? 0; ?></small></h6>
                            </div>
                        </div>
                        <!-- !color -->
                    </div>

                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="d-flex font-rale w-100">
                            <div class="color my-3">
                                <h6 class="font-baloo">Quantity:</h6>
                            </div>
                            <form action="" method="post" enctype="multipart/form-data" class="size">
                                <input type="hidden" name="item_id" value="<?php echo $fetch_cart['item_id'] ?? '0'; ?>">
                                <input type="number" onblur="getVals()" id="input_quantit" name="input_quantit"  class="qty_input border px-2 w-75 h-10 bg-light text-center p-2 m-2" pattern="^[0-9]{6}|[0-9]{8}|[0-9]{11}$" min="1" max="<?php echo $fetch_product['small_quantity'] ?? 1; ?>" value="<?php echo $product_quantity ?? 1; ?>" placeholder="1">

                            </form>
                        </div>
                    </div>
                </div>

                <div class="container" style="display: flex;">
                    <!-- size -->
                    <div class="size my-3" style="position:relative;">
                        <h6 class="font-baloo">Size:</h6>
                        <div class="d-flex justify-content-between">
                            <div class="font-rubik">
                                <input type="radio" name="size" id="small" value="<?php echo $fetch_product['small_price'] ?? 0; ?>" checked="checked"
                                    <?php
                                    if($fetch_product['small_quantity'] == 0){
                                        echo "disabled";
                                    }
                                    ?>>
                                <label for="small" value="Small">Small<span></span></label>
                                <input type="radio" name="size" id="medium" value="<?php echo $fetch_product['medium_price'] ?? 0; ?>"
                                    <?php
                                    if($fetch_product['medium_quantity'] == 0){
                                        echo "disabled";
                                    }
                                    ?>>
                                <label for="medium" value="Medium">Medium<span></span></label>
                                <input type="radio" name="size" id="large" value="<?php echo $fetch_product['large_price'] ?? 0; ?>"
                                    <?php
                                    if($fetch_product['large_quantity'] == 0){
                                        echo "disabled";
                                    }
                                    ?>>
                                <label for="large" value="Large">Large<span></span></label>

                            </div>
                        </div>

                    </div>
                    <!-- !size -->
                   <?php 
                        if($fetch_product['item_brand'] == "Plants"){
                    ?>        
                            <!-- Pots -->
                            <div class="size my-3" style="float: right; margin-left:10px;">
                                <h6 class="font-baloo">Pots:</h6>
                                <div class="d-flex justify-content-between">
                                    <div class="font-rubik">
                                        <!---When Picked--->
                                        <input type="radio" onclick="getWithoutPot()" name="pot" id="withoutPot" value="withoutPot" checked="checked">
                                        <label for="withoutPot" onclick="getWithoutPot()">Without Pot<span></span></label>
                                        <input type="radio" onclick="getWithPot()" name="pot" id="withPot" value="withPot">
                                        <label for="withPot" onclick="getWithPot()">With Pot<span></span></label>
                                    </div>
                                </div>
                            </div>
                            <!-- !Pots -->
                    <?php        
                        }
                    ?>
                        
                </div>
                <div class="containerss" style="display: flex;">                    
                </div>
                <div class="form-row pt-4 font-size-16 font-baloo">
                    <div class="col">
                        <form method="post">
                            <input type="hidden" name="item_id" value="<?php echo $fetch_product['item_id'] ?? 0; ?>">
                            <input type="hidden" name="item_brand" value="<?php echo $fetch_product['item_brand'] ?? "Unknown" ?>">
                            <input type="hidden" name="item_name" value="<?php echo $fetch_product['item_name'] ?? "Unknown" ?>">
                            <input type="hidden" name="item_price" id="sizing-product" value="<?php echo $size ?? $fetch_product['small_price']; ?>">
                            <input type="hidden" name="item_image" value="<?php echo $fetch_product['item_image'] ??  "Unknown" ?>">
                            <input type="hidden" name="input_quantits" id="input_quanti" value="1" min="1" max="<?php echo isset($fetch_product['item_quantity']) ? $fetch_product['item_quantity'] : "0"; ?>" placeholder="1">
                            <input type="hidden" name="size" id="item_sizes" value="small">
                            <input type="hidden" name="pot" id="input_pot" value="<?php echo $fetch_product['pot'] ?? "No Pot" ?>">
                            <input type="hidden" name="user_id" value="<?php echo 0; ?>">
                            <?php
                            $total = $fetch_product['small_quantity'] + $fetch_product['medium_quantity'] + $fetch_product['large_quantity'];
                                if($total > 0) {
                                    echo '<button type="submit" name="go-to-cart" class="btn btn-danger form-control">Proceed to Buy</button>';
                                }else{
                                    echo '<button type="submit" disabled name="go-to-cart" class="btn btn-danger form-control">Proceed to Buy</button>';
                                }
                            ?>

                        </form>

                    </div>
                    <div class="col">
                        <form method="post">
                            <input type="hidden" name="item_id" value="<?php echo $fetch_product['item_id'] ?? 0; ?>">
                            <input type="hidden" name="item_brand" value="<?php echo $fetch_product['item_brand'] ?? "Unknown" ?>">
                            <input type="hidden" name="item_name" value="<?php echo $fetch_product['item_name'] ?? "Unknown" ?>">
                            <input type="hidden" name="item_price" id="sizing-cart" value="<?php echo $size ?? $fetch_product['small_price']; ?>">
                            <input type="hidden" name="item_image" value="<?php echo $fetch_product['item_image'] ??  "Unknown" ?>">
                            <input type="hidden" name="input_quantits" id="input_quantits" value="1" pattern="^[0-9]{6}|[0-9]{8}|[0-9]{11}$" min="1" max="<?php echo isset($fetch_product['item_quantity']) ? $fetch_product['item_quantity'] : "0"; ?>" placeholder="1">
                            <input type="hidden" name="size" id="product_size" value="small">
                            <input type="hidden" name="pot" id="input_pots" value="<?php echo $fetch_product['pot'] ?? "No Pot" ?>">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            <?php
                            $total = $fetch_product['small_quantity'] + $fetch_product['medium_quantity'] + $fetch_product['large_quantity'];
                            if($total > 0) {
                                echo '<button type="submit"  name="product_submit" class="btn btn-warning form-control" style="margin-bottom:10px;">Add to Cart</button>';
                                if($item_reservation == 'Reservation'){
                                    echo PHP_EOL;
                                    echo '<button type="submit"  name="product_reserve" class="btn btn-success form-control">Reserve</button>';
                                }
                            }elseif($total < 1){
                                echo '<button type="submit" disabled name="product_submit" class="btn btn-danger form-control">Out of Stock</button>';
                                if($item_reservation == 'Reservation'){
                                    echo PHP_EOL;
                                    echo '<button type="submit"  name="product_reserve" class="btn btn-success form-control">Reserve</button>';
                                }
                            }

                            ?>
                        </form>
                    </div>
                </div>
                
                
                

                <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

                <script>

                    let $stock_smalls = document.getElementById('small_quantitys').value;
                    let $stock_mediums = document.getElementById('medium_quantitys').value;
                    let $stock_larges = document.getElementById('large_quantitys').value;


                    document.getElementById('small').onclick = function() {
                        if (this.checked == true) {
                            // the element is checked
                            var input = document.getElementById("input_quantit");
                            input.setAttribute("max",$stock_smalls); // set a new value;
                            $('#stock_quantitys').html($stock_smalls);
                            console.log($stock_smalls);
                        }
                    };

                    document.getElementById('medium').onclick = function() {
                        if (this.checked == true) {
                            // the element is checked
                            var input = document.getElementById("input_quantit");
                            input.setAttribute("max",$stock_mediums); // set a new value;
                            $('#stock_quantitys').html($stock_mediums);
                            console.log($stock_mediums);
                        }
                    };

                    document.getElementById('large').onclick = function() {
                        if (this.checked == true) {
                            // the element is checked
                            var input = document.getElementById("input_quantit");
                            input.setAttribute("max",$stock_larges); // set a new value;
                            $('#stock_quantitys').html($stock_larges);
                            console.log($stock_larges);
                        }
                    };

                    function getVals() {
                        const vals = document.querySelector('input').value;
                        console.log(vals);
                        //$('#input_quantity').val(data);
                    }

                    
                    function getWithPot(){

                        //alert("working");
                        document.getElementById("withPot").onclick = function(){
                            var value = $(this).val();
                            //alert(value);
                            var size = $("input[name='size']:checked").val();
                            //alert('Change Happened');
                            //console.log(size);
                            let $input = document.getElementById('input_quantit').value;
                            let $save_prices = size;
                            let changing_prices = ($save_prices * $input).toFixed(2);
                            //$('#item_price').html(changing_prices);

                            $.ajax({
                                url: "fetch-picker.php",
                                type: "POST",
                                data: 'request=' + value,
                                beforeSend:function(){
                                    $(".containerss").html("<span>Working...</span>");
                                },
                                success:function(data){
                                    $(".containerss").html(data);
                                }
                            })

                            if(this.checked == true){
                                var sizepot = $("input[name='size']:checked").val();
                                let $save_prices_pot = sizepot;
                                //alert('Change Happened');
                                sizeid = $("input[name='size']:checked").attr('id');
                                //console.log(sizeid);

                                if(sizeid === "small"){

                                    let $potvalue = 20.00;
                                    //console.log($potvalue);
                                    //alert($potvalue);
                                    var withPot = document.getElementById("withPot");
                                    var withoutPot = document.getElementById("withoutPot");
                                    withPot.checked = true;
                                    withoutPot.checked = false;
                                    let total = (Number($save_prices_pot) + Number($potvalue)).toFixed(2); 
                                    //console.log(total);
                                    //$('#item_price').html(total); 
                                    $('#item_sizes').val(sizeid); 
                                    $('#product_size').val(sizeid);  

                                    $.ajax({
                                        url:"size.php",
                                        method: "POST",
                                        data:{size:size, potvalue:$potvalue, input:$input},
                                        dataType:"JSON",
                                        success:function (data){
                                            
                                            //$('#item_sizes').val(data);
                                            //$('#product_size').val(data);
                                            $('#sizing-product').val(data);
                                            $('#sizing-cart').val(data);
                                            $('#item_price').html(data);
                                        }
                                    });

                                }else if(sizeid === "medium"){

                                    let $potvalue = 45.00;
                                    //console.log($potvalue);
                                    //alert($potvalue);
                                    var withPot = document.getElementById("withPot");
                                    var withoutPot = document.getElementById("withoutPot");
                                    withPot.checked = true;
                                    withoutPot.checked = false;
                                    let total = (Number($save_prices_pot) + Number($potvalue)).toFixed(2); 
                                    //console.log(total);
                                    //$('#item_price').html(total);
                                    $('#item_sizes').val(sizeid);
                                    $('#product_size').val(sizeid);
                                    $.ajax({
                                        url:"size.php",
                                        method: "POST",
                                        data:{size:size, potvalue:$potvalue, input:$input},
                                        dataType:"JSON",
                                        success:function (data){
                                            
                                            //$('#item_sizes').val(data);
                                            //$('#product_size').val(data);
                                            $('#sizing-product').val(data);
                                            $('#sizing-cart').val(data);
                                            $('#item_price').html(data);
                                        }
                                    });
                                
                                }else if(sizeid === "large"){
                                    
                                    let $potvalue = <?php echo $fetch_pot['large_price'] ?? 60.00 ;?>;
                                    console.log($potvalue);
                                    //console.log($potvalue);
                                    //alert($potvalue);
                                    var withPot = document.getElementById("withPot");
                                    var withoutPot = document.getElementById("withoutPot");
                                    withPot.checked = true;
                                    withoutPot.checked = false;
                                    let total = (Number($save_prices_pot) + Number($potvalue)).toFixed(2); 
                                    //console.log(total);
                                    //$('#item_price').html(total);
                                    $('#item_sizes').val(sizeid);
                                    $('#product_size').val(sizeid);
                                    $.ajax({
                                        url:"size.php",
                                        method: "POST",
                                        data:{size:size, potvalue:$potvalue, input:$input},
                                        dataType:"JSON",
                                        success:function (data){
                                            
                                            //$('#item_sizes').val(data);
                                            //$('#product_size').val(data);
                                            $('#sizing-product').val(data);
                                            $('#sizing-cart').val(data);
                                            $('#item_price').html(data);
                                        }
                                    });
                                }
                                
                            }
                        }

                    }

                    function getWithoutPot(){

                        //alert("working");
                        document.getElementById("withoutPot").onclick = function(){
                            
                            //$('#sizing-product').val(data);
                            //$('#sizing-cart').val(data);
                            var size = $("input[name='size']:checked").val();
                            //alert('Change Happened');
                            //console.log(size);
                            let $input = document.getElementById('input_quantit').value;
                            let $save_prices = size;
                            let changing_prices = ($save_prices * $input).toFixed(2);
                            //$('#item_price').html(changing_prices);

                            var value = $(this).val();
                            //alert(value);

                            $.ajax({
                                url: "fetch-picker.php",
                                type: "POST",
                                data: 'request=' + value,
                                beforeSend:function(){
                                    $(".containerss").html("<span>Working...</span>");
                                },
                                success:function(data){
                                    $(".containerss").html(data);
                                }
                            })

                            if(this.checked == true){
                                potid = "No Pot";
                                $("#input_pot").val(potid);
                                $("#input_pots").val(potid);
                                var sizepot = $("input[name='size']:checked").val();
                                let $save_prices_pot = sizepot;
                                //alert('Change Happened');

                                var potvalue =  $("#withoutPot").val();
                                //alert(potvalue);
                                var withPot = document.getElementById("withPot");
                                var withoutPot = document.getElementById("withoutPot");
                                withPot.checked = false;
                                withoutPot.checked = true;
                                console.log($save_prices_pot);
                                sizeid = $("input[name='size']:checked").attr('id');

                                if(sizeid === "small"){

                                    let $potvalue = 0.00;
                                    //console.log($potvalue);
                                    //alert($potvalue);
                                    var size = $("input[name='size']:checked").val();
                                    let $input = document.getElementById('input_quantit').value;
                                    let $save_prices = size;
                                    let changing_prices = ($save_prices * $input).toFixed(2);
                                    //$('#item_price').html(changing_prices);

                                    var withPot = document.getElementById("withPot");
                                    var withoutPot = document.getElementById("withoutPot");
                                    withPot.checked = false;
                                    withoutPot.checked = true;
                                    let total = (Number($save_prices) + Number($potvalue)).toFixed(2); 
                                    //console.log(total);
                                    //$('#item_price').html(total);
                                    $('#item_sizes').val(sizeid);
                                    $('#product_size').val(sizeid);
                                    $.ajax({
                                        url:"size.php",
                                        method: "POST",
                                        data:{size:size, potvalue:$potvalue, input:$input},
                                        dataType:"JSON",
                                        success:function (data){

                                            //$('#item_sizes').val(data);
                                            //$('#product_size').val(data);
                                            $('#sizing-product').val(data);
                                            $('#sizing-cart').val(data);
                                            $('#item_price').html(data);
                                        }
                                    });
                                                                    

                                }else if(sizeid === "medium"){

                                    let $potvalue = 0.00;
                                    //console.log($potvalue);
                                    //alert($potvalue);
                                    var size = $("input[name='size']:checked").val();
                                    let $input = document.getElementById('input_quantit').value;
                                    let $save_prices = size;
                                    let changing_prices = ($save_prices * $input).toFixed(2);
                                    //$('#item_price').html(changing_prices);

                                    var withPot = document.getElementById("withPot");
                                    var withoutPot = document.getElementById("withoutPot");
                                    withPot.checked = false;
                                    withoutPot.checked = true;
                                    let total = (Number($save_prices) + Number($potvalue)).toFixed(2); 
                                    //console.log(total);
                                    //$('#item_price').html(total);
                                    $('#item_sizes').val(sizeid);
                                    $('#product_size').val(sizeid);
                                    $.ajax({
                                        url:"size.php",
                                        method: "POST",
                                        data:{size:size, potvalue:$potvalue, input:$input},
                                        dataType:"JSON",
                                        success:function (data){

                                            //$('#item_sizes').val(data);
                                            //$('#product_size').val(data);
                                            $('#sizing-product').val(data);
                                            $('#sizing-cart').val(data);
                                            $('#item_price').html(data);
                                        }
                                    });

                                }else if(sizeid === "large"){

                                    let $potvalue = 0.00;
                                    //console.log($potvalue);
                                    //alert($potvalue);
                                    var size = $("input[name='size']:checked").val();
                                    let $input = document.getElementById('input_quantit').value;
                                    let $save_prices = size;
                                    let changing_prices = ($save_prices * $input).toFixed(2);
                                    //$('#item_price').html(changing_prices);

                                    var withPot = document.getElementById("withPot");
                                    var withoutPot = document.getElementById("withoutPot");
                                    withPot.checked = false;
                                    withoutPot.checked = true;
                                    let total = (Number($save_prices) + Number($potvalue)).toFixed(2); 
                                    //console.log(total);
                                    //$('#item_price').html(total);
                                    potid = $("input[name='potpick']:checked").attr('value');
                                    $('#item_sizes').val(sizeid);
                                    $('#product_size').val(sizeid);
                                    $.ajax({
                                        url:"size.php",
                                        method: "POST",
                                        data:{size:size, potvalue:$potvalue, input:$input},
                                        dataType:"JSON",
                                        success:function (data){

                                            //$('#item_sizes').val(data);
                                            //$('#product_size').val(data);
                                            $('#sizing-product').val(data);
                                            $('#sizing-cart').val(data);
                                            $('#item_price').html(data);
                                        }
                                    });
                                }
                                
                            }
                        }
                        
                    }

                    $(document).on('change', '.pot', function (){
                        var pots = $("input[name='pot']:checked").val();
                        alert(pots);

                    
                        
                    });


                    $(document).on('change', '.size', function (){
                        var size = $("input[name='size']:checked").val();
                        //alert('Change Happened');
                        //console.log(size);
                        let $save_prices = size;
                        document.getElementById('input_quantits').value = document.getElementById('input_quantit').value;
                        document.getElementById('input_quanti').value = document.getElementById('input_quantit').value;
                        //document.getElementById('size_price').value = document.getElementById('input_quantity').value * document.getElementById('size_price').value;
                        let $input = document.getElementById('input_quantit').value;
                        //console.log($input);
                        $('#item_price').html($save_prices);
                        //var price = document.getElementById('size_price').innerHTML;
                        let changing_prices = ($save_prices * $input).toFixed(2);
                        $('#item_price').html(changing_prices);
                        //console.log($save_prices);
                        //console.log(price);
                        //console.log(changing_prices);

                        if($("input[name='pot']:checked").val() == "withPot"){
                            sizeid = $("input[name='size']:checked").attr('id');
                            //console.log(sizeid);

                            if(sizeid === "small"){

                                let $potvalue = 20.00;
                                //console.log($potvalue);
                                //alert($potvalue);
                                var size = $("input[name='size']:checked").val();
                                let $input = document.getElementById('input_quantit').value;
                                let $save_prices = size;
                                //let changing_prices = ($save_prices * $input).toFixed(2);


                                var withPot = document.getElementById("withPot");
                                var withoutPot = document.getElementById("withoutPot");
                                withPot.checked = true;
                                withoutPot.checked = false;
                                let total = (Number($save_prices) + Number($potvalue)).toFixed(2); 
                                //console.log(total);
                                //$('#item_price').html(total);
                                potid = $("input[name='potpick']:checked").attr('value');
                                $("#input_pot").val(potid);
                                $("#input_pots").val(potid);
                                $('#item_sizes').val(sizeid);
                                $('#product_size').val(sizeid);
                                //console.log(potid);
                                $.ajax({
                                    url:"size.php",
                                    method: "POST",
                                    data:{size:size, potvalue:$potvalue, input:$input},
                                    dataType:"JSON",
                                    success:function (data){

                                       
                                        $('#sizing-product').val(data);
                                        $('#sizing-cart').val(data);
                                        $('#item_price').html(data);

                                    }
                                });
                                                                
                                
                            }else if(sizeid === "medium"){

                                let $potvalue = 45.00;
                                //console.log($potvalue);
                                //alert($potvalue);
                                var size = $("input[name='size']:checked").val();
                                let $input = document.getElementById('input_quantit').value;
                                let $save_prices = size;
                                let changing_prices = ($save_prices * $input).toFixed(2);
                                //$('#item_price').html(changing_prices);

                                var withPot = document.getElementById("withPot");
                                var withoutPot = document.getElementById("withoutPot");
                                withPot.checked = true;
                                withoutPot.checked = false;
                                let total = (Number($save_prices) + Number($potvalue)).toFixed(2); 
                                //console.log(total);
                                //$('#item_price').html(total);
                                potid = $("input[name='potpick']:checked").attr('value');
                                $("#input_pot").val(potid);
                                $("#input_pots").val(potid);
                                $('#item_sizes').val(sizeid);
                                $('#product_size').val(sizeid);
                                console.log(potid);
                                $.ajax({
                                    url:"size.php",
                                    method: "POST",
                                    data:{size:size, potvalue:$potvalue, input:$input},
                                    dataType:"JSON",
                                    success:function (data){

                                        //$('#item_sizes').val(data);
                                        //$('#product_size').val(data);
                                        $('#sizing-product').val(data);
                                        $('#sizing-cart').val(data);
                                        $('#item_price').html(data);
                                    }
                                });
                            
                            }else if(sizeid === "large"){

                                let $potvalue = 60.00;
                                //console.log($potvalue);
                                //alert($potvalue);
                                var size = $("input[name='size']:checked").val();
                                let $input = document.getElementById('input_quantit').value;
                                let $save_prices = size;
                                let changing_prices = ($save_prices * $input).toFixed(2);
                                //$('#item_price').html(changing_prices);
                                
                                var withPot = document.getElementById("withPot");
                                var withoutPot = document.getElementById("withoutPot");
                                withPot.checked = true;
                                withoutPot.checked = false;
                                let total = (Number($save_prices) + Number($potvalue)).toFixed(2); 
                                //console.log(total);
                                //$('#item_price').html(total);
                                potid = $("input[name='potpick']:checked").attr('value');
                                $("#input_pot").val(potid);
                                $("#input_pots").val(potid);
                                $('#item_sizes').val(sizeid);
                                $('#product_size').val(sizeid);
                                console.log(potid);
                                $.ajax({
                                    url:"size.php",
                                    method: "POST",
                                    data:{size:size, potvalue:$potvalue, input:$input},
                                    dataType:"JSON",
                                    success:function (data){

                                        //$('#item_sizes').val(data);
                                        //$('#product_size').val(data);
                                        $('#sizing-product').val(data);
                                        $('#sizing-cart').val(data);
                                        $('#item_price').html(data);
                                    }
                                });
                            }
                        }else if($("input[name='pot']:checked").val() == "withoutPot"){
                            sizeid = $("input[name='size']:checked").attr('id');

                            if(sizeid === "small"){

                                let $potvalue = 0.00;
                                //console.log($potvalue);
                                //alert($potvalue);
                                var size = $("input[name='size']:checked").val();
                                let $input = document.getElementById('input_quantit').value;
                                let $save_prices = size;
                                let changing_prices = ($save_prices * $input).toFixed(2);
                                //$('#item_price').html(changing_prices);

                                var withPot = document.getElementById("withPot");
                                var withoutPot = document.getElementById("withoutPot");
                                withPot.checked = false;
                                withoutPot.checked = true;
                                let total = (Number($save_prices) + Number($potvalue)).toFixed(2); 
                                //console.log(total);
                                //$('#item_price').html(total);
                                $('#item_sizes').val(sizeid);
                                $('#product_size').val(sizeid);

                                $.ajax({
                                    url:"size.php",
                                    method: "POST",
                                    data:{size:size, potvalue:$potvalue, input:$input},
                                    dataType:"JSON",
                                    success:function (data){
                                        
                                        //$('#item_sizes').val(data);
                                        //$('#product_size').val(data);
                                        $('#sizing-product').val(data);
                                        $('#sizing-cart').val(data);
                                        $('#item_price').html(data);
                                    }
                                });
                                                                

                            }else if(sizeid === "medium"){

                                let $potvalue = 0.00;
                                //console.log($potvalue);
                                //alert($potvalue);
                                var size = $("input[name='size']:checked").val();
                                let $input = document.getElementById('input_quantit').value;
                                let $save_prices = size;
                                let changing_prices = ($save_prices * $input).toFixed(2);
                                //$('#item_price').html(changing_prices);

                                var withPot = document.getElementById("withPot");
                                var withoutPot = document.getElementById("withoutPot");
                                withPot.checked = false;
                                withoutPot.checked = true;
                                let total = (Number($save_prices) + Number($potvalue)).toFixed(2); 
                                //console.log(total);
                                //$('#item_price').html(total);
                                $('#item_sizes').val(sizeid);
                                $('#product_size').val(sizeid);
                                $.ajax({
                                    url:"size.php",
                                    method: "POST",
                                    data:{size:size, potvalue:$potvalue, input:$input},
                                    dataType:"JSON",
                                    success:function (data){

                                        //$('#item_sizes').val(data);
                                        //$('#product_size').val(data);
                                        $('#sizing-product').val(data);
                                        $('#sizing-cart').val(data);
                                        $('#item_price').html(data);
                                    }
                                });

                            }else if(sizeid === "large"){

                                let $potvalue = 0.00;
                                //console.log($potvalue);
                                //alert($potvalue);
                                var size = $("input[name='size']:checked").val();
                                let $input = document.getElementById('input_quantit').value;
                                let $save_prices = size;
                                let changing_prices = ($save_prices * $input).toFixed(2);
                                //$('#item_price').html(changing_prices);

                                var withPot = document.getElementById("withPot");
                                var withoutPot = document.getElementById("withoutPot");
                                withPot.checked = false;
                                withoutPot.checked = true;
                                let total = (Number($save_prices) + Number($potvalue)).toFixed(2); 
                                //console.log(total);
                                //$('#item_price').html(total);
                                potid = $("input[name='potpick']:checked").attr('value');
                                $('#item_sizes').val(sizeid);
                                $('#product_size').val(sizeid);
                                $.ajax({
                                    url:"size.php",
                                    method: "POST",
                                    data:{size:size, potvalue:$potvalue, input:$input},
                                    dataType:"JSON",
                                    success:function (data){

                                        //$('#item_sizes').val(data);
                                        //$('#product_size').val(data);
                                        $('#sizing-product').val(data);
                                        $('#sizing-cart').val(data);
                                        $('#item_price').html(data);
                                    }
                                });
                            }

                        }else{
                            sizeid = $("input[name='size']:checked").attr('id');

                            if(sizeid === "small"){

                                let $potvalue = 0.00;
                                //console.log($potvalue);
                                //alert($potvalue);
                                var size = $("input[name='size']:checked").val();
                                let $input = document.getElementById('input_quantit').value;
                                let $save_prices = size;
                                let changing_prices = ($save_prices * $input).toFixed(2);
                                //$('#item_price').html(changing_prices);

                                let total = (Number($save_prices) + Number($potvalue)).toFixed(2); 
                                //console.log(total);
                                //$('#item_price').html(total);
                                $('#item_sizes').val(sizeid);
                                $('#product_size').val(sizeid);

                                $.ajax({
                                    url:"size.php",
                                    method: "POST",
                                    data:{size:size, potvalue:$potvalue, input:$input},
                                    dataType:"JSON",
                                    success:function (data){
                                        
                                        //$('#item_sizes').val(data);
                                        //$('#product_size').val(data);
                                        $('#sizing-product').val(data);
                                        $('#sizing-cart').val(data);
                                        $('#item_price').html(data);
                                    }
                                });
                                                                

                            }else if(sizeid === "medium"){

                                let $potvalue = 0.00;
                                //console.log($potvalue);
                                //alert($potvalue);
                                var size = $("input[name='size']:checked").val();
                                let $input = document.getElementById('input_quantit').value;
                                let $save_prices = size;
                                let changing_prices = ($save_prices * $input).toFixed(2);
                                //$('#item_price').html(changing_prices);

                                let total = (Number($save_prices) + Number($potvalue)).toFixed(2); 
                                //console.log(total);
                                //$('#item_price').html(total);
                                $('#item_sizes').val(sizeid);
                                $('#product_size').val(sizeid);
                                $.ajax({
                                    url:"size.php",
                                    method: "POST",
                                    data:{size:size, potvalue:$potvalue, input:$input},
                                    dataType:"JSON",
                                    success:function (data){

                                        //$('#item_sizes').val(data);
                                        //$('#product_size').val(data);
                                        $('#sizing-product').val(data);
                                        $('#sizing-cart').val(data);
                                        $('#item_price').html(data);
                                    }
                                });

                            }else if(sizeid === "large"){

                                let $potvalue = 0.00;
                                //console.log($potvalue);
                                //alert($potvalue);
                                var size = $("input[name='size']:checked").val();
                                let $input = document.getElementById('input_quantit').value;
                                let $save_prices = size;
                                let changing_prices = ($save_prices * $input).toFixed(2);
                                //$('#item_price').html(changing_prices);

                                let total = (Number($save_prices) + Number($potvalue)).toFixed(2); 
                                //console.log(total);
                                //$('#item_price').html(total);
                                potid = $("input[name='potpick']:checked").attr('value');
                                $('#item_sizes').val(sizeid);
                                $('#product_size').val(sizeid);
                                $.ajax({
                                    url:"size.php",
                                    method: "POST",
                                    data:{size:size, potvalue:$potvalue, input:$input},
                                    dataType:"JSON",
                                    success:function (data){

                                        //$('#item_sizes').val(data);
                                        //$('#product_size').val(data);
                                        $('#sizing-product').val(data);
                                        $('#sizing-cart').val(data);
                                        $('#item_price').html(data);
                                    }
                                });
                            }
                        }
                    });

                </script>

            </div>


        </div>
    </div>

    </div>
    </div>
    </div>
</section>
<!-- product -->
<?php
    }
        };
    };//closing foreach function
    ?>


