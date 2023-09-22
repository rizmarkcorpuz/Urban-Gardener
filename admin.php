<?php

@include 'config.php';

if(isset($_POST['add_product'])){
    $item_name = $_POST['item_name'];
    $item_brand = $_POST['item_brand'];
    $item_price = $_POST['item_price'];
    $item_quantity = $_POST['item_quantity'];
    $item_image = $_FILES['item_image']['name'];
    $item_image_tmp_name = $_FILES['item_image']['tmp_name'];
    $item_image_folder = 'assets/products/'.$item_image;

    $insert_query = mysqli_query($conn, "INSERT INTO `product` ( `item_name`, `item_brand`, `item_price`, `item_image`, `item_quantity`, `item_register`) VALUES('$item_name', '$item_brand', '$item_price', './assets/products/$item_image',  '$item_quantity', NOW())") or die('query failed');

    if($insert_query){
        move_uploaded_file($item_image_tmp_name, $item_image_folder);
        $message[] = 'product add succesfully';
    }else{
        $message[] = 'could not add the product';
    }
};

    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_query = mysqli_query($conn, "DELETE FROM `product` WHERE item_id = '$delete_id' ") or die('query failed');
        if($delete_query){
            header('location:admin.php');
            $message[] = 'product has been deleted';
        }else{
            header('location:admin.php');
            $message[] = 'product could not be deleted';
        };
    };

if(isset($_POST['update_product'])){
    $update_item_id = $_POST['update_item_id'];
    $update_item_name = $_POST['update_item_name'];
    $update_item_brand = $_POST['update_item_brand'];
    $update_item_price = $_POST['update_item_price'];
    $update_item_quantity = $_POST['update_item_quantity'];
    $update_item_image = $_FILES['update_item_image']['name'];
    $update_item_image_tmp_name = $_FILES['update_item_image']['tmp_name'];
    $update_item_image_folder = 'assets/products/'.$update_item_image;

    $update_query = mysqli_query($conn, "UPDATE `product` SET item_name = '$update_item_name', item_brand = '$update_item_brand', item_price = '$update_item_price', item_quantity = '$update_item_quantity', item_image = './assets/products/$update_item_image' WHERE item_id = '$update_item_id'");

    if($update_query){
        move_uploaded_file($update_item_image_tmp_name, $update_item_image_folder);
        $message[] = 'product updated succesfully';
        header('location:admin.php');
    }else{
        $message[] = 'product could not be updated';
        header('location:admin.php');
    }

}

?>

<?php

if(isset($message)){
    foreach($message as $message){
        echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
    };
};

?>

<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin panel</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="./style.css">

</head>
<body>

<div class="container">

    <section>
        <div class="d-flex justify-content-center">
            <form action="admin.php" method="post" class="add-product-form" enctype="multipart/form-data">
                <h3>Add a New Product</h3>
                <div class="input-group">
                    <div class="col">
                        <input type="text" name="item_name" placeholder="Enter the product name" class="box" required>
                    </div>
                </div>

                <div class="input-group">
                    <div class="col">
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
                        <input type="number" name="item_price" min="0" placeholder="Enter the product price" class="box" required>
                    </div>
                </div>

                <div class="input-group">
                    <div class="col">
                        <input type="number" name="item_quantity" min="0" placeholder="Enter the product quantity" class="box" required>
                    </div>
                </div>

                <div class="input-group form-row my-4">
                    <div class="col">
                        <input type="file" name="item_image" accept="image/png, image/jpg, image/jpeg" class="box drop-down" required>
                    </div>
                </div>


                <div class="input-group form-row my-4">
                    <div class="col">
                        <input type="hidden" value="add the product" name="add_product" class="btn">
                        <button type="submit" name="add_product" class="btn2 px-5">Add Product</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

</div>

<div class="container">
    <section class="display-product-table">

        <table>

            <thead>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Product Brand</th>
                    <th>Product Price</th>
                    <th>Product Quantity</th>
                    <th>Action</th>
            </thead>

            <tbody>
            <?php

            $select_products = mysqli_query($conn, "SELECT * FROM `product`");
            if(mysqli_num_rows($select_products) > 0){
                while($row = mysqli_fetch_assoc($select_products)){
                    ?>

                    <tr>
                        <td><img src="./<?php echo $row['item_image']; ?>" height="100" alt=""></td>
                        <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['item_brand'] ?></td>
                        <td>₱<?php echo $row['item_price']; ?></td>
                        <td><?php echo $row['item_quantity'] ?></td>
                        <td>
                            <a href="admin.php?delete=<?php echo $row['item_id']; ?>" class="delete-btn text-white" style="text-decoration: none" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> Delete </a>
                            <a href="admin.php?edit=<?php echo $row['item_id']; ?>" class="option-btn text-white" style="text-decoration: none"> <i class="fas fa-edit"></i> Update </a>
                        </td>
                    </tr>

                    <?php
                };
            }else{
                echo "<div class='empty'>no product added</div>";
            };
            ?>
            </tbody>
        </table>

    </section>
</div>
    <section class="edit-form-container">

        <?php

        if(isset($_GET['edit'])){
            $edit_id = $_GET['edit'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `product` WHERE item_id = $edit_id");
            if(mysqli_num_rows($edit_query) > 0){
                while($fetch_edit = mysqli_fetch_assoc($edit_query)){
                    ?>

                    <form action="" method="post" enctype="multipart/form-data">
                        <h3>Edit a Product</h3>
                        <img src="assets/products/<?php echo $fetch_edit['item_image']; ?>" height="200" alt="">
                        <input type="hidden" name="update_item_id" value="<?php echo $fetch_edit['item_id']; ?>">
                        <input type="text" class="box" required name="update_item_name" value="<?php echo $fetch_edit['item_name']; ?>">
                        <input type="hidden" list="brands" name="update_item_brand" placeholder="enter the product brand" class="box" required>
                        <select id="brands" name="update_item_brand" class="box drop-down">
                            <option value="Plants">Plants</option>
                            <option value="Pots">Pots</option>
                            <option value="Humic">Humic</option>
                        </select>
                        <input type="number" min="0" class="box" required name="update_item_price" value="<?php echo $fetch_edit['item_price']; ?>">
                        <input type="number" min="0" class="box" required name="update_item_quantity" value="<?php echo $fetch_edit['item_quantity']; ?>">
                        <input type="file" class="box drop-down" required name="update_item_image" accept="image/png, image/jpg, image/jpeg" value="<?php echo $fetch_edit['item_image'] ?>">
                        <input type="submit" value="Update Product" name="update_product" class="btn-update">
                        <br>
                        <a href="admin.php" id="close-edit" class="option-btn3 text-white offset-lg-3" style="text-decoration: none">Cancel </a>
                    </form>

                    <?php
                };
            };
            echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";

        };
        ?>

    </section>








<!-- custom js file link  -->
<script src="./index.php"></script>

</body>
</html>

<?php
//include footer.php file
include('footer.php')
?>