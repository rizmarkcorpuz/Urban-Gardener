<?php
ob_start();
//include header.php file
include ('header.php');

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

?>

<div class="container" style="margin-top: 100px;">
    <br>
    <h1 class="text-center" style="font-size: 80px;">ABOUT US</h1><br>
    <p style="font-size: 30px;">With our love for plants, Deseree Custodio and Mark Lloyd Montiel started an online plant-selling business. Urban gardener started September 07, 2020. Urban Gardener is currently located at 413 Padre Pio St., Caridad, Cavite City, Barangay 22-A Leo.</p>


</div>



</main>
<!-- !start #main-site -->

<style>
    footer {
        position: fixed;
        height: 250px;
        bottom: 0;
        width: 100%;
    }
</style>
<!-- start #footer -->
<footer id="footer" class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">

            <div class="col-lg-3 col-12">
                <img src="./assets/LOGO.png" alt="img1" class="img-fluid" style="width: 150px;">
            </div>

            <div class="col-lg-3 col-12">
                <h4 class="font-eduvic font-size-24">Urban Gardener</h4>
                <p class="font-size-14 font-rale text-white-50">Since 2020</p>
            </div>



            <div class="col-lg-1 col-2">

            </div>
            <div class="col-lg-3 col-12">
                <h4 class="font-eduvic font-size-24">Information</h4>
                <div class="d-flex flex-column flex-wrap">
                    <a href="About_Us" class="font-rale font-size-14 text-white-50 pb-1">About Us</a>
                    <a href="Delivery_Information" class="font-rale font-size-14 text-white-50 pb-1">Delivery Information</a>
                    <a href="Privacy_Policy" class="font-rale font-size-14 text-white-50 pb-1">Privacy Policy</a>
                    <a href="Terms_And_Condition" class="font-rale font-size-14 text-white-50 pb-1">Terms & Conditions</a>
                </div>
            </div>
            <div class="col-lg-2 col-12">
                <h4 class="font-eduvic font-size-24">Account</h4>
                <div class="d-flex flex-column flex-wrap">
                    <a href="welcome" class="font-rale font-size-14 text-white-50 pb-1">My Account</a>
                    <a href="Welcome" class="font-rale font-size-14 text-white-50 pb-1">Order History</a>
                    <a href="cart" class="font-rale font-size-14 text-white-50 pb-1">Cart</a>
                    <a href="reservation" class="font-rale font-size-14 text-white-50 pb-1">Reservation Cart</a>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright text-center bg-dark text-white py-2">
        <p class="font-rale font-size-14">&copy; Copyrights 2022. Design By <a href="#" class="color-second">Mark Loyd Montiel & Deseree Custodio</a></p>
    </div>
</footer>

<!-- !start #footer -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<!-- Owl Carousel Js file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!--  isotope plugin cdn  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha256-CBrpuqrMhXwcLLUd5tvQ4euBHCdh7wGlDfNz8vbu/iI=" crossorigin="anonymous"></script>

<!-- Custom Javascript -->
<script src="./index.js"></script>
</body>
</html>