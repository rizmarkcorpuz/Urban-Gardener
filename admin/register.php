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



if (isset($_POST['submit'])) {
    $firstname = $_POST['register_first_name'];
    $lastname = $_POST['register_last_name'];
    $contact_number = $_POST['register_contact_number'];
    $billing_address = $_POST['register_billing_address'];
    $user_image = $_FILES['register_user_image']['name'];
    $user_image_tmp_name = $_FILES['register_user_image']['tmp_name'];
    $user_image_folder = 'assets/products/'. $user_image;
    //$mode_of_payment = $_POST['register_mode_of_payment'];
    $username = $_POST['register_username'];
    $email = $_POST['register_email'];
    $password = hash('sha256', $_POST['register_password']);
    $cpassword = hash('sha256', $_POST['register_cpassword']);


    if ($password == $cpassword){
        $sql = "SELECT * FROM user WHERE email='$email' or username='$username'";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0){
            echo "<script>alert('Woops! Email or Username Already Exists.')</script>";
        }elseif (!$result->num_rows > 0){
            $sql = "INSERT INTO user (first_name, last_name, contact_number, billing_address, user_image, username, email, password, user_type)
					VALUES ('$firstname', '$lastname', '$contact_number', '$billing_address', './assets/products/$user_image', '$username', '$email', '$password', 32)";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                move_uploaded_file($user_image_tmp_name, $user_image_folder);
                echo "<script>alert('User Registration Completed.')</script>";
                $firstname = "";
                $lastname = "";
                $contact_number = "";
                $billing_address = "";
                $username = "";
                $email = "";
                $_POST['password'] = "";
                $_POST['cpassword'] = "";
            }else{
                echo "<script>alert('Woops! Something Wrong Went.')</script>";
            }

        }

    }else{
        echo "<script>alert('Password Not Matched.')</script>";
    }

}

if(isset($_POST['search_submit'])){
    $_SESSION['search'] = $_POST['search'];
    $search = $_SESSION['search'];

    //header("Location: ");
}

if(isset($_POST['search_user_submit'])){
    $_SESSION['search_user'] = $_POST['search_user'];
    $search_user = $_SESSION['search_user'];

    //header("Location: ");
}

if(isset($_POST['edit_id'])){
    $user_id = $_POST['edit_id'];
}

if(isset($_POST['delete_btn'])){

    $user_id = $_POST['delete_id'];

    $query = "DELETE FROM user WHERE user_id='$user_id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
        $_SESSION['status'] = "Your Data is Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: register');
    }else{
        $_SESSION['status'] = "Your Data is NOT DELETED";
        $_SESSION['status_code'] = "error";
        header('Location: register');
    }
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


<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Admin Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">

                <div class="modal-body">

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="text" placeholder="First Name" name="register_first_name" id="FirstName" value=""required class="form-control">
                        </div>
                    </div>
                    <div class="form-row my-4">
                        <div class="col">
                            <input type="text" placeholder="Last Name" name="register_last_name" id="LastName" value=""required class="form-control">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="text" placeholder="Contact Number" name="register_contact_number" pattern="^[0-9]{6}|[0-9]{8}|[0-9]{11}$" id="ContactNumber" value=""required class="form-control">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="text" placeholder="Billing Address" name="register_billing_address" id="BillingAddress" value=""required class="form-control">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="file" class="form-control pt-3 pb-5" placeholder="Admin Image" name="register_user_image" accept="image/png, image/jpg, image/jpeg" value="" class="form-control">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="text" placeholder="Username" name="register_username" value="" required class="form-control">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="email" placeholder="Email*" name="register_email" value="" required class="form-control">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="password" placeholder="Password" name="register_password" value="" required class="form-control">
                        </div>
                    </div>

                    <div class="form-row my-4">
                        <div class="col">
                            <input type="password" placeholder="Confirm Password*" name="register_cpassword" value="" required class="form-control">
                            <small id="confirm_error" class="text-danger"></small>
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



<div class="container" style="width: 1300px; height: 620px;overflow: auto;">
<div class="container-fluid">

<!-- Topbar Search -->
        <form method="post"
                class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-dark border-0 small" placeholder="Search admin..."
                           aria-label="Search" name="search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" name="search_submit" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
                 <br>
            </form>


    <div class="card shadow mb-4" >
        <div class="card-header py-3">
            <h6 class="mt-3 font-weight-bold text-primary text-left position-absolute">Admin Profile </h6>
            <div class="col-12 text-right">
                <button style="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">Add Admin Profile</button>
            </div>
        </div>



        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Contact Number</th>
                            <th>Billing Address</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(isset($search)){
                        $search = $_SESSION['search'];
                        $admin_query = mysqli_query($conn, "SELECT * FROM user WHERE user_id LIKE '%$search%' AND user_type = 32 or first_name LIKE '%$search%' AND user_type = 32 or last_name LIKE '%$search%' AND user_type = 32 or contact_number LIKE '%$search%' AND user_type = 32 or billing_address LIKE '%$search%' AND user_type = 32 or  username LIKE '%$search%' AND user_type = 32 or email LIKE '%$search%' AND user_type = 32");
                        if(mysqli_num_rows($admin_query) > 0)
                        {
                            while($row = mysqli_fetch_assoc($admin_query))
                            {
                                ?>
                                <tr>
                                    <td><?php  echo $row['user_id']; ?></td>
                                    <td><?php  echo $row['first_name']; ?></td>
                                    <td><?php  echo $row['last_name']; ?></td>
                                    <td><?php  echo $row['contact_number']; ?></td>
                                    <td><?php  echo $row['billing_address']; ?></td>
                                    <td><?php  echo $row['username']; ?></td>
                                    <td><?php  echo $row['email']; ?></td>
                                    <td>
                                        <form action="register-edit" method="post">
                                            <input type="hidden" name="edit_id" value="<?php echo $row['user_id']; ?>">
                                            <button type="submit" name="edit_btn" class="btn btn-success"> EDIT</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="delete_id" value="<?php echo $row['user_id']; ?>">
                                            <button type="submit" name="delete_btn" class="btn btn-danger" onclick="return confirm('Are your sure you want to Delete this?');"> DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        else {
                            echo "No Record Found";
                        }
                    }else{
                        $sql = "SELECT * FROM user WHERE user_type = 32";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0)
                        {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                ?>
                                <tr>
                                    <td><?php  echo $row['user_id']; ?></td>
                                    <td><?php  echo $row['first_name']; ?></td>
                                    <td><?php  echo $row['last_name']; ?></td>
                                    <td><?php  echo $row['contact_number']; ?></td>
                                    <td><?php  echo $row['billing_address']; ?></td>
                                    <td><?php  echo $row['username']; ?></td>
                                    <td><?php  echo $row['email']; ?></td>
                                    <td>
                                        <form action="register-edit" method="post">
                                            <input type="hidden" name="edit_id" value="<?php echo $row['user_id']; ?>">
                                            <button type="submit" name="edit_btn" class="btn btn-success"> EDIT</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="delete_id" value="<?php echo $row['user_id']; ?>">
                                            <button type="submit" name="delete_btn" class="btn btn-danger" onclick="return confirm('Are your sure you want to Delete this?');"> DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        else {
                            echo "No Record Found";
                        }
                    }
                    
                    ?>
                    </tbody>
        </table>
    </div>
</div>
</div>
</div>

<div class="container-fluid">

    <!-- Topbar Search -->
            <form method="post"
                class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-dark border-0 small" placeholder="Search user..."
                           aria-label="Search" name="search_user" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" name="search_user_submit" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
                <br>
            </form>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Profile</h6>

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Contact Number</th>
                                <th>Billing Address</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($search_user)){
                                $search_user = $_SESSION['search_user'];
                                $user_query = mysqli_query($conn, "SELECT * FROM user WHERE user_id LIKE '%$search_user%' AND user_type = 1 or first_name LIKE '%$search_user%' AND user_type = 1 or last_name LIKE '%$search_user%' AND user_type = 1 or contact_number LIKE '%$search_user%' AND user_type = 1 or billing_address LIKE '%$search_user%' AND user_type = 1 or  username LIKE '%$search_user%' AND user_type = 1 or email LIKE '%$search_user%' AND user_type = 1");
                                if(mysqli_num_rows($user_query) > 0)
                                {
                                    while($row = mysqli_fetch_assoc($user_query))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php  echo $row['user_id']; ?></td>
                                            <td><?php  echo $row['first_name']; ?></td>
                                            <td><?php  echo $row['last_name']; ?></td>
                                            <td><?php  echo $row['contact_number']; ?></td>
                                            <td><?php  echo $row['billing_address']; ?></td>
                                            <td><?php  echo $row['username']; ?></td>
                                            <td><?php  echo $row['email']; ?></td>
                                            <td>
                                                <form action="register-edit" method="post">
                                                    <input type="hidden" name="edit_id" value="<?php echo $row['user_id']; ?>">
                                                    <button type="submit" name="edit_btn" class="btn btn-success"> EDIT</button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="hidden" name="delete_id" value="<?php echo $row['user_id']; ?>">
                                                    <button type="submit" name="delete_btn" class="btn btn-danger" onclick="return confirm('Are your sure you want to Delete this?');"> DELETE</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                else {
                                    echo "No Record Found";
                                }
                            }else{
                                $sql = "SELECT * FROM user WHERE user_type = 1";
                                $result = mysqli_query($conn, $sql);
                                if(mysqli_num_rows($result) > 0)
                                {
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        ?>
                                        <tr>
                                            <td><?php  echo $row['user_id']; ?></td>
                                            <td><?php  echo $row['first_name']; ?></td>
                                            <td><?php  echo $row['last_name']; ?></td>
                                            <td><?php  echo $row['contact_number']; ?></td>
                                            <td><?php  echo $row['billing_address']; ?></td>
                                            <td><?php  echo $row['username']; ?></td>
                                            <td><?php  echo $row['email']; ?></td>
                                            <td>
                                                <form action="register-edit" method="post">
                                                    <input type="hidden" name="edit_id" value="<?php echo $row['user_id']; ?>">
                                                    <button type="submit" name="edit_btn" class="btn btn-success"> EDIT</button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="hidden" name="delete_id" value="<?php echo $row['user_id']; ?>">
                                                    <button type="submit" name="delete_btn" class="btn btn-danger" onclick="return confirm('Are your sure you want to Delete this?');"> DELETE</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                else {
                                    echo "No Record Found";
                                }
                            }
                            
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

</div>
</div>

<?php

//include scripts.php file
include('./includes/scripts.php');
?>

<?php

//include footer.php file
include('./includes/footer.php');
?>
