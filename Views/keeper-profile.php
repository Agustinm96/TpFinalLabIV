<?php

include_once('header.php');
include_once('keeper-nav-bar.php'); 
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
        <form action="<?php ECHO FRONT_ROOT . "Keeper/ShowModifyProfileView"?>" method ="post">
        <table style="text-align:center;">
            <thead>
            <tr>
            
                <th style="width: 100px;">Name</th>
                <th style="width: 170px;">Last Name</th>
                <th style="width: 120px;">Email</th>
                <th style="width: 100px;">Dni </th> 
                <th style="width: 400px;">Phone Number</th>             
                <th style="width: 100px;">UserName</th>
                <th style="width: 100px;">Password</th>
            </tr>
            </thead>
            <tbody>
            <?php $user = new User();
                    $user = ($_SESSION["loggedUser"]);?>                           
                <td><?php echo $user->getFirstName()?></td>
                <td><?php echo $user->getLastName()?></td>
                <td><?php echo $user->getEmail()?></td>
                <td><?php echo $user->getDni()?></td>
                <td><?php echo $user->getPhoneNumber()?></td>
                <td><?php echo $user->getUserName()?></td>
                <td><?php echo $user->getPassword()?></td>
        </tbody>
        </table>
        <div>
            <input type="submit" class="btn" value="Modify" style="background-color:#DC8E47;color:white;"/>
        </div>
        </form>
    </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
</main>
</div>

<?php 
    //include_once('footer.php');
?>