<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins 
<script src="vendor/chart.js/Chart.min.js"></script>

<-- Page level custom scripts 
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>
-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



<script type="text/javascript">
    $(document).ready(function(){
        $("#fetchval").on('change', function(){
            var value = $(this).val();
            alert(value);

            $.ajax({
                url: "fetch.php",
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
        $("#fetchmonth").on('change', function(){
            $("#fetchday").removeAttr("disabled");
            var value = $(this).val();
            alert(value);

            $.ajax({
                url: "fetch-month.php",
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
        $("#fetchday").on('change', function(){
            var month = $('#fetchmonth').val();
            var value = $("#fetchday").val();
            alert(value);

            $.ajax({
                url: "fetch-day.php",
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
        $("#fetchsort").on('change', function(){
            var value = $(this).val();
            alert(value);

            $.ajax({
                url: "fetch-sort.php",
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
        $("#fetchreservation").on('change', function(){
            var value = $(this).val();
            alert(value);

            $.ajax({
                url: "fetch-reservation.php",
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
        $("#fetchsupplier").on('change', function(){
            var value = $(this).val();
            alert(value);

            $.ajax({
                url: "fetch-supplier.php",
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
        $("#fetchdeliveries").on('change', function(){
            var value = $(this).val();
            alert(value);

            $.ajax({
                url: "fetch-deliveries.php",
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
        $("#fetchmonthdeliveries").on('change', function(){
            $("#fetchdaydeliveries").removeAttr("disabled");
            var value = $(this).val();
            alert(value);

            $.ajax({
                url: "fetch-month-deliveries.php",
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
        $("#fetchdaydeliveries").on('change', function(){
            var month = $('#fetchmonthdeliveries').val();
            var value = $("#fetchdaydeliveries").val();
            alert(value);

            $.ajax({
                url: "fetch-day-deliveries.php",
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
        $("#fetchtransaction").on('change', function(){
            var value = $(this).val();
            alert(value);

            $.ajax({
                url: "fetch-transaction.php",
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
        $("#fetchtransactionmonth").on('change', function(){
            $("#fetchtransactionday").removeAttr("disabled");
            var value = $(this).val();
            alert(value);

            $.ajax({
                url: "fetch-month-transaction.php",
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
        $("#fetchtransactionday").on('change', function(){
            var month = $('#fetchtransactionmonth').val();
            var value = $("#fetchtransactionday").val();
            alert(value);

            $.ajax({
                url: "fetch-day-transaction.php",
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
        x = 0;
        $('.btn-next').click(function(){
            x = (x<=200)?(x+100):0; //es6

            $('.figure').css('left', -x+"%");
        })

        $('.btn-prev').click(function(){
            x = (x>=100)?(x-100):300; //es6

            $('.figure').css('left', -x+"%");
        })
    })
</script>

<script type="text/javascript">

    $(document).on('click', '#reserveCheckBox', function(){
        if(document.querySelector('#reserveCheckBox:checked')){
            var checkedValue = document.querySelector('#reserveCheckBox:checked').value;
            $('#reserveValue').val(checkedValue);
        }else{
            var zero_value = "0";
            $('#reserveValue').val(zero_value);
        }
    })
    
</script>

<script type="text/javascript">

    function showReason(){
        var x = document.getElementById("cancellationReason");
        document.getElementById("cancellationReason").required = true;
    
        x.style.display = "block";
    }

    function hideReason(){
        var x = document.getElementById("cancellationReason");
        document.getElementById("cancellationReason").required = false;
    
        x.style.display = "none";
    }

</script>