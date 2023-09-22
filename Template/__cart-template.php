<!-- Shopping cart section  -->
<script>
    function refreshPage(){
        if(window.location.hash == "#top-sale"){
            var index = "#top-sale"
            window.location.href = window.location.href.split('?')[0] + index;
        }

        if(window.location.hash == "#special_price"){
            var index = "#special_price"
            window.location.href = window.location.href.split('?')[0] + index;
        }

        if(window.location.hash == "#new-plants"){
            var index = "#new-plants"
            window.location.href = window.location.href.split('?')[0] + index;
        }
    }
</script>
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
}else{
    header("Location: login");
}

    if(isset($_POST['user_id'])){

        $verified_query = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'");
        $row = mysqli_fetch_assoc($verified_query);

        if($row['email_verified'] == NULL){
            header("Location: verify");;
        }else{
            $sub_total = 0;
            $grand_total = 0;

            $count_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM cart WHERE user_id='$user_id'");
            $row_count = mysqli_fetch_assoc($count_query);
            $count = $row_count["total"];
        }

    }

    if(isset($_POST['review_link'])){
        $item_id = $_POST['review_item_id'];
        $_SESSION['item_id'] = $item_id;
        
        echo "<script>window.location.href='./product#review'</script>";
    }

    // save for later
    if (isset($_POST['wishlist-submit'])){
        $user_id = $_SESSION['username']->user_id;
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

//request method post
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['user_id'])){
        if($_POST['user_id'] == 0){
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

                if (isset($_POST['top_sale_submit'])) {
                    //call method addToCart
                    $user_id = $_POST['user_id'];
                    $item_id = $_POST['item_id'];
                    $item_brand = $_POST['item_brand'];
                    $item_name = $_POST['item_name'];
                    $item_price = $_POST['item_price'];
                    $price_query = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id = '$item_id'") or die("query failed");
                    $row = mysqli_fetch_assoc($price_query);
                    $item_quantity = $_POST['input_quantity'];
                    $item_size = $_POST['size'];
                        if($item_size === 'smallpopup'){

                            $item_size = "small";

                        }elseif($item_size === 'mediumpopup'){

                            $item_size = "medium";

                        }elseif($item_size === 'largepopup'){

                            $item_size = "large";

                        }
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
                        mysqli_query($conn, "INSERT INTO `cart`(user_id, item_id, item_brand, item_name, item_price, item_size, pot, item_image, item_quantity) VALUES('$user_id', '$item_id', '$item_brand', '$item_name', '$item_price', '$item_size' , '$item_pot', '$item_image', '$item_quantity')") or die('query failed');
                        $message[] = 'product added to cart!';
                        echo '<script type="text/javascript">';
                        echo 'refreshPage()';  //not showing an alert box.
                        echo '</script>';

                    }
                } elseif (isset($_POST['top_sale_reserve'])) {
                    //call method addToReservation
                    $user_id = $_POST['user_id'];
                    $item_id = $_POST['item_id'];
                    $item_brand = $_POST['item_brand'];
                    $item_name = $_POST['item_name'];
                    $item_price = $_POST['item_price'];
                    $price_query = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id = '$item_id'") or die("query failed");
                    $row = mysqli_fetch_assoc($price_query);
                    $item_quantity = $_POST['input_quantity'];
                    $item_size = $_POST['size'];
                        if($item_size === 'smallpopup'){

                            $item_size = "small";

                        }elseif($item_size === 'mediumpopup'){

                            $item_size = "medium";

                        }elseif($item_size === 'largepopup'){

                            $item_size = "large";

                        }
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
                        mysqli_query($conn, "INSERT INTO `reservation`(user_id, item_id, item_brand, item_name, item_price, item_size, pot, item_image, item_quantity) VALUES('$user_id', '$item_id', '$item_brand', '$item_name', '$item_price', '$item_size' , '$item_pot', '$item_image', '$item_quantity')") or die('query failed');
                        $message[] = 'product added to cart!';
                        echo '<script type="text/javascript">';
                        echo 'refreshPage()';  //not showing an alert box.
                        echo '</script>';

                    }
                }
            }
        }
    }
}

    //delete cart item
    if (isset($_POST['delete-cart-submit'])){
        $deletedrecord = $Cart->deleteCart($_POST['cart_id']);
    }

    //delete wishlist item
    if (isset($_POST['delete-wishlist-submit'])){
        $cart_id = $_POST['cart_id'];
        mysqli_query($conn, "DELETE FROM `wishlist` WHERE cart_id = '$cart_id'");

    }

    //checkout page
    if(isset($_POST['checkout'])){
        //$user_id = $_SESSION['user_id'];
       // $item_id = $_POST['item_id'];
       // $item_brand = $_POST['item_brand'];
       // $cart_id =$_POST['cart_id'];
       // $item_name = $_POST['item_name'];
       // $item_price = $_POST['item_price'];
       // $item_image = $_POST['item_image'];
       // $item_quantity = $_POST['item_quantity'];

      //  $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');


            header("Location: checkout");

    }

    $grand_total = 0;

    if(isset($_POST['update-quantity'])){
        $item_id = $_POST['item_id'];
        $item_size = $_POST['item_size'];
        $item_quantity = $_POST['input_quantity'];
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');

        if(mysqli_num_rows($select_cart) > 0 ) {
            //mysqli_query($conn, "INSERT INTO `checkout`(user_id, item_id, item_brand, item_name, item_price, item_image, item_quantity)
            //                           SELECT user_id, item_id, item_brand, item_name, item_price, item_image
            //                          FROM `cart` WHERE  user_id = '$user_id'") or die('query failed');
            //mysqli_query($conn, "DELETE FROM `cart` WHERE cart_id = '$cart_id'");
            $quantity_query = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id ='$item_id'") or die("query failed");
            $fetch_quantity = mysqli_fetch_assoc($quantity_query);
            if($item_size == 'small' || $item_size == 'Small'){
                $product_quantity = $fetch_quantity['small_quantity'];
            }elseif($item_size == 'medium' || $item_size == 'Medium'){
                $product_quantity = $fetch_quantity['medium_quantity'];
            }elseif($item_size == 'large' || $item_size == 'Large'){
                $product_quantity = $fetch_quantity['large_quantity'];
            }

            $sum = $product_quantity - $item_quantity;
            if($sum < 0){
                $message[] = 'Item quantity cannot exceed Product Stock';
                mysqli_query($conn, "UPDATE `cart` SET item_quantity = '$product_quantity' WHERE user_id = '$user_id' AND item_id = '$item_id' AND item_size = '$item_size'") or die('query failed');
            }elseif($item_quantity <=0){
                mysqli_query($conn, "UPDATE `cart` SET item_quantity = '1' WHERE user_id = '$user_id' AND item_id = '$item_id' AND item_size = '$item_size'") or die('query failed');
            }else{
                mysqli_query($conn, "UPDATE `cart` SET item_quantity = '$item_quantity' WHERE user_id = '$user_id' AND item_id = '$item_id' AND item_size = '$item_size'") or die('query failed');
            }


            $message[] = 'product added to checkout!';


        }
    }

?>

<section id="cart" class="py-3 mb-5">
    <div class="container-fluid w-75" style="margin-top: 100px;">
        <h5 class="font-baloo font-size-20">Shopping Cart</h5>

        <!--  shopping cart items   -->
        <div class="row">
            <div class="col-sm-8">
                <?php
                if(isset($_POST['user_id'])){
                    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                    $grand_total = 0;
                    if(mysqli_num_rows($cart_query) > 0){
                    while($fetch_cart = mysqli_fetch_assoc($cart_query)){
                        $item_id = $fetch_cart['item_id'];
                        $product_query = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id ='$item_id'") or die("query failed");
                        $fetch_product = mysqli_fetch_assoc($product_query);
                        $small_quantity = $fetch_product['small_quantity'];
                        //echo $fetch_product['small_quantity'];
                        $item_size = $fetch_cart['item_size'];

                ?>
                <!-- cart item -->
                <div class="row border-top py-3 mt-3">
                    <div class="col-sm-2">
                        <img src="<?php echo $fetch_cart['item_image'] ?? "./assets/products/product-1.jpg" ?>" style="height: 120px;" alt="cart1" class="img-fluid">
                    </div>
                    <div class="col-sm-8">
                        <h5 class="font-baloo font-size-20"><?php echo $fetch_cart['item_name'] ?? "Unknown"; ?></h5>
                        <small><?php echo $fetch_cart['item_brand'] ?? "Brand"; ?></small><br>
                        <small>Size: <?php echo ucfirst($fetch_cart['item_size']) ?? "Small"; ?></small><br>
                        <?php 
                            if($fetch_product['item_brand'] == "Plants"){
                        ?> 
                        <small>Pot: <?php echo $fetch_cart['pot']?></small>
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
                            <div class="d-flex font-rale w-25 quantity-change">

                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="item_id" value="<?php echo $fetch_cart['item_id'] ?? '0'; ?>">
                                    <input type="hidden" name="item_size" value="<?php echo $fetch_cart['item_size'] ?? '0'; ?>">
                                    <input type="number" id="input_quantity" name="input_quantity"  class="qty_input border px-2 w-50 h-10 bg-light text-center p-2 m-2" min="1" value="<?php echo $fetch_cart['item_quantity'] ?? 1 ?>" placeholder="1">
                                    <button type="submit" name="update-quantity" class="btn btn-success font-size-12">Update</button>
                                </form>


                            </div>

                            <form method="post">
                                <input type="hidden" value="<?php echo $fetch_cart['cart_id'] ?? 0; ?>" name="cart_id">
                                <button type="submit" name="delete-cart-submit" class="btn font-baloo text-danger px-3 border-right">Delete</button>
                            </form>
                            <!-- !
                            <form method="post">
                                <input type="hidden" value="<?php echo $fetch_cart['cart_id'] ?? 0; ?>" name="cart_id">
                                <input type="hidden" name="item_id" value="<?php echo $fetch_cart['item_id'] ?? '0'; ?>">
                                <input type="hidden" name="item_brand" value="<?php echo $fetch_cart['item_brand'] ?? "Unknown" ?>">
                                <input type="hidden" name="item_name" value="<?php echo $fetch_cart['item_name'] ?? "Unknown" ?>">
                                <input type="hidden" name="item_price" value="<?php echo $fetch_cart['item_price'] ?? "Unknown" ?>">
                                <input type="hidden" name="item_image" value="<?php echo $fetch_cart['item_image'] ??  "Unknown" ?>">
                                <input type="hidden" name="user_id" value="<?php echo 1; ?>">
                                <button type="submit" name="wishlist-submit" class="btn font-baloo text-danger">Save for Later</button>
                            </form>
                            -->

                        </div>
                        <!-- !product qty -->

                    </div>

                    <div class="col-sm-1 text-right">
                        <div class="font-size-20 text-danger font-baloo">
                            <input type="hidden" id="saving_price" name="saving_price" value="<?php echo $fetch_cart['item_price'] ?? 0; ?>">
                            <?php $sub_total = ($fetch_cart['item_price'] * $fetch_cart['item_quantity']);?>
                            ₱<span class="product_price" id="quantity-price" data-id="<?php echo $fetch_cart['item_id'] ?? 0; ?>"><?php if($sub_total == 0){
                                    echo 0;
                                }else{
                                    $cart_id = $fetch_cart['cart_id'];
                                    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id ='$user_id' AND item_id = '$item_id' AND cart_id = '$cart_id'");
                                    
                                        while($fetch_cartprice = mysqli_fetch_assoc($select_cart)){
                                            $size = $fetch_cartprice['item_size'];
                                            $pot = $fetch_cartprice['pot'];
                                        }
                                        if($pot != "No Pot"){
                                            if($size === "small"){
                                                $item_price = $fetch_product['small_price'];
                                                $price = ($item_price + 20.00) * $fetch_cart['item_quantity'];
                                            }
                                            elseif($size === "medium"){
                                                $item_price = $fetch_product['medium_price'];
                                                $price = ($item_price + 45.00) * $fetch_cart['item_quantity'];
                                            }
                                            elseif($size === "large"){
                                                $item_price = $fetch_product['large_price'];
                                                $price = ($item_price + 60.00) * $fetch_cart['item_quantity'];
                                            }
                                        }else{
                                            if($size === "small" || $size === "Small"){
                                                $item_price = $fetch_product['small_price'];
                                                $price = $item_price  * $fetch_cart['item_quantity'];
                                            }
                                            elseif($size === "medium" || $size === "Medium"){
                                                $item_price = $fetch_product['medium_price'];
                                                $price = $item_price  * $fetch_cart['item_quantity'];
                                            }
                                            elseif($size === "large" || $size === "Large"){
                                                $item_price = $fetch_product['large_price'];
                                                $price = $item_price * $fetch_cart['item_quantity'];
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
                    echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">No item added</td></tr>';
                }}
                ?>
            </div>
            <!-- subtotal section-->
            <div class="col-sm-4">
                <div class="sub-total border text-center mt-2">
                    
                        
                        <?php
                        $user_query = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'");
                        $fetch_user = mysqli_fetch_assoc($user_query);
                        if($fetch_user['zipcode'] === "4100" || $fetch_user['zipcode'] === "4101"){
                            echo '<h6 class="font-size-12 font-rale text-success py-3">';
                            echo '<i class="fas fa-check"></i> ';
                            echo "Your order is eligible for Standard Delivery. ₱50.00";
                        }else{
                            echo '<h6 class="font-size-12 font-rale text-warning py-3">';
                            echo '<i class="fa">&#xf071</i> ';
                            echo "Outside of Cavite City Delivery. ₱100.00";
                        }
                        
                        ?>
                    </h6>
                    <div class="border-top py-4">
                        <!---<h5 class="font-baloo font-size-20">Subtotal ( <?php echo isset($subTotal) ? count($subTotal) : 0; ?> item):&nbsp; <span class="text-danger">₱<span class="text-danger" id="deal-price"><?php //echo isset($subTotal) ? $Cart->getSum($subTotal) : 0; ?></span> </span> </h5>--->
                        <h5 class="font-baloo font-size-20">Subtotal (<?php echo $count ?? 0; ?> item):&nbsp; <span class="text-danger">₱<span class="text-danger" id="deal-price">
                                    <?php
                                    if($grand_total == 0){
                                        echo 0;
                                    }else{
                                    echo number_format($grand_total, 2) ?? 0;
                                    }?></span> </span> </h5>
                        <form action="" method="post">
                            <input type="hidden" value="<?php echo $fetch_cart['cart_id'] ?? 0; ?>" name="cart_id">
                            <input type="hidden" name="item_id" value="<?php echo $fetch_cart['item_id'] ?? '0'; ?>">
                            <input type="hidden" name="item_brand" value="<?php echo $fetch_cart['item_brand'] ?? "Unknown" ?>">
                            <input type="hidden" name="item_name" value="<?php echo $fetch_cart['item_name'] ?? "Unknown" ?>">
                            <input type="hidden" name="item_price" value="<?php echo $fetch_cart['item_price'] ?? "Unknown" ?>">
                            <input type="hidden" id="input_quantity" name="input_quantity" value="<?php echo $fetch_cart['item_quantity'] ?? "1" ?>">
                            <input type="hidden" name="item_image" value="<?php echo $fetch_cart['item_image'] ??  "Unknown" ?>">
                            <input type="hidden" name="user_id" value="<?php echo 1; ?>">
                            <?php
                                if($grand_total == 0){
                                   echo '<button type="submit" name="checkout" class="btn btn-danger mt-3" disabled>No Items to Checkout</button>';
                                }
                                else{
                                    echo '<button type="submit" name="checkout" class="btn btn-warning mt-3">Proceed to Checkout</button>';
                                }
                            ?>

                        </form>
                    </div>
                </div>
            </div>
            <!-- !subtotal section-->
        </div>
        <!--  !shopping cart items   -->
    </div>
</section>
<!-- !Shopping cart section  -->

<section class="edit-form-container">

    <?php
    if(isset($_GET['item_id_popup'])) {
        $item_id = $_GET['item_id_popup'];
        $select_product = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id = '$item_id'") or die('query failed');
        $fetch_product = mysqli_fetch_assoc($select_product);
        $item_quantity = $fetch_product['item_quantity'];
        $item_reservation = $fetch_product['item_reservation'];
        $item_id = $fetch_product['item_id'];

        $total_quantity = $fetch_product['small_quantity'] + $fetch_product['medium_quantity'] + $fetch_product['large_quantity'];

        ?>


        <form action="" method="post">
            <div class="d-flex">
                <div class="col-sm-4  d-flex">
                    <img src="<?php echo $fetch_product['item_image'] ?? "./assets/products/product-1.jpg" ?>" style="height: 150px;" alt="cart1" class="img-fluid">

                </div>

                <div class="col-sm-8 text-left sizepopup w-25">
                    <h5 class="font-baloo font-size-20"><?php echo $fetch_product['item_name'] ?? "Unknown"; ?></h5>
                    <small class="text-danger font-size-16">₱<small class="text-danger text-right" id="size_price"><?php echo $fetch_product['small_price'] ?? 0; ?></small></small><br>
                    <small><?php echo $fetch_product['item_brand'] ?? "Brand"; ?></small><br>
                    <input type="hidden" id="small_quantity" value="<?php echo $fetch_product['small_quantity'] ?? 0; ?>">
                    <input type="hidden" id="medium_quantity" value="<?php echo $fetch_product['medium_quantity'] ?? 0; ?>">
                    <input type="hidden" id="large_quantity" value="<?php echo $fetch_product['large_quantity'] ?? 0; ?>">
                    <small>Stock: </small><small id="stock_quantity">
                        <?php
                        if($item_reservation == 'Reservation' && $total_quantity > 0){
                            echo $fetch_product['small_quantity'] ?? 0;
                        }elseif($item_reservation == 'Reservation'){
                            echo $fetch_product['item_quantity'] ?? 0;
                        }else{
                            echo $fetch_product['small_quantity'] ?? 0;
                        }

                        ?></small><br>
                    <small>Quantity:</small>
                    <input type="number" id="input_quantitys" class="border" name="input_quantitys"  class="border px-2 bg-light text-center p-2 m-2" min="1" max="MyVar" value="1" placeholder="1" style="width: 40px; height: 30px;"><br>
                    <small>Size:</small><br>
                    <input type="radio" name="sizepopup" id="smallpopup" value="<?php echo $fetch_product['small_price'] ?? 0; ?>" checked="checked"
                        <?php
                        $small_quantity = $fetch_product['small_quantity'];
                        if($small_quantity == 0 && $item_reservation != 'Reservation') {
                            echo "disabled";
                        }
                        ?>>
                    <label for="smallpopup">Small<span></span></label>
                    <input type="radio" name="sizepopup" id="mediumpopup" value="<?php echo $fetch_product['medium_price'] ?? 0; ?>"
                        <?php
                        $medium_quantity = $fetch_product['medium_quantity'];
                        if($medium_quantity == 0 && $item_reservation != 'Reservation') {
                            echo "disabled";
                        }
                        ?>>
                    <label for="mediumpopup">Medium<span></span></label>
                    <input type="radio" name="sizepopup" id="largepopup" value="<?php echo $fetch_product['large_price'] ?? 0; ?>"
                        <?php
                        $large_quantity = $fetch_product['large_quantity'];
                        if($large_quantity == 0 && $item_reservation != 'Reservation') {
                            echo "disabled";
                        }
                        ?>>
                    <label for="largepopup">Large<span></span></label><br>
                    <?php 
                        if($fetch_product['item_brand'] == "Plants"){
                    ?> 
                        <!-- Pots -->
                    <small>Pots:</small><br>
                        <input type="radio" name="pot" onclick="getWithouPotPopup()" id="withoutPot" value="withoutPot" checked="checked">
                        <label for="withoutPot" onclick="getWithoutPotPopup()">Without Pot<span></span></label>
                        <input type="radio" onclick="getWithPotPopup()" name="pot" id="withPot" value="withPot">
                        <label for="withPot" onclick="getWithPotPopup()">With Pot<span></span></label>
                        <!-- !Pots -->
                    <?php        
                        }
                    ?>
                    <div class="containers" style="display: flex;"></div>

                    
                </div>


            </div>
            <div class="d-block">

                <input type="hidden"  name="item_id" id="item_id_popup" value="<?php echo $item_id ?? 0; ?>">
                <input type="hidden" name="item_brand" value="<?php echo $fetch_product['item_brand'] ?? "Unknown" ?>">
                <input type="hidden" name="item_name" value="<?php echo $fetch_product['item_name'] ?? "Unknown" ?>">
                <input type="hidden" name="item_price" id="item_size" value="<?php echo $fetch_product['small_price'] ?? "Unknown" ?>">
                <input type="hidden" name="size" id="item_sizes" value="<?php echo $_POST['item_size'] ?? "smallpopup" ?>">
                <input type="hidden" name="pot" id='input_pots' value="<?php echo $_POST['item_pot'] ?? "No Pot" ?>">
                <input type="hidden" name="item_image" value="<?php echo $fetch_product['item_image'] ??  "Unknown" ?>">
                <input type="hidden" name="input_quantity" id="input_quantit" value="1">
                <input type="hidden" name="save_price" id="save_price" value="1">
                <input type="hidden" id="reservation" name="reservation" value="<?php echo $fetch_product['item_reservation'] ?? "Unknown"; ?>">
                <input type="hidden" id="total_quantity" name="total_quantity" value="<?php echo $total_quantity; ?>">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['username']->user_id ?? 0; ?>"><br>
                <?php
                $item_id = $fetch_product['item_id'];
                if($total_quantity > 0) {
                    echo '<button type="submit" name="top_sale_submit" class="btn btn-warning text-white">Add to Cart</button>';

                }
                if($item_reservation == 'Reservation'){
                    echo PHP_EOL;
                    echo '<button type="submit" onclick="getReserveVal()" name="top_sale_reserve" class="btn btn-success text-white">Reserve</button>';
                }
                ?>


                <button type="button" onclick="getAddtoCart()"  id="close-edit" name="close_btn" class="btn btn-danger text-white text-left" style="text-decoration: none">Close</button>



            </div>

        </form>

        <?php

        echo "<script>document.querySelector('.edit-form-container').style.display ='flex'</script>";

    };
    ?>

    <style>

        :root{
            --blue:#2980b9;
            --red:tomato;
            --orange:orange;
            --black:#333;
            --white:#fff;
            --bg-color:#eee;
            --dark-bg:rgba(0,0,0,.7);
            --box-shadow:0 .5rem 1rem rgba(0,0,0,.1);
            --border:.1rem solid #999;
        }

        .edit-form-container{
            position: fixed;
            top:0; left:0;
            z-index: 1100;
            background-color: var(--dark-bg);
            padding:0 28rem;
            display: none;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            width: 100%;
        }

        .edit-form-container form{
            width: 50rem;
            border-radius: .5rem;
            background-color: white;
            text-align: center;
            padding:2rem;
        }

        .edit-form-container form .box{
            width: 100%;
            background-color: var(--bg-color);
            border-radius: .5rem;
            margin:1rem 0;
            font-size: 1.7rem;
            color:var(--black);
            padding:1.2rem 1.4rem;
            text-transform: none;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <script>

        function popupValue(){
        }
        
        function getVal() {
            let $stock_reservation = document.getElementById('stock_quantity').innerText;
            var val = document.getElementById("stock_quantity").innerText;
            var input = document.getElementById("input_quantitys");
            input.setAttribute("max",$stock_reservation); // set a new value;
            alert($stock_reservation);
            //$('#input_quantity').val(data);
        }

        $("#input_quantitys").bind('key mouseup' , function(){
            //alert("changed");
            let $stock_reservation = document.getElementById('stock_quantity').innerText;
            var val = document.getElementById("stock_quantity").innerText;
            var input = document.getElementById("input_quantitys");
            input.setAttribute("max",$stock_reservation); // set a new value;
            console.log($stock_reservation);
        })

        function getReserveVal(){
            var input = document.getElementById("input_quantitys");
            input.setAttribute("max",10); // set a new value;
            console.log(total_quantity);
            console.log(reservation);
        }

        function getAddtoCart(){

                if(window.location.hash == "#top-sale"){
                    var index = "#top-sale"
                    window.location.href = window.location.href.split('?')[0] + index;
                }

                if(window.location.hash == "#special_price"){
                    var index = "#special_price"
                    window.location.href = window.location.href.split('?')[0] + index;
                }

                if(window.location.hash == "#new-plants"){
                    var index = "#new-plants"
                    window.location.href = window.location.href.split('?')[0] + index;

                }

                document.querySelector('.edit-form-container').style.display = 'none';

                console.log(index);

        }

        function getReserveCart(){
            
            document.querySelector('#close-edit').onclick = () =>{

                if(window.location.hash == "#top-sale"){
                    var index = "#top-sale"
                    window.location.href = window.location.href.split('?')[0] + index;
                }

                if(window.location.hash == "#special_price"){
                    var index = "#special_price"
                    window.location.href = window.location.href.split('?')[0] + index;
                }

                if(window.location.hash == "#new-plants"){
                    var index = "#new-plants"
                    window.location.href = window.location.href.split('?')[0] + index;

                }

                document.querySelector('.edit-form-container').style.display = 'none';

                console.log(index);
            };
        }

        function getWithPotPopup(){

            //alert("working");
            document.getElementById("withPot").onclick = function(){

                    var value = $(this).val();
                    //alert(value);
                    var size = $("input[name='sizepopup']:checked").val();
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
                            $(".containers").html("<span>Working...</span>");
                        },
                        success:function(data){
                            $(".containers").html(data);
                        }
                    })

                if(this.checked == true){
                    var sizepot = $("input[name='sizepopup']:checked").val();
                    let $save_prices_pot = sizepot;
                    //alert('Change Happened');
                    sizeid = $("input[name='sizepopup']:checked").attr('id');
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
                                $('#save_price').val(data);
                                $('#size_price').html(data);
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
                                $('#save_price').val(data);
                                $('#size_price').html(data);
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
                                $('#save_price').val(data);
                                $('#size_price').html(data);;
                            }
                        });
                    }
                }
            }

        }

        function getWithoutPotPopup(){
            
            //alert("working");
            document.getElementById("withoutPot").onclick = function(){
                
                //$('#sizing-product').val(data);
                //$('#sizing-cart').val(data);
                var size = $("input[name='sizepopup']:checked").val();
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
                        $(".containers").html("<span>Working...</span>");
                    },
                    success:function(data){
                        $(".containers").html(data);
                    }
                })
    
                if(this.checked == true){
                potid = "No Pot";
                $("#input_pot").val(potid);
                $("#input_pots").val(potid);
                var sizepot = $("input[name='sizepopup']:checked").val();
                let $save_prices_pot = sizepot;
                //alert('Change Happened');
    
                var potvalue =  $("#withoutPot").val();
                //alert(potvalue);
                var withPot = document.getElementById("withPot");
                var withoutPot = document.getElementById("withoutPot");
                withPot.checked = false;
                withoutPot.checked = true;
                console.log($save_prices_pot);
                sizeid = $("input[name='sizepopup']:checked").attr('id');
    
                    if(sizeid === "small"){
    
                        let $potvalue = 0.00;
                        //console.log($potvalue);
                        //alert($potvalue);
                        var size = $("input[name='sizepopup']:checked").val();
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
                                $('#save_price').val(data);
                                $('#size_price').html(data);
                            }
                        });
                                                            
    
                    }else if(sizeid === "medium"){
    
                        let $potvalue = 0.00;
                        //console.log($potvalue);
                        //alert($potvalue);
                        var size = $("input[name='sizepopup']:checked").val();
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
                                $('#save_price').val(data);
                                $('#size_price').html(data);
                            }
                        });
    
                    }else if(sizeid === "large"){
    
                        let $potvalue = 0.00;
                        //console.log($potvalue);
                        //alert($potvalue);
                        var size = $("input[name='sizepopup']:checked").val();
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
                                $('#save_price').val(data);
                                $('#size_price').html(data);
                            }
                        });
                    }        
                }
            }
        }
        
        $(document).on('change', '.sizepopup', function (){

            document.getElementById('smallpopup').onclick = function() {
                if (this.checked == true) {
                    // the element is checked
                    if(reservation != 'Reservation'){
                        var input = document.getElementById("input_quantitys");
                        input.setAttribute("max",$stock_small); // set a new value;
                        $('#stock_quantity').html($stock_small);
                        console.log($stock_small);
                    }else if(reservation == 'Reservation' && total_quantity > 0) {
                        var input = document.getElementById("input_quantitys");
                        input.setAttribute("max",$stock_small); // set a new value;
                        $('#stock_quantity').html($stock_small);
                        console.log($stock_small);
                    }else if(reservation == 'Reservation' && total_quantity < 1){

                        console.log(total_quantity);
                        console.log(reservation);
                    }

                }
            };

            document.getElementById('mediumpopup').onclick = function() {
                if (this.checked == true) {
                    // the element is checked
                    if(reservation != 'Reservation'){
                        var input = document.getElementById("input_quantitys");
                        input.setAttribute("max",$stock_medium); // set a new value;
                        $('#stock_quantity').html($stock_medium);
                        console.log($stock_medium);
                    }else if(reservation == 'Reservation' && total_quantity > 0) {
                        var input = document.getElementById("input_quantitys");
                        input.setAttribute("max",$stock_medium); // set a new value;
                        $('#stock_quantity').html($stock_medium);
                        console.log($stock_medium);
                    }else if(reservation == 'Reservation' && total_quantity < 1){

                        console.log(total_quantity);
                        console.log(reservation);
                    }
                }
            };

            document.getElementById('largepopup').onclick = function() {
                if (this.checked == true) {
                    // the element is checked
                    if(reservation != 'Reservation'){
                        var input = document.getElementById("input_quantitys");
                        input.setAttribute("max",$stock_large); // set a new value;
                        $('#stock_quantity').html($stock_large);
                        console.log($stock_large);
                    }else if(reservation == 'Reservation' && total_quantity > 0) {
                        var input = document.getElementById("input_quantitys");
                        input.setAttribute("max",$stock_large); // set a new value;
                        $('#stock_quantity').html($stock_large);
                        console.log($stock_large);
                    }else if(reservation == 'Reservation' && total_quantity < 1){

                        console.log(total_quantity);
                        console.log(reservation);
                    }
                }
            };

            var size_popup = $("input[name='sizepopup']:checked").val();
            //console.log(size_popup);
            let $save_price = size_popup;
            document.getElementById('input_quantit').value = document.getElementById('input_quantitys').value;
            //document.getElementById('size_price').value = document.getElementById('input_quantit').value * document.getElementById('size_price').value;
            let $input = document.getElementById('input_quantit').value;

            $('#save_price').html($save_price);
            var price = document.getElementById('size_price').innerHTML;
            let changing_price = ($save_price * $input).toFixed(2);
            $('#size_price').html(changing_price);

                if($("input[name='pot']:checked").val() == "withPot"){
                    sizeid = $("input[name='sizepopup']:checked").attr('id');
                    console.log(sizeid);

                    if(sizeid === "smallpopup"){

                        let $potvalue = 20.00;
                        //console.log($potvalue);
                        //alert($potvalue);
                        var size = $("input[name='sizepopup']:checked").val();
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
                                $('#save_price').val(data);
                                $('#size_price').html(data);

                            }
                        });
                                                        
                        
                    }else if(sizeid === "mediumpopup"){

                        let $potvalue = 45.00;
                        //console.log($potvalue);
                        //alert($potvalue);
                        var size = $("input[name='sizepopup']:checked").val();
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
                        //console.log(potid);
                        $.ajax({
                            url:"size.php",
                            method: "POST",
                            data:{size:size, potvalue:$potvalue, input:$input},
                            dataType:"JSON",
                            success:function (data){

                                //$('#item_sizes').val(data);
                                //$('#product_size').val(data);
                                $('#sizing-product').val(data);
                                $('#save_price').val(data);
                                $('#size_price').html(data);
                            }
                        });
                            
                    }else if(sizeid === "largepopup"){

                        let $potvalue = 60.00;
                        //console.log($potvalue);
                        //alert($potvalue);
                        var size = $("input[name='sizepopup']:checked").val();
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
                        //console.log(potid);

                        $.ajax({
                            url:"size.php",
                            method: "POST",
                            data:{size:size, potvalue:$potvalue, input:$input},
                            dataType:"JSON",
                            success:function (data){

                                //$('#item_sizes').val(data);
                                //$('#product_size').val(data);
                                $('#sizing-product').val(data);
                                $('#save_price').val(data);
                                $('#size_price').html(data);
                            }
                        });
                    }
                }else if($("input[name='pot']:checked").val() == "withoutPot"){
                    sizeid = $("input[name='sizepopup']:checked").attr('id');
                    console.log(sizeid);
                    if(sizeid === "smallpopup"){

                        let $potvalue = 0.00;
                        //console.log($potvalue);
                        //alert($potvalue);
                        var size = $("input[name='sizepopup']:checked").val();
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
                                $('#save_price').val(data);
                                $('#size_price').html(data);
                            }
                        });
                                                                
                    }else if(sizeid === "mediumpopup"){

                        let $potvalue = 0.00;
                        //console.log($potvalue);
                        //alert($potvalue);
                        var size = $("input[name='sizepopup']:checked").val();
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
                                $('#save_price').val(data);
                                $('#size_price').html(data);
                            }
                        });

                    }else if(sizeid === "largepopup"){

                            let $potvalue = 0.00;
                            //console.log($potvalue);
                            //alert($potvalue);
                            var size = $("input[name='sizepopup']:checked").val();
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
                                $('#save_price').val(data);
                                $('#size_price').html(data);
                            }
                        });
                    }
                }else{
                    sizeid = $("input[name='sizepopup']:checked").attr('id');
                    console.log(sizeid);
                    if(sizeid === "smallpopup"){

                        let $potvalue = 0.00;
                        //console.log($potvalue);
                        //alert($potvalue);
                        var size = $("input[name='sizepopup']:checked").val();
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
                                $('#save_price').val(data);
                                $('#size_price').html(data);
                            }
                        });
                                                                
                    }else if(sizeid === "mediumpopup"){

                        let $potvalue = 0.00;
                        //console.log($potvalue);
                        //alert($potvalue);
                        var size = $("input[name='sizepopup']:checked").val();
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
                                $('#save_price').val(data);
                                $('#size_price').html(data);
                            }
                        });

                    }else if(sizeid === "largepopup"){

                        let $potvalue = 0.00;
                        //console.log($potvalue);
                        //alert($potvalue);
                        var size = $("input[name='sizepopup']:checked").val();
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
                                $('#save_price').val(data);
                                $('#size_price').html(data);
                            }
                        });
                    }
                }

                //console.log($save_price);
                //console.log(price);
                //console.log(changing_price);

                $.ajax({
                    url:"size.php",
                    method: "POST",
                    data:{size_popup:size_popup},
                    dataType:"JSON",
                    success:function (data){

                    //$save_price = data;
                    $('#size_prices').html(data);
                    $('#item_size').val(data);
                    $('#product_size').val(data);

                }
            });
        });

            let $stock_small = document.getElementById('small_quantity').value;
            let $stock_medium = document.getElementById('medium_quantity').value;
            let $stock_large = document.getElementById('large_quantity').value;
            let $stock_reservation = document.getElementById('stock_quantity').innerText;
            let reservation = document.getElementById("reservation").value;
            let total_quantity = document.getElementById("total_quantity").value;

            if(reservation != 'Reservation'){
                var input = document.getElementById("input_quantitys");
                input.setAttribute("max",$stock_small); // set a new value;
            }else if(reservation == 'Reservation' && total_quantity > 0) {
                var input = document.getElementById("input_quantitys");
                input.setAttribute("max",$stock_small); // set a new value;
            }else if(reservation == 'Reservation' && total_quantity < 1){
                var input = document.getElementById("input_quantitys");
                input.setAttribute("max",$stock_reservation); // set a new value;
                console.log(total_quantity);
                console.log(reservation);
            }

            document.getElementById('smallpopup').onclick = function() {
                if (this.checked == true) {
                    // the element is checked
                    if(reservation != 'Reservation'){
                        var input = document.getElementById("input_quantitys");
                        input.setAttribute("max",$stock_small); // set a new value;
                        $('#stock_quantity').html($stock_small);
                        console.log($stock_small);
                    }else if(reservation == 'Reservation' && total_quantity > 0) {
                        var input = document.getElementById("input_quantitys");
                        input.setAttribute("max",$stock_small); // set a new value;
                        $('#stock_quantity').html($stock_small);
                        console.log($stock_small);
                    }else if(reservation == 'Reservation' && total_quantity < 1){

                        console.log(total_quantity);
                        console.log(reservation);
                    }

                }
            };

            document.getElementById('mediumpopup').onclick = function() {
                if (this.checked == true) {
                    // the element is checked
                    if(reservation != 'Reservation'){
                        var input = document.getElementById("input_quantitys");
                        input.setAttribute("max",$stock_medium); // set a new value;
                        $('#stock_quantity').html($stock_medium);
                        console.log($stock_medium);
                    }else if(reservation == 'Reservation' && total_quantity > 0) {
                        var input = document.getElementById("input_quantitys");
                        input.setAttribute("max",$stock_medium); // set a new value;
                        $('#stock_quantity').html($stock_medium);
                        console.log($stock_medium);
                    }else if(reservation == 'Reservation' && total_quantity < 1){

                        console.log(total_quantity);
                        console.log(reservation);
                    }
                }
            };

            document.getElementById('largepopup').onclick = function() {
                if (this.checked == true) {
                    // the element is checked
                    if(reservation != 'Reservation'){
                        var input = document.getElementById("input_quantitys");
                        input.setAttribute("max",$stock_large); // set a new value;
                        $('#stock_quantity').html($stock_large);
                        console.log($stock_large);
                    }else if(reservation == 'Reservation' && total_quantity > 0) {
                        var input = document.getElementById("input_quantitys");
                        input.setAttribute("max",$stock_large); // set a new value;
                        $('#stock_quantity').html($stock_large);
                        console.log($stock_large);
                    }else if(reservation == 'Reservation' && total_quantity < 1){

                        console.log(total_quantity);
                        console.log(reservation);
                    }
                }
            };

        //document.getElementById('input_quantitys').value;

    </script>
</section>