<?php
//include header.php file
include ('./includes/header.php');

?>

<?php
include ('./config.php');

//error_reporting(0);

//print_r($_SESSION);
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



if(isset($_POST['see_orders'])){
    $user_id = $_POST['user_id'];
    $_SESSION['supplier_id'] = $_POST['user_id'];
    header("Location: message-supplier");
}

if (isset($_POST['submit'])) {
    $firstname = $_POST['supplier_first_name'];
    $lastname = $_POST['supplier_last_name'];
    $contact_number = $_POST['supplier_contact_number'];
    $billing_address = $_POST['supplier_billing_address'];
    $email = $_POST['supplier_register_email'];
    $username = $_POST['supplier_username'];


        $sql = "SELECT * FROM user WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0){
            echo "<script>alert('Woops! Supplier Already Exists.')</script>";
        }elseif (!$result->num_rows > 0){
            $sql = "INSERT INTO `supplier` (first_name, last_name, contact_number, billing_address, email, username)
					VALUES ('$firstname', '$lastname', '$contact_number', '$billing_address', '$email', '$username')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('User Registration Completed.')</script>";
                $firstname = "";
                $lastname = "";
                $contact_number = "";
                $billing_address = "";
                $mode_of_payment = "";
                $username = "";

            }else{
                echo "<script>alert('Woops! Something Wrong Went.')</script>";
            }

        }

}

if(isset($_POST['search_submit'])){
    $_SESSION['search'] = $_POST['search'];
    $search = $_SESSION['search'];

    //header("Location: ");
}

?>



<?php

//include navbar.php file
include('./includes/navbar.php')
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

        <div class="modal fade" id="addsupplierprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Supplier Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST">

                        <div class="modal-body">

                            <div class="form-row my-4">
                                <div class="col">
                                    <input type="text" placeholder="First Name" name="supplier_first_name" id="FirstName" value=""required class="form-control">
                                </div>
                            </div>
                            <div class="form-row my-4">
                                <div class="col">
                                    <input type="text" placeholder="Last Name" name="supplier_last_name" id="LastName" value=""required class="form-control">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <input type="text" placeholder="Contact Number" name="supplier_contact_number" pattern="^[0-9]{6}|[0-9]{8}|[0-9]{11}$" id="ContactNumber" value=""required class="form-control">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <input type="text" placeholder="Billing Address" name="supplier_billing_address" id="BillingAddress" value=""required class="form-control">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <input type="email" placeholder="Email*" name="supplier_register_email" value="" required class="form-control">
                                </div>
                            </div>

                            <div class="form-row my-4">
                                <div class="col">
                                    <input type="text" placeholder="Username" name="supplier_username" value="" required class="form-control">
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>




        <!--  Pending Orders   -->
        <div class="container py-1" style="position: relative;">
            <h4 class="font-eduvic font-size-24" style="color:black;">Supplier</h4>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addsupplierprofile">Add Supplier Profile</button>
            <div class="sorts">
            Sort by: <select name="fetchsupplier" id="fetchsupplier" >
                <option value="" disabled="" selected="">Select Filter</option>
                <option value="Username">Username</option>
                <option value="ID">ID</option>
                <option value="First Name">First Name</option>
                <option value="Last Name">Last Name</option>
                <option value="A-Z">A-Z</option>
                <option value="Z-A">Z-A</option>
            </select>
            </div>
            <hr>
        </div>
        <div class="containers py-1" style="width: 1300px; height: 510px;overflow: auto;">

            <div class="container py-1 my-1 ">
                <div class="row  font-rale">

                    <?php

                    if(isset($search)){
                        $checkout_query = mysqli_query($conn, "SELECT user_id FROM `supplier` WHERE first_name LIKE '%$search%' or last_name LIKE '%$search%' or user_id LIKE '%$search%' or username LIKE '%$search%' ORDER BY user_id") or die('query failed');
                        $grand_total = 0;
                        if(mysqli_num_rows($checkout_query) > 0){
                        while($fetch_checkout = mysqli_fetch_assoc($checkout_query)){
                        $user_id = $fetch_checkout['user_id'];

                        $user_query = mysqli_query($conn, "SELECT * FROM `supplier` WHERE user_id = '$user_id'");
                        while($fetch_user = mysqli_fetch_assoc($user_query)){
                        $first_name = $fetch_user['first_name'];
                        $last_name = $fetch_user['last_name'];
                        $username = $fetch_user['username'];
                        $email = $fetch_user['email'];
                        $contact_number = $fetch_user['contact_number'];
                        $billing_address = $fetch_user['billing_address'];
                        ?>

                        <div class="col-auto order-pending">

                        <div class="order-number" style="padding: 10px 10px 0px 10px; background-color: green; color: white;">
                            <h5 style="text-align: center;">Supplier Username: <?php echo $username; ?></h5><br>
                        </div>
                        <div class="order-body">
                            <h6>Supplier Name: <?php echo $first_name . " ".$last_name; ?></h6><br>
                            <h6>Email: <?php echo $email; ?></h6> <br>
                            <h6>Address: <?php echo $billing_address; ?></h6> <br>
                            <h6>Contact Number: <?php echo $contact_number; ?></h6>
                        </div>

                            <?php
                            }
                            ?>

                            <div class="container w-75 " style="text-align: center; padding: 20px; margin-left:30px; position: absolute; bottom: 0px; ">
                                <form action="message-supplier" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo $fetch_checkout['user_id'] ?? '1' ?>">
                                    <button type="submit"  name="see_orders" class="btn btn-success" >Send a message</button>

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
                        $checkout_query = mysqli_query($conn, "SELECT user_id FROM `supplier` ORDER BY user_id") or die('query failed');
                        $grand_total = 0;
                        if(mysqli_num_rows($checkout_query) > 0){
                            while($fetch_checkout = mysqli_fetch_assoc($checkout_query)){
                                $user_id = $fetch_checkout['user_id'];

                                $user_query = mysqli_query($conn, "SELECT * FROM `supplier` WHERE user_id = '$user_id'");
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
                                        <h5 style="text-align: center;">Supplier Username: <?php echo $username; ?></h5><br>
                                    </div>
                                    <div class="order-body">
                                        <h6>Supplier Name: <?php echo $first_name . " ".$last_name; ?></h6><br>
                                        <h6>Email: <?php echo $email; ?></h6> <br>
                                        <h6>Address: <?php echo $billing_address; ?></h6> <br>
                                        <h6>Contact Number: <?php echo $contact_number; ?></h6>
                                    </div>




                                    <?php
                                }


                                ?>





                                <div class="container w-75 " style="text-align: center; padding: 20px; margin-left:30px; position: absolute; bottom: 0px; ">
                                    <form action="message-supplier" method="post">
                                        <input type="hidden" name="user_id" value="<?php echo $fetch_checkout['user_id'] ?? '1' ?>">
                                        <button type="submit"  name="see_orders" class="btn btn-success" >Send a message</button>

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

                </div>
            </div>
        </div>
    </div>


    <!--- !Pending Orders --->



    <?php

    //include scripts.php file
    include('./includes/scripts.php')
    ?>

    <?php

    //include footer.php file
    include('./includes/footer.php')
    ?>
