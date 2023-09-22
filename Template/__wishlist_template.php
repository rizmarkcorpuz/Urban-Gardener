<!-- Shopping cart section  -->
<?php

    //delete cart item
    if (isset($_POST['delete-cart-submit'])){
        $deletedrecord = $Cart->deleteCart($_POST['cart_id']);
    }


    // add to cart
    if (isset($_POST['cart-submit'])){
        $user_id = $_SESSION['username']->user_id;
        $item_id = $_POST['item_id'];
        $item_brand = $_POST['item_brand'];
        $cart_id =$_POST['cart_id'];
        $item_name = $_POST['item_name'];
        $item_price = $_POST['item_price'];
        $item_image = $_POST['item_image'];
        $select_cart = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE item_name = '$item_name' AND user_id = '$user_id'") or die('query failed');
        $select_wishlist = mysqli_query($conn, "SELECT * FROM `cart` WHERE item_name = '$item_name' AND user_id = '$user_id'") or die('query failed');

        if(mysqli_num_rows($select_wishlist) > 0){
            echo '<script type="text/javascript">';
            echo 'alert("Item already in the cart")';  //not showing an alert box.
            echo '</script>';
        }elseif(mysqli_num_rows($select_cart) > 0){
            mysqli_query($conn, "INSERT INTO `cart`(user_id, item_id, item_brand, item_name, item_price, item_image) VALUES('$user_id', '$item_id', '$item_brand', '$item_name', '$item_price', '$item_image')") or die('query failed');
            mysqli_query($conn, "DELETE FROM `wishlist` WHERE cart_id = '$cart_id'");
            $message[] = 'product added to cart!';
            header("Location: " .$_SERVER['PHP_SELF']);
        }
    }
?>

<section id="cart" class="py-3 mb-5">
    <div class="container-fluid w-75">
        <h5 class="font-baloo font-size-20">Wishlist</h5>

        <!--  shopping cart items   -->
        <div class="row">
            <div class="col-sm-8">
                <?php
                if(isset($_POST['user_id'])){
                    $wishlist_query = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
                    $grand_total = 0;
                    if(mysqli_num_rows($wishlist_query) > 0){
                    while($fetch_wishlist = mysqli_fetch_assoc($wishlist_query)){
                        $item_id = $fetch_wishlist['item_id'];
                        ?>
                        <!-- cart item -->
                        <div class="row border-top py-3 mt-3">
                            <div class="col-sm-2">
                                <img src="<?php echo $fetch_wishlist['item_image'] ?? "./assets/products/product-1.jpg" ?>" style="height: 120px;" alt="cart1" class="img-fluid">
                            </div>
                            <div class="col-sm-8">
                                <h5 class="font-baloo font-size-20"><?php echo $fetch_wishlist['item_name'] ?? "Unknown"; ?></h5>
                                <small><?php echo $fetch_wishlist['item_brand'] ?? "Brand"; ?></small><br>
                                <small>Size: <?php echo $fetch_wishlist['item_size'] ?? "Small"; ?></small>
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
                                    <a href="<?php printf('%s?item_id=%s', 'product.php', $item_id) ?>#review" class="px-2 font-rale font-size-14"><?php echo $total_review ?? 0; ?> ratings</a>

                                </div>
                                <!--  !product rating-->

                                <!-- product qty -->
                                <div class="qty d-flex pt-2">
                                    <form method="post">
                                        <input type="hidden" value="<?php echo $fetch_wishlist['cart_id'] ?? 0; ?>" name="cart_id">
                                        <button type="submit" name="delete-wishlist-submit" class="btn font-baloo text-danger pl-0 pr-3 border-right">Delete</button>
                                    </form>

                                    <form method="post">
                                        <input type="hidden" value="<?php echo $fetch_wishlist['cart_id'] ?? 0; ?>" name="cart_id">
                                        <input type="hidden" name="item_id" value="<?php echo $fetch_wishlist['item_id'] ?? '0'; ?>">
                                        <input type="hidden" name="item_brand" value="<?php echo $fetch_wishlist['item_brand'] ?? "Unknown" ?>">
                                        <input type="hidden" name="item_name" value="<?php echo $fetch_wishlist['item_name'] ?? "Unknown" ?>">
                                        <input type="hidden" name="item_price" value="<?php echo $fetch_wishlist['item_price'] ?? "Unknown" ?>">
                                        <input type="hidden" name="item_image" value="<?php echo $fetch_wishlist['item_image'] ??  "Unknown" ?>">
                                        <input type="hidden" name="user_id" value="<?php echo 1; ?>">
                                        <button type="submit" name="cart-submit" class="btn font-baloo text-danger">Add to Cart</button>
                                    </form>
                                </div>
                                <!-- !product qty -->

                            </div>

                            <div class="col-sm-1 text-right">
                                <div class="font-size-20 text-danger font-baloo">
                                    ₱<span class="product_price" data-id="<?php echo $fetch_wishlist['item_id'] ?? 0; ?>"><?php echo $fetch_wishlist['item_price'] ?? 0; ?></span>
                                </div>
                            </div>
                        </div>
                        <!-- !cart item -->
                        <?php

                }

                }else {
                    echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
                }}
                ?>
            </div>
        </div>
        <!--  !shopping cart items   -->
    </div>
</section>
<!-- !Shopping cart section  -->