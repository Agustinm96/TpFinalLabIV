<?php

require_once('nav-bar.php');
require_once('header.php');
require_once('validate-session.php');

use Models\User;
use Models\Keeper;

?>

<div>
    <main>
        <div>
            <form action="<?php echo FRONT_ROOT . "Keeper/Remove" ?>" method="post">
                <table style="text-align:center">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Name</th>
                            <th style="width: 170px;">Last Name</th>
                            <th style="width: 120px;">Email</th>
                            <th style="width: 400px;">Phone Number</th>
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
                        foreach ($keepersList as $keeper) {
                        ?><tr>
                                <td><?php echo $keeper->getUser()->getFirstName() ?></td>
                                <td><?php echo $keeper->getUser()->getLastName() ?></td>
                                <td><?php echo $keeper->getUser()->getEmail() ?></td>
                                <td><?php echo $keeper->getUser()->getPhoneNumber() ?></td>

                                <td><?php echo $keeper->getAdress() ?></td>
                                <td><?php $array =  $keeper->getPetSizeToKeep();
                                    foreach ($array as $sizeValue) {
                                        echo ucfirst($sizeValue) . "<br>";
                                    } ?></td>
                                <td><?php $arrayDays = $keeper->getReserve()->getArrayDays();
                                    foreach ($arrayDays as $day) {
                                        echo $day . '<br>';
                                    } ?>
                                <td><?php echo $keeper->getReserve()->getStartingDate() ?></td>
                                <td><?php echo $keeper->getReserve()->getLastDate() ?></td>
                                <td>U$S<?php echo $keeper->getPriceToKeep() ?></td>
                            </tr><?php
                                } ?>


                        <button type="submit" name="code" class="btn" value="<?php echo $keeper->getIdKeeper() ?>">Remove</button>
                    </tbody>
                </table>
            </form>
        </div>
    </main>
</div>

<?php

require_once('footer.php');

?>