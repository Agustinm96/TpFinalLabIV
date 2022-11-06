<?php

include_once('header.php');
include_once('nav-bar.php'); 
require_once('validate-session.php');

use Models\User;
use Models\Keeper;

?>



<div id="breadcrumb" class="hoc clear"> 
    <h6 class="heading">Meeting myself!</h6>
</div>
</div>
<div class="wrapper row3">
<main class="hoc container clear"> 
    <!-- main body -->
    <div class="content"> 
    <div class="scrollable">
        <form action="<?php ECHO FRONT_ROOT . "Reserve/ShowModifyAvailabilityView"?>" method ="post">
        <table style="text-align:center;">
            <thead>
            <tr>
                <th style="width: 110px;">Adress</th>  
                <th style="width: 100px;">Pet Size that i can handle :)</th>
                <th style="width: 100px;">Since</th>
                <th style="width: 100px;">To</th>
                <th style="width: 110px;">Price</th> 
            </tr>
            </thead>
            <tbody>
                <td><?php echo $keeper->getAdress()?></td>
                <td><?php echo $keeper->getPetSizeToKeep() ?></td>
                <td><?php echo $keeper->getStartingDate() ?></td>
                <td><?php echo $keeper->getLastDate() ?></td>
                <td>U$S<?php echo $keeper->getPriceToKeep() ?></td>
        </tbody>
        </table>
        <div>
            <input type="submit" class="btn" value="Modify" style="background-color:#DC8E47;color:white;"/>
        </div>
        </form>
    </div>
    </div>
    <?php
if(isset($message)){
    echo $message;
}
?>
    <!-- / main body -->
    <div class="clear"></div>
</main>
</div>