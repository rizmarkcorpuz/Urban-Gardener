<?php
ob_start();
//include header.php file
include('header.php');

?>

<?php

    /* include cart template */
        include('Template/__cart-template.php');
    /* include cart template area */

    /* include wishlist template */
        //include('Template/__wishlist_template.php');
    /* include wishlist template area */

    /* include new plants area */
        include('Template/__new-plants.php');
    /* include new plants area */
?>

<?php
//include footer.php file
include('footer.php');
?>
