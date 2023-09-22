<?php
include ('./config.php');
?>

<html>
<body style="background-color: dimgray">


<!--  Pending Orders   -->
<div class="container py-1" style="overflow: auto; padding: 40px;">
    <div class="container py-1 my-1">
        <div class="row font-rale">

            <div class="col-auto order-pending" style="width: 350px; height: auto; border: 0px solid #79B861; border-radius: 10px; margin: auto; overflow-x: auto; font-family: sans-serif; padding: 40px 80px 40px 80px; background-color: white">


                        <p style="text-align: center; font-size: 20px; color: #79B861"><b>{ORDER_NUMBER}</b></p>
                        <p style="margin: 0px 0px 10px 20px; font-size: 15px;"><b>Customer Name:</b> {NAME}</p>
                        <p style="margin: 0px 0px 10px 20px; font-size: 15px;"><b>Address:</b> {ADDRESS}</p>
                        <p style="margin-left: 20px; font-size: 15px;"><b>Mode of Payment: </b><u>{MODE_PAYMENT}</u></p>
                        <p style="margin-left: 20px; font-size: 15px;"><b>Transaction Date: </b>{DATE}</p>
                        <p style="margin-left: 20px; font-size: 15px;"><b>Status: </b>{ORDER}</p>
                        <p style="margin-left: 20px; font-size: 15px;"><b>Reason for Cancellation: </b>{CANCEL}</p>
                        <hr>

                        <table class="table table-sm table-responsive" style="margin-left: auto; margin-right: auto; overflow: auto; width:100%;">

                        <thead>
                        <th style="font-size: 18px; border-bottom: 1px solid;">Name</th>
                        <th style="font-size: 18px; border-bottom: 1px solid;">Quantity</th>
                        <th style="font-size: 18px; border-bottom: 1px solid;">Unit Price</th>
                        </thead>


                        <tbody>
                        <tr>
                            <td  style="text-align: center; font-size: 15px;">{ITEM_NAME}</td>
                            <td  style="text-align: center; font-size: 15px;">{ITEM_QUANTITY}</td>
                            <td  style="text-align: center; font-size: 15px;">{PRICE}</td>
                        </tr>



                    </tbody>
                    </table>
                    <hr>
                    <p style="margin-right: 20px; color: red; font-size: 15px; text-align: right">Total: ₱{TOTAL_PRICE}</p>

                    <div style="text-align: center">
                        <a href="http://localhost/Urban%20Gardener/welcome" style="text-align: center; display: block; width: 100%; text-align: center; background-color: #79B861; color:white; font-size: 14px; padding:14px 5px; border-radius: .5rem;cursor: pointer; margin-top: 1rem; text-decoration: none">Back to your Orders</a>
                    </div>


                    </div>

                    <div style="text-align: center; margin-top: 10px; color: white; font-family: sans-serif;">
                        <small>Copyright © Urban Gardener 2022</small><br><br>
                        <small><a href="http://localhost/Urban%20Gardener/eula" style="color: white">User Agreement</a></small>
                    </div>


        </div>

    </div>
</div>

</body>
</html>