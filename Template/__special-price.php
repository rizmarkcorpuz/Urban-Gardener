<!-- Special Price -->

<?php
    $brand = array_map(function ($pro){ return $pro['item_brand'];}, $product_shuffle);
    $unique = array_unique($brand);
    sort($unique);
    shuffle($product_shuffle);

    //request method post
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_POST['user_id'])) {
            $user_id = $_POST['user_id'];
            if ($_POST['user_id'] == 0) {
                echo '<script type="text/javascript">';
                echo 'alert("Need To Login First")';  //not showing an alert box.
                echo '</script>';
                header("Location: login");

            } else {

                $verified_query = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'");
                $row = mysqli_fetch_assoc($verified_query);

                if($row['email_verified'] == NULL){
                    header("Location: verify");;
                }else {

                    if (isset($_POST['special_price_submit'])) {
                        //call method addToCart
                        $user_id = $_POST['user_id'];
                        $item_id = $_POST['item_id'];
                        $item_brand = $_POST['item_brand'];
                        $item_name = $_POST['item_name'];
                        $item_price = $_POST['item_price'];
                        $item_image = $_POST['item_image'];
                        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE item_name = '$item_name' AND user_id = '$user_id'") or die('query failed');
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
                            mysqli_query($conn, "INSERT INTO `cart`(user_id, item_id, item_brand, item_name, item_price, item_size, item_image) VALUES('$user_id', '$item_id', '$item_brand', '$item_name', '$item_price', 'Small', '$item_image')") or die('query failed');
                            $message[] = 'product added to cart!';
                            header("Location: " . $_SERVER['PHP_SELF']);

                        }
                    } elseif (isset($_POST['special_price_reserve'])) {
                        //call method addToCart
                        $user_id = $_POST['user_id'];
                        $item_id = $_POST['item_id'];
                        $item_brand = $_POST['item_brand'];
                        $item_name = $_POST['item_name'];
                        $item_price = $_POST['item_price'];
                        $item_image = $_POST['item_image'];
                        $select_cart = mysqli_query($conn, "SELECT * FROM `reservation` WHERE item_name = '$item_name' AND user_id = '$user_id'") or die('query failed');
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
                            mysqli_query($conn, "INSERT INTO `reservation`(user_id, item_id, item_brand, item_name, item_price, item_size, item_image) VALUES('$user_id', '$item_id', '$item_brand', '$item_name', '$item_price', 'Small', '$item_image')") or die('query failed');
                            $message[] = 'product added to cart!';
                            header("Location: " . $_SERVER['PHP_SELF']);

                        }
                    }
                }
            }
        }
    }

    $in_cart = $Cart->getCartId($product->getData('cart'));

?>
<section id="special-price">
    <div class="container">
        <h4 class="font-eduvic font-size-24">Special Price</h4>
        <div id="filters" class="button-group text-right font-baloo font-size-16">
        <p>Filter By: 
            <button class="btn is-checked" data-filter="*">All Items</button>
        
           <?php
            array_map(function ($brand){
                printf('<button class="btn" data-filter=".%s">%s</button>', $brand, $brand);
            }, $unique);
           ?>
        </p>   
        </div>
        <div id="sorts" class="button-group sort-by-button-group text-right font-baloo font-size-16">
        <p>Sort By: 
            <button class="btn is-checked" data-sort-by="name">A-Z</button>
            <button class="btn is-checked" data-sort-by="Z-A">Z-A</button>
        </p>
            
        </div>

        <div class="grid" id="special_price" style="height:5000px;">
           
            <?php
        
            $select_product = mysqli_query($conn, "SELECT * FROM `product`") or die('query failed');
            
            if(mysqli_num_rows($select_product) > 0){
                $fetch_product = mysqli_fetch_assoc($select_product);
                foreach ($product_shuffle as $fetch_product){
                    $item_quantity = $fetch_product['item_quantity'];
                    $item_reservation = $fetch_product['item_reservation'];

                    $total_quantity = $fetch_product['small_quantity'] + $fetch_product['medium_quantity'] + $fetch_product['large_quantity'];
                    ?>
            <div class="grid-item <?php echo isset($fetch_product['item_brand']) ? $fetch_product['item_brand'] : "Brand" ; echo " "; echo isset($fetch_product['item_name']) ? $fetch_product['item_name'] : "Name";?>">
                <div class="item" style="width: 200px;">
                    <div class="product font-rale">
                        <form action="product" method="post">
                            <input type="hidden" class="item-id" name="item_id" value="<?php echo $fetch_product['item_id'] ?? 1; ?>">
                            <button type="submit" style="border: 0px;"><img src="<?php echo isset($fetch_product['item_image']) ? $fetch_product['item_image'] : "./assets/products/product-1.jpg"; ?>" alt="product1" class="img-fluid"></button>
                        </form>
                        <div class="text-center">
                            <h6 class="py-3 item-name"><?php echo isset($fetch_product['item_name']) ? $fetch_product['item_name'] : "Unknown"; ?></h6>
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
                            <div class="price py-2">
                                <span>₱<?php echo isset($fetch_product['small_price']) ? $fetch_product['small_price'] : "0"; ?></span>
                            </div>

                            <div class="price py-2">
                                <span>Stocks: <?php echo $total_quantity ?? 0; ?></span>
                            </div>

                            <form method="post" class="py-4">
                                <input type="hidden" name="item_id" value="<?php echo isset($fetch_product['item_id']) ? $fetch_product['item_id'] : '1'; ?>">
                                <input type="hidden" name="item_brand" value="<?php echo $fetch_product['item_brand'] ?? $fetch_product['item_brand']; ?>">
                                <input type="hidden" name="item_name" value="<?php echo $fetch_product['item_name'] ?? $fetch_product['item_name']; ?>">
                                <input type="hidden" name="item_price" value="<?php echo $fetch_product['item_price'] ?? $fetch_product['item_price']; ?>">
                                <input type="hidden" name="item_image" value="<?php echo $fetch_product['item_image'] ?? $fetch_product['item_image']; ?>">
                                <input type="hidden" name="user_id" value="<?php echo 0; ?>">
                                <?php
                                $item_id = $fetch_product['item_id'];
                                if($total_quantity > 0) {
                                    echo '<a class="btn btn-warning text-dark font-size-12" id="open-edit" style="text-decoration: none" href="';
                                    echo $_SERVER['PHP_SELF'] . '?item_id_popup=';
                                    echo $item_id . PHP_EOL . '#special_price">';
                                    echo 'Add to Cart </a>';
                                    if($item_reservation == 'Reservation'){
                                        echo PHP_EOL;
                                        echo '<a class="btn btn-success text-dark font-size-12" id="open-edit" style="text-decoration: none" href="';
                                        echo $_SERVER['PHP_SELF'] . '?item_id_popup=';
                                        echo $item_id . PHP_EOL . '#special_price">';
                                        echo 'Reservation </a>';
                                    }
                                }elseif($total_quantity < 1){
                                    echo '<button type="submit" disabled name="top_sale_submit" class="btn btn-danger font-size-12">Out of Stock</button>';
                                    if($item_reservation == 'Reservation'){
                                        echo PHP_EOL;
                                        echo '<a class="btn btn-success text-dark font-size-12" id="open-edit" style="text-decoration: none" href="';
                                        echo $_SERVER['PHP_SELF'] . '?item_id_popup=';
                                        echo $item_id . PHP_EOL . '#special_price">';
                                        echo 'Reservation </a>';
                                    }
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php };
            }; ?>
            </div>

    </div>
</section>
<!-- !Special Price -->