<?php

include('config.php');
if(isset($_POST['request'])){

    $request = $_POST['request'];

    $query = "SELECT DISTINCT order_number, user_id FROM `checkout` ORDER BY order_number";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);

?>

                <?php
                if($request == "withoutPotPopup"){

                }else{
                ?>
                    <!-- Pots -->
                    <div class="size my-3" style="float: right; margin-left:10px;">
                        <h6 class="font-baloo">Pick a Pot:</h6>
                        <div class="d-flex justify-content-between">
                            <div class="font-rubik">
                                <input type="radio" name="potpickpopup" id="mattePotPopup" value="Matte White Pot" checked="checked">
                                <label for="mattePotPopup">Matte White Pot<span></span></label>
                                <input type="radio" name="potpickpopup" id="glossyPotPopup" value="Glossy White Pot">
                                <label for="glossyPotPopup">Glossy White Pot<span></span></label>
                            </div>
                        </div>
                    </div>
                    <!-- !Pots -->

                    <script>
                        potid = $("input[name='potpickpopup']:checked").attr('value');
                        $("#input_pot").val(potid);
                        $("#input_pots").val(potid);
                        console.log(potid);
                    </script>

    
<?php
                }
}
?>