<?php
//include header.php file
include ('./includes/header.php');

?>

<?php

include 'config.php';

if (!isset($_SESSION['admin_user_id'])) {
    header("Location: login");

}else{
    $admin_username = $_SESSION['admin_username'];
    $admin_user_id = $_SESSION['admin_user_id'];
    $sql = "SELECT * FROM user WHERE user_id='$admin_user_id'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];
        $_SESSION['user_image'] = $row['user_image'];
        $_POST['contact_number'] = $row['contact_number'];
        $_POST['billing_address'] = $row['billing_address'];
        $_POST['zipcode'] = $row['zipcode'];
        $_POST['email'] = $row['email'];
        $first_name = $_SESSION['first_name'];
        $last_name = $_SESSION['last_name'];
        $user_image = $_SESSION['user_image'];
        if($row['user_type'] == 1){
            $_POST['user_type'] = 'User';
        }elseif($row['user_type'] == 32){
            $_POST['user_type'] = 'Admin';
        }
        //echo $_SESSION['user_id'];
    } else {
        echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
    }
}

if(isset($_POST['add_product'])){
    $item_name = $_POST['item_name'];
    $item_brand = $_POST['item_brand'];
    //$item_price = $_POST['item_price'];
    $small_price = $_POST['small_price'];
    $medium_price = $_POST['medium_price'];
    $large_price = $_POST['large_price'];
    //$item_quantity = $_POST['item_quantity'];
    $small_quantity = $_POST['small_quantity'];
    $medium_quantity = $_POST['medium_quantity'];
    $large_quantity = $_POST['large_quantity'];
    $item_image = $_FILES['item_image']['name'];
    $small_image = $_FILES['small_image']['name'];
    $medium_image = $_FILES['medium_image']['name'];
    $large_image = $_FILES['large_image']['name'];
    $item_image_tmp_name = $_FILES['item_image']['tmp_name'];
    $item_image_folder = 'assets/products/'.$item_image;
    $small_image_tmp_name = $_FILES['small_image']['tmp_name'];
    $small_image_folder = 'assets/products/'.$small_image;
    $medium_image_tmp_name = $_FILES['medium_image']['tmp_name'];
    $medium_image_folder = 'assets/products/'.$medium_image;
    $large_image_tmp_name = $_FILES['large_image']['tmp_name'];
    $large_image_folder = 'assets/products/'.$large_image;

    $insert_query = mysqli_query($conn, "INSERT INTO `product` ( `item_name`, `item_brand`, `small_price`, `medium_price`, `large_price`, `item_image`, `small_image`, `medium_image`, `large_image`, `small_quantity`, `medium_quantity`, `large_quantity`, `item_register`) VALUES('$item_name', '$item_brand', '$small_price','$medium_price','$large_price', './assets/products/$item_image', './assets/products/$small_image', './assets/products/$medium_image', './assets/products/$large_image', '$small_quantity', '$medium_quantity', '$large_quantity', NOW())") or die('query failed');

    if($insert_query){
        move_uploaded_file($item_image_tmp_name, $item_image_folder);
        move_uploaded_file($small_image_tmp_name, $small_image_folder);
        move_uploaded_file($medium_image_tmp_name, $medium_image_folder);
        move_uploaded_file($large_image_tmp_name, $large_image_folder);
        $message[] = 'product add succesfully';
    }else{
        $message[] = 'could not add the product';
    }
};

if(isset($_GET['archive'])){
    $delete_id = $_GET['archive'];
    $archive_query = mysqli_query($conn, "INSERT INTO `archive_product` SELECT * FROM `product` WHERE item_id = '$delete_id' ") or die('query failed');
    $delete_query = mysqli_query($conn, "DELETE FROM `product` WHERE item_id = '$delete_id' ") or die('query failed');
    if($delete_query){
        $message[] = 'product has been archived';
    }else{
        $message[] = 'product could not be archived';
    };
};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_query = mysqli_query($conn, "DELETE FROM `product` WHERE item_id = '$delete_id' ") or die('query failed');
    if($delete_query){
        $message[] = 'product has been deleted';
    }else{
        $message[] = 'product could not be deleted';
    };
};

if(isset($_POST['update_product'])){
    $update_item_id = $_POST['update_item_id'];
    $update_item_name = $_POST['update_item_name'];
    $update_item_brand = $_POST['update_item_brand'];
    //$update_item_price = $_POST['update_item_price'];
    $update_small_price = $_POST['update_small_price'];
    $update_medium_price = $_POST['update_medium_price'];
    $update_large_price = $_POST['update_large_price'];
    //$update_item_quantity = $_POST['update_item_quantity'];
    $update_small_quantity = $_POST['update_small_quantity'];
    $update_medium_quantity = $_POST['update_medium_quantity'];
    $update_large_quantity = $_POST['update_large_quantity'];
    $update_item_image = $_FILES['update_item_image']['name'];
    $update_small_image = $_FILES['update_small_image']['name'];
    $update_medium_image = $_FILES['update_medium_image']['name'];
    $update_large_image = $_FILES['update_large_image']['name'];
    $update_item_reservation = $_POST['update_item_reservation'];
    $update_item_image_tmp_name = $_FILES['update_item_image']['tmp_name'];
    $update_item_image_folder = 'assets/products/'.$update_item_image;
    $update_small_image_tmp_name = $_FILES['update_small_image']['tmp_name'];
    $update_small_image_folder = 'assets/products/'.$update_small_image;
    $update_medium_image_tmp_name = $_FILES['update_medium_image']['tmp_name'];
    $update_medium_image_folder = 'assets/products/'.$update_medium_image;
    $update_large_image_tmp_name = $_FILES['update_large_image']['tmp_name'];
    $update_large_image_folder = 'assets/products/'.$update_large_image;

    $update_query = mysqli_query($conn, "UPDATE `product` SET item_name = '$update_item_name', item_brand = '$update_item_brand', small_price = '$update_small_price', medium_price = '$update_medium_price', large_price = '$update_large_price', small_quantity = '$update_small_quantity', medium_quantity = '$update_medium_quantity', large_quantity = '$update_large_quantity', item_reservation = '$update_item_reservation', item_image = './assets/products/$update_item_image', small_image = './assets/products/$update_small_image', medium_image = './assets/products/$update_medium_image', large_image = './assets/products/$update_large_image' WHERE item_id = '$update_item_id'");

    if($update_query){
        move_uploaded_file($update_item_image_tmp_name, $update_item_image_folder);
        $message[] = 'product updated successfully';
        //header('location: inventory.php');
        //exit();
    }else{
        $message[] = 'product could not be updated';
        //header('location: inventory.php');
    }

}

?>

<?php

if(isset($message)){
    foreach($message as $message){
        echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
    };
};

if(isset($_POST['search_submit'])){
    $_SESSION['search'] = $_POST['search'];
    $search = $_SESSION['search'];

    //header("Location: ");
}

?>

<?php

//include navbar.php file
include('./includes/navbar.php');
?>
<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Search -->
            <form method="post"
                  class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                           aria-label="Search" name="search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" name="search_submit" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                         aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small"
                                       placeholder="Search for..." aria-label="Search"
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $first_name; ?> <?php echo $last_name; ?></span>
                        <?php 
                            //$user_image = $_SESSION['username']->user_image;
                            if($user_image == "./assets/products/" || $user_image == ""){
                                echo '<img class="img-profile rounded-circle" src="./assets/LOGO.png" alt="User Image" width="80" height="80">';

                            }else{
                                echo '<img img class="img-profile rounded-circle" src="' . $user_image. '" style="border-radius: 50%;"  height="100" width="100" alt="">';
                                
                            }
                             
                        ?>
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                         aria-labelledby="userDropdown">

                        <a class="dropdown-item" href="register">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                            Admin and User
                        </a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->


    <!-- custom css file link  -->
    <link rel="stylesheet" href="./css/style.css">
<div class="container" style="width: 100%; height:99%;overflow: auto;">

        <section class="edit-form-container2">

            <?php

            if(isset($_GET['edit'])){
                $edit_id = $_GET['edit'];
                $edit_query = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id = $edit_id");
                if(mysqli_num_rows($edit_query) > 0){
                    while($fetch_edit = mysqli_fetch_assoc($edit_query)){
                        $reservation = $fetch_edit['item_reservation'];
                        ?>

                        <form action="" method="post" enctype="multipart/form-data">
                            <h3 style="color:black; text-align:center;">Edit a Product</h3>
                            <div class="" style="width:100px; height:100px; margin: auto; box-shadow:0px 0px 10px 3px grey; border: 2px solid #79B861;">
                                <img src="<?php echo $fetch_edit['item_image']; ?>"  height="100" width="100" alt="">
                            </div>
                            <input type="hidden" name="update_item_id" value="<?php echo $fetch_edit['item_id']; ?>">

                            <div class="form-row my-4">
                                <div class="col">
                                    <h6 style="color:black;">Product Name</h6>
                                    <input type="text" class="form-control" required name="update_item_name" value="<?php echo $fetch_edit['item_name']; ?>">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <h6 style="color:black;">Product Type</h6>
                                    <input type="hidden" list="brands" name="update_item_brand" placeholder="enter the product brand" class="box" required>
                                    <select id="brands" name="update_item_brand" class="form-control drop-down">
                                        <option value="Plants">Plants</option>
                                        <option value="Pots">Pots</option>
                                        <option value="Humic">Humic</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <h6 style="color:black;">Small Price</h6>
                                    <input type="number" min="0" class="form-control" required name="update_small_price" value="<?php echo $fetch_edit['small_price']; ?>">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <h6 style="color:black;">Medium Price</h6>
                                    <input type="number" min="0" class="form-control" required name="update_medium_price" value="<?php echo $fetch_edit['medium_price']; ?>">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <h6 style="color:black;">Large Price</h6>
                                    <input type="number" min="0" class="form-control" required name="update_large_price" value="<?php echo $fetch_edit['large_price']; ?>">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <h6 style="color:black;">Small Quantity</h6>
                                    <input type="number" min="0" class="form-control" required name="update_small_quantity" value="<?php echo $fetch_edit['small_quantity']; ?>">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <h6 style="color:black;">Medium Quantity</h6>
                                    <input type="number" min="0" class="form-control" required name="update_medium_quantity" value="<?php echo $fetch_edit['medium_quantity']; ?>">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <h6 style="color:black;">Large Quantity</h6>
                                    <input type="number" min="0" class="form-control" required name="update_large_quantity" value="<?php echo $fetch_edit['large_quantity']; ?>">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <h6 style="color:black;">Product Image</h6>
                                    <input type="file" class="form-control pt-3 pb-5" required name="update_item_image" accept="image/png, image/jpg, image/jpeg" value="<?php echo $fetch_edit['item_image'] ?>">
                                </div>
                            </div>
                            
                            <div class="form-row my-4">
                                <div class="col">
                                    <h6 style="color:black;">Small Image</h6>
                                    <input type="file" class="form-control pt-3 pb-5" required name="update_small_image" accept="image/png, image/jpg, image/jpeg" value="<?php echo $fetch_edit['item_image'] ?>">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <h6 style="color:black;">Medium Image</h6>
                                    <input type="file" class="form-control pt-3 pb-5" required name="update_medium_image" accept="image/png, image/jpg, image/jpeg" value="<?php echo $fetch_edit['item_image'] ?>">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <h6 style="color:black;">Large Image</h6>
                                    <input type="file" class="form-control pt-3 pb-5" required name="update_large_image" accept="image/png, image/jpg, image/jpeg" value="<?php echo $fetch_edit['item_image'] ?>">
                                </div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="update_item_reservation" value="Reservation" id="reserveCheckBox" <?php
                                if ($reservation  == "Reservation") {
                                    $checker = 'checked';
                                }else {
                                    $checker = 'unchecked';
                                }
                                echo $checker;
                                ?>>
                                <input type="hidden" id="reserveValue" value="0" name="update_item_reservation">
                                <label class="form-check-label" name="update_item_reservation" for="reserveCheckBox">
                                    Reservation
                                </label>
                            </div>
                            <button type="submit" value="Update Product" name="update_product" class="btn-update3 offset-lg-3">Update Product </button>


                            <br>
                            <a href="inventory" id="close-edit" class="option-btn3 text-white offset-lg-3" style="text-decoration: none">Cancel </a>
                        </form>

                        <?php
                    };
                };
                echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";

            };
            ?>

        </section>


            <?php

            if(isset($_GET['edit'])) {

            }elseif(isset($_GET['add'])){

                ?>
                <div class=" justify-content-center" style="margin-top: -70px;">
                    <form action="inventory" method="post" class="add-product-form" enctype="multipart/form-data">
                        <h3>Add a New Product</h3>
                        <div class="input-group">
                            <div class="col">
                                <h6 class="text-dark">Product Name</h6>
                                <input type="text" name="item_name" placeholder="Enter the product name" class="box" required>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col">
                                <h6 class="text-dark">Product Type</h6>
                                <input type="hidden" list="brands" name="item_brand" placeholder="enter the product brand" class="box" required>
                                <select id="brands" name="item_brand" class="box drop-down">
                                    <option value="Plants">Plants</option>
                                    <option value="Pots">Pots</option>
                                    <option value="Humic">Humic</option>
                                </select>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col">
                                <h6 class="text-dark">Small Price</h6>
                                <input type="number" name="small_price" min="1" placeholder="Enter the product small price" class="box" required>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col">
                                <h6 class="text-dark">Medium Price</h6>
                                <input type="number" name="medium_price" min="1" placeholder="Enter the product medium price" class="box" required>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col">
                                <h6 class="text-dark">Large Price</h6>
                                <input type="number" name="large_price" min="1" placeholder="Enter the product large price" class="box" required>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col">
                                <h6 class="text-dark">Small Quantity</h6>
                                <input type="number" name="small_quantity" min="0" pattern="[0-9]" placeholder="Enter the quantity of small product" class="box" required>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col">
                                <h6 class="text-dark">Medium Quantity</h6>
                                <input type="number" name="medium_quantity" min="0" pattern="[0-9]" placeholder="Enter the quantity of medium product" class="box" required>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col">
                                <h6 class="text-dark">Large Quantity</h6>
                                <input type="number" name="large_quantity" min="0" pattern="[0-9]" placeholder="Enter the quantity of large product" class="box" required>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col">
                                <h6 class="text-dark">Product Image</h6>
                                <input type="file" name="item_image" accept="image/png, image/jpg, image/jpeg" class="box drop-down" required>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col">
                                <h6 class="text-dark">Small Image</h6>
                                <input type="file" name="small_image" accept="image/png, image/jpg, image/jpeg" class="box drop-down" required>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col">
                                <h6 class="text-dark">Medium Image</h6>
                                <input type="file" name="medium_image" accept="image/png, image/jpg, image/jpeg" class="box drop-down" required>
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="col">
                                <h6 class="text-dark">Large Image</h6>
                                <input type="file" name="large_image" accept="image/png, image/jpg, image/jpeg" class="box drop-down" required>
                            </div>
                        </div>


                        <div class="input-group form-row my-4">
                            <div class="col">
                                <input type="hidden" value="add the product" name="add_product" class="btn">
                                <button type="submit" name="add_product" class="btn-update3 offset-lg-3">Add Product</button>
                                <a href="inventory" id="close-edit" class="option-btn3 text-white offset-lg-3" style="text-decoration: none">Cancel </a>
                                
                            </div>
                        </div>
                    </form>
                </div>

                <?php

                //echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";

            }else{
                
            ?>

<div class="container">
    <section class="display-product-table">
            <h1 class="text-center" style="margin-top: -50px; padding-bottom: 40px; color: black;"><b>Products</b></h1>
            <a href="inventory?add" class="btn2 text-white" style="text-decoration: none; margin-bottom: 10px;"> <i class="fas fa-edit"></i> Add Product </a>
        <table>

            <thead>
            <th>Product Image</th>
            <th>Product Name</th>
            <th>Product Brand</th>
            <th>Product Price</th>
            <th>Quantity</th>
            <th>Reservation</th>
            <th>Action</th>
            </thead>

            <tbody>
            <?php

            if(isset($search)){
                $select_products = mysqli_query($conn, "SELECT * FROM `product` WHERE item_name LIKE '%$search%' or item_brand LIKE '%$search%' or item_reservation LIKE '%$search%' or small_price LIKE '%$search%' or medium_price LIKE '%$search%' or large_price LIKE '%$search%' or small_quantity LIKE '%$search%' or medium_quantity LIKE '%$search%' or large_quantity LIKE '%$search%' or item_quantity LIKE '%$search%'");
                $i = 0;
                if(mysqli_num_rows($select_products) > 0){
                    while($row = mysqli_fetch_assoc($select_products)){
                        $reservation = $row['item_reservation'];
                        ?>

                        <tr>
                            <td style="">
                            <?php 
                                
                                $i++;
                            ?>
                                <div id="carouselExampleControls-<?= $i ?>" class="carousel slide" data-bs-interval="false" style="width:100px; height:100px; margin: auto; box-shadow:0px 0px 10px 3px grey; border: 2px solid #79B861;">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="./<?php echo $row['item_image']; ?>" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="./<?php echo $row['small_image']; ?>" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="./<?php echo $row['medium_image']; ?>" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="./<?php echo $row['large_image']; ?>" class="d-block w-100" alt="...">
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls-<?= $i ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls-<?= $i ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </td>
                    <td><?php echo $row['item_name']; ?></td>
                    <td><?php echo $row['item_brand'] ?></td>
                    <td>₱<?php echo $row['small_price'] . PHP_EOL . "S<br>₱" . $row['medium_price'] . PHP_EOL . "M<br>₱" . $row['large_price'] . PHP_EOL . "L"; ?></td>
                    <td><?php echo $row['small_quantity'] . PHP_EOL . "S<br>" . $row['medium_quantity'] . PHP_EOL . "M<br>" . $row['large_quantity']. PHP_EOL . "L";?></td>
                    <td>
                        <input class="" type="checkbox" disabled value="" id="flexCheckDefault"
                            <?php
                            if ($reservation  == "Reservation") {
                                $checker = 'checked';
                            }else {
                                $checker = 'unchecked';
                            }
                            echo $checker;
                            ?>>
                    </td>
                    <td>
                        <a href="inventory?edit=<?php echo $row['item_id']; ?>" class="btn2 text-white" style="text-decoration: none; margin-bottom: 10px;"> <i class="fas fa-edit"></i> Update </a>
                        <a href="inventory?archive=<?php echo $row['item_id']; ?>" class="btn2 text-white" style="text-decoration: none; margin-bottom: 10px; background-color: orange;" onclick="return confirm('are your sure you want to archive this?');"> <i class="fas fa-archive"></i> Archive </a>
                        <a href="inventory?delete=<?php echo $row['item_id']; ?>" class="delete-btn text-white" style="text-decoration: none" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> Delete </a>
                    </td>
                </tr>

                <?php
                };
                }else{
                    echo "<div class='empty'>no product added</div>";
                };
            ?>
            <?php
            }else{
                $select_products = mysqli_query($conn, "SELECT * FROM `product`");
                $i = 0;
                if(mysqli_num_rows($select_products) > 0){
                    while($row = mysqli_fetch_assoc($select_products)){
                        $reservation = $row['item_reservation'];
                        ?>

                        <tr>
                            <td style="">
                            <?php 
                                
                                $i++;
                            ?>
                            <div id="carouselExampleControls-<?= $i ?>" class="carousel slide" data-bs-interval="false" style="width:100px; height:100px; margin: auto; box-shadow:0px 0px 10px 3px grey; border: 2px solid #79B861;">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="./<?php echo $row['item_image']; ?>" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="./<?php echo $row['small_image']; ?>" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="./<?php echo $row['medium_image']; ?>" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="./<?php echo $row['large_image']; ?>" class="d-block w-100" alt="...">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls-<?= $i ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls-<?= $i ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>

                            
                            <?php 
                                
                            ?>
                            </td>
                            <td><?php echo $row['item_name']; ?></td>
                            <td><?php echo $row['item_brand'] ?></td>
                            <td>₱<?php echo $row['small_price'] . PHP_EOL . "S<br>₱" . $row['medium_price'] . PHP_EOL . "M<br>₱" . $row['large_price'] . PHP_EOL . "L"; ?></td>
                            <td><?php echo $row['small_quantity'] . PHP_EOL . "S<br>" . $row['medium_quantity'] . PHP_EOL . "M<br>" . $row['large_quantity']. PHP_EOL . "L";?></td>
                            <td>
                                <input class="" type="checkbox" disabled value="" id="flexCheckDefault"
                                    <?php
                                    if ($reservation  == "Reservation") {
                                        $checker = 'checked';
                                    }else {
                                        $checker = 'unchecked';
                                    }
                                    echo $checker;
                                    ?>>
                            </td>
                            <td>
                            <a href="inventory?edit=<?php echo $row['item_id']; ?>" class="btn2 text-white" style="text-decoration: none; margin-bottom: 10px;"> <i class="fas fa-edit"></i> Update </a>
                            <a href="inventory?archive=<?php echo $row['item_id']; ?>" class="btn2 text-white" style="text-decoration: none; margin-bottom: 10px; background-color: orange;" onclick="return confirm('are your sure you want to archive this?');"> <i class="fas fa-archive"></i> Archive </a>
                            <a href="inventory?delete=<?php echo $row['item_id']; ?>" class="delete-btn text-white" style="text-decoration: none" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> Delete </a>
                            </td>
                        </tr>

                        <?php
                    };
                }else{
                    echo "<div class='empty'>No Product Added</div>";
                };
            }

            ?>
            </tbody>
        </table>

    </section>
</div> 
    <?php
        }
    ?>

</div>

</div>

<!-- custom js file link  -->

<?php

//include scripts.php file
include('./includes/scripts.php');
?>

<?php

//include footer.php file
include('./includes/footer.php');
?>

