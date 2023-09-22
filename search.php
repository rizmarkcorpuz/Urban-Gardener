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
ob_start();
//include header.php file
include ('header.php');

if(isset($_SESSION['search'])){
    $search = $_SESSION['search'];
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username']->username;
    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_POST['user_id'] = $row['user_id'];
        //echo $_POST['user_id'];
    } else {
        echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
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

?>

<section id="special-price">
    <div class="container py-5" style="margin-top: 100px;">
        <h4 class="font-eduvic font-size-24">Search Result</h4>
        <hr>
        <!-- owl carousel -->
        <div class="grid">

            <?php
            $search = $_SESSION['search'];
            $select_product = mysqli_query($conn, "SELECT * FROM `product` WHERE item_name LIKE '%$search%' or item_brand LIKE '%$search%' or item_reservation LIKE '%$search%'") or die('query failed');
            if(mysqli_num_rows($select_product) > 0){
                while($fetch_product = mysqli_fetch_assoc($select_product)){

                    $item_quantity = $fetch_product['item_quantity'];
                    $item_reservation = $fetch_product['item_reservation'];
                    $item_id = $fetch_product['item_id'];

                    $total_quantity = $fetch_product['small_quantity'] + $fetch_product['medium_quantity'] + $fetch_product['large_quantity'];
                    ?>
            <div class="grid-item">
                    <div class="item" style="width: 200px;">
                        <div class="product font-rale">
                            <form action="product" method="post">
                                <input type="hidden" name="item_id" value="<?php echo $fetch_product['item_id'] ?? 1; ?>">
                                <button type="submit" style="border: 0px;"><img src="<?php echo isset($fetch_product['item_image']) ? $fetch_product['item_image'] : "./assets/products/product-1.jpg"; ?>" alt="product1" class="img-fluid"></button>
                            </form>
                            <div class="text-center">
                                <h6 class="py-3"><?php echo isset($fetch_product['item_name']) ? $fetch_product['item_name'] : "Unknown"; ?></h6>
                                <h6 class="py-3"><?php echo isset($fetch_product['item_brand']) ? $fetch_product['item_brand'] : "Unknown"; ?></h6>
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
                                    <span>₱<?php echo isset($fetch_product['item_price']) ? $fetch_product['item_price'] : '0'; ?></span>
                                </div>

                                <div class="price py-2">
                                    <span>Stocks: <?php echo $total_quantity ?? 0; ?></span>
                                </div>

                                <form method="post" class="py-4">
                                    <input type="hidden" name="item_id" value="<?php echo $fetch_product['item_id'] ?? 0; ?>">
                                    <input type="hidden" name="item_brand" value="<?php echo $fetch_product['item_brand'] ?? "Unknown" ?>">
                                    <input type="hidden" name="item_name" value="<?php echo $fetch_product['item_name'] ?? "Unknown" ?>">
                                    <input type="hidden" name="item_price" value="<?php echo $fetch_product['item_price'] ?? "Unknown" ?>">
                                    <input type="hidden" name="item_image" value="<?php echo $fetch_product['item_image'] ??  "Unknown" ?>">
                                    <input type="hidden" name="user_id" value="<?php echo 0; ?>">
                                    <?php
                                    $item_id = $fetch_product['item_id'];
                                    if($total_quantity > 0) {
                                        echo '<a class="btn btn-warning text-dark font-size-12" onclick="popupValue()" id="open-edit" style="text-decoration: none" href="';
                                        echo $_SERVER['PHP_SELF'] . '?item_id_popup=';
                                        echo $item_id . PHP_EOL . '#top-sale">';
                                        echo 'Add to Cart </a>';
                                        if($item_reservation == 'Reservation'){
                                            echo PHP_EOL;
                                            echo '<a class="btn btn-success text-dark font-size-12" onclick="popupValue()" id="open-edit" style="text-decoration: none" href="';
                                            echo $_SERVER['PHP_SELF'] . '?item_id_popup=';
                                            echo $item_id . PHP_EOL . '#top-sale">';
                                            echo 'Reservation </a>';
                                        }
                                    }elseif($total_quantity < 1){
                                        echo '<button type="submit" disabled name="top_sale_submit" class="btn btn-danger font-size-12">Out of Stock</button>';
                                        if($item_reservation == 'Reservation'){
                                            echo PHP_EOL;
                                            echo '<a class="btn btn-success text-dark font-size-12" onclick="popupValue()" id="open-edit" style="text-decoration: none" href="';
                                            echo $_SERVER['PHP_SELF'] . '?item_id_popup=';
                                            echo $item_id . PHP_EOL . '#top-sale">';
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
            };//closing foreach function ?>
        </div>
        <!-- !owl carousel -->
    </div>
</section>
<!-- !Top Sale -->

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
                        <input type="radio" name="pot" onclick="getWithoutPotPopup()" id="withoutPot" value="withoutPot" checked="checked">
                        <label for="withoutPot" onclick="getWithoutPotPopup()">Without Pot<span></span></label>
                        <input type="radio" onclick="getWithPotPopup()" name="pot" id="withPot" value="withPot">
                        <label for="withPot" onclick="getWithPotPopup()">With Pot<span></span></label>
                        <!-- Pots -->
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
                <input type="hidden" name="size" id="item_sizes" value="<?php echo $_POST['item_size'] ?? "Small" ?>">
                <input type="hidden" name="pot" id='input_pots' value="<?php echo $_POST['item_pot'] ?? "No Pot" ?>">
                <input type="hidden" name="item_image" value="<?php echo $fetch_product['item_image'] ??  "Unknown" ?>">
                <input type="hidden" name="input_quantity" id="input_quantity" value="1">
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
                input.setAttribute("max",total_quantity); // set a new value;
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

            //alert("working-search");
            document.getElementById("withPot").onclick = function(){

                    var value = $(this).val();
                    //alert(value);
                    var size = $("input[name='sizepopup']:checked").val();
                    //alert('Change Happened');
                    //console.log(size);
                    let $input = document.getElementById('input_quantity').value;
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
            
            //alert("working-search");
            document.getElementById("withoutPot").onclick = function(){
                
                //$('#sizing-product').val(data);
                //$('#sizing-cart').val(data);
                var size = $("input[name='sizepopup']:checked").val();
                //alert('Change Happened');
                //console.log(size);
                let $input = document.getElementById('input_quantity').value;
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
                        let $input = document.getElementById('input_quantity').value;
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
                        let $input = document.getElementById('input_quantity').value;
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
                        let $input = document.getElementById('input_quantity').value;
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
            document.getElementById('input_quantity').value = document.getElementById('input_quantitys').value;
            //document.getElementById('size_price').value = document.getElementById('input_quantity').value * document.getElementById('size_price').value;
            let $input = document.getElementById('input_quantity').value;

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
                            let $input = document.getElementById('input_quantity').value;
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
                            let $input = document.getElementById('input_quantity').value;
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
                            let $input = document.getElementById('input_quantity').value;
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
                            let $input = document.getElementById('input_quantity').value;
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
                            let $input = document.getElementById('input_quantity').value;
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
                            let $input = document.getElementById('input_quantity').value;
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

            let $stock_small = document.getElementById('small_quantity')?.value;
            let $stock_medium = document.getElementById('medium_quantity')?.value;
            let $stock_large = document.getElementById('large_quantity')?.value;
            let $stock_reservation = document.getElementById('stock_quantity')?.innerText;
            let reservation = document.getElementById("reservation")?.value;
            let total_quantity = document.getElementById("total_quantity")?.value;
            //alert(total_quantity);

            if(reservation != 'Reservation'){
                var input = document.getElementById("input_quantitys");
                input?.setAttribute("max",$stock_small); // set a new value;
            }else if(reservation == 'Reservation' && total_quantity > 0) {
                var input = document.getElementById("input_quantitys");
                input?.setAttribute("max", $stock_small); // set a new value;
            }else if(reservation == 'Reservation' && total_quantity < 1){
                var input = document.getElementById("input_quantitys");
                input?.setAttribute("max",$stock_reservation); // set a new value;
                console.log(total_quantity);
                console.log(reservation);
            }

        if($stock_small != null){

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
        }

        //document.getElementById('input_quantitys').value;

    </script>
</section>


<?php
//include footer.php file
include('footer.php')
?>
