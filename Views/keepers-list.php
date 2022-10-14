<?php

require_once('nav-bar.php');
require_once('header.php');
require_once('validate-session.php');
?>

<div>
    <main>
        <div>
            <form action="<?php ECHO FRONT_ROOT . "Keeper/Remove" ?>" method="post">
            <table style="text-align:center">
                <thead>
                    <tr>
                    <th style="width: 100px;">Name</th>
                    <th style="width: 170px;">Last Name</th>
                    <th style="width: 120px;">Email</th>
                    <th style="width: 100px;">Dni </th> 
                    <th style="width: 400px;">Phone Number</th>             
                    <th style="width: 100px;">UserName</th>
                    <th style="width: 100px;">Password</th>
                    <th style="width: 110px;">Adress</th>  
                    <th style="width: 100px;">Pet Size that i can handle :)</th>
                    <th style="width: 100px;">Working days</th>
                    <th style="width: 100px;">Since</th>
                    <th style="width: 100px;">To</th>
                    <th style="width: 110px;">Price</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $user = new User();
                        $user = ($_SESSION["loggedUser"]);?>
                        <?php
                        if($keeper->getReserve()->getIsAvailable()){
                            ?><td><?php echo $user->getFirstName()?></td>
                            <td><?php echo $user->getLastName()?></td>
                            <td><?php echo $user->getEmail()?></td>
                            <td><?php echo $user->getDni()?></td>
                            <td><?php echo $user->getPhoneNumber()?></td>
                            <td><?php echo $user->getUserName()?></td>
                            <td><?php echo $user->getPassword()?></td>
                            <td><?php echo $keeper->getAdress()?></td>
                            <td><?php $array =  $keeper->getPetSizeToKeep();
                            foreach($array as $sizeValue){
                                echo ucfirst($sizeValue). "<br>";
                            }?></td>
                            <td><?php $arrayDays = $keeper->getReserve()->getArrayDays() ?>
                                    <?php 
                                    foreach($arrayDays as $day){
                                                echo $day .'<br>';
                                            }?>
                            <td><?php echo $keeper->getReserve()->getStartingDate() ?></td>
                            <td><?php echo $keeper->getReserve()->getLastDate() ?></td>
                            <td>U$S<?php echo $keeper->getPriceToKeep()?></td><?php
                        }?>                          
                        
                        <button type="submit" name="code" class="btn" value="<?php echo $keeper->getIdKeeper() ?>">Remove</button>
                </tbody>
            </table>
            </form>
        </div>
    </main>
</div>
