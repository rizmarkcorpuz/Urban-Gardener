</main>
<!-- !start #main-site -->

<!-- start #footer -->
<footer id="footer" class="bg-dark text-white py-5" style="margin-top: auto">
    <div class="container">
        <div class="row">

            <div class="col-lg-3 col-12">
            <a href="index" style="text-decoration:none; color:#fff"><img src="./assets/LOGO.png" alt="img1" class="img-fluid" style="width: 150px;"></a>
            </div>

            <div class="col-lg-3 col-12">
                <h4 class="font-eduvic font-size-24"><a href="index" style="text-decoration:none; color:#fff">Urban Gardener</a></h4>
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
                    <a href="welcome" class="font-rale font-size-14 text-white-50 pb-1">Order History</a>
                    <a href="cart" class="font-rale font-size-14 text-white-50 pb-1">Cart</a>
                    <a href="reservation" class="font-rale font-size-14 text-white-50 pb-1">Reservation Cart</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="copyright text-center bg-dark text-white py-2" style="">
    <p class="font-rale font-size-14">&copy; Copyrights 2023. Design By <a href="https://www.facebook.com/UrbanGardenerCC" target="_blank" rel="noopener" class="color-second">Mark Loyd Montiel & Deseree Custodio</a></p>
</div>

<!-- !start #footer -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<!-- Owl Carousel Js file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!--  isotope plugin cdn  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha256-CBrpuqrMhXwcLLUd5tvQ4euBHCdh7wGlDfNz8vbu/iI=" crossorigin="anonymous"></script>
<script src="./js/isotope.pkgd.min.js"></script>

<!-- Custom Javascript -->
<script src="./index.js"></script>


<script type="text/javascript">
        $(document).ready(function(){
        $("#fetchorder").on('change', function(){
            var value = $(this).val();
            alert(value);

            $.ajax({
                url: "fetch-order.php",
                type: "POST",
                data: 'request=' + value,
                beforeSend:function(){
                    $(".containers").html("<span>Working...</span>");
                },
                success:function(data){
                    $(".containers").html(data);
                }
            })
        });
    });
    </script>

    <script type="text/javascript">
    $(document).ready(function(){
        $("#fetchordermonth").on('change', function(){
            $("#fetchorderday").removeAttr("disabled");
            var value = $(this).val();
            alert(value);

            $.ajax({
                url: "fetch-order-month.php",
                type: "POST",
                data: 'request=' + value,
                beforeSend:function(){
                    $(".containers").html("<span>Working...</span>");
                },
                success:function(data){
                    $(".containers").html(data);
                }
            })
        });
    });

    </script>

    <script type="text/javascript">
        
    $(document).ready(function(){
        $("#fetchorderday").on('change', function(){
            var month = $('#fetchordermonth').val();
            var value = $("#fetchorderday").val();
            alert(value);

            $.ajax({
                url: "fetch-order-day.php",
                type: "POST",
                //data: 'request=' + value, 'month=' + month
                data: {request: value, month: month},
                beforeSend:function(){
                    $(".containers").html("<span>Working...</span>");
                },
                success:function(data){
                    $(".containers").html(data);
                }
            })
        });
    });
    </script>

<script type="text/javascript">
        $(document).ready(function(){
        $("#fetchreservation").on('change', function(){
            var value = $(this).val();
            alert(value);

            $.ajax({
                url: "fetch-reservation.php",
                type: "POST",
                data: 'request=' + value,
                beforeSend:function(){
                    $(".containerss").html("<span>Working...</span>");
                },
                success:function(data){
                    $(".containerss").html(data);
                }
            })
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
    $("#fetchzipcode").on('change', function(){
        var value = $(this).val();
        var zipcodevalue = $("#fetchday").val();
        var zipcodehidden = document.getElementById("zipcodehidden");
        var x = document.getElementById("zipcodename");

        const zipcodeMunicipality = {
            '4100': 'Cavite City',
            '4101':'Sangley Point Naval Base',
            '4102':'Bacoor, Cavite',
            '4103':'Imus, Cavite',
            '4104':'Kawit, Cavite',
            '4105':'Noveleta, Cavite',
            '4106':'Rosario, Cavite',
            '4107':'Gen. Trias, Cavite',
            '4108':'Tanza, Cavite',
            '4109':'Trece Martires City',
            '4110':'Naic, Cavite',
            '4111':'Ternate, Cavite',
            '4112':'Maragondon, Cavite',
            '4113':'Magallanes, Cavite',
            '4114':'Dasmariñas City',
            '4115':'Dasmariñas Resettlement Area',
            '4116':'Carmona, Cavite',
            '4117':'Gen. Mariano Alvarez (GMA)',
            '4118':'Silang, Cavite',
            '4119':'Amadeo, Cavite',
            '4120':'Tagaytay City',
            '4121':'Mendez, Cavite',
            '4122':'Indang, Cavite',
            '4123':'Alfonso, Cavite',
            '4124':'Gen. Emilio Aguinaldo, Cavite',
            '4125':'Corregidor Island'
        };

        var zipcode = zipcodeMunicipality[value];
        zipcodehidden.value = value;

        x.value = zipcode;


        });
    });
</script>

<script>
    $(document).ready(function(){ 
	showComments();
    //showCommentss();
    showPlantReviews();
	
    });
// function to show comments
function showComments()	{
    var username = $('#getUsername').val();
    var toggleName = $('#toggleName').html();
    //alert(username);
	$.ajax({
		url:"fetch-review-urban.php",
		method:"POST",
        data: {username: username, toggleName: toggleName},
		success:function(response) {
			$('#showComments').html(response);
		}
	})
}

// function to show comments
function showCommentss()	{
    var username = $('#getUsername').val();
    var toggleName = $('#toggleName').html()
    //alert(username);
	$.ajax({
		url:"fetch-review-plant.php",
		method:"POST",
        data: {username: username, toggleName: toggleName},
		success:function(response) {
			$('#showCommentss').html(response);
		}
	})
}

//function to show reviews

function showPlantReviews(){
    var item_id = $('#getItemId').val();
    var username = $('#getUsername').val();

    $.ajax({
        url:"fetch-plant-review.php",
        method:"POST",
        data: {username: username, item_id: item_id},
        success:function(response){
            $('#showPlantReviews').html(response);
        }
    })
}


</script>

</body>
</html>