<?php

require_once('validate-session.php');
require_once('nav-bar.php');
require_once('header.php');

use Models\User;
use Models\Owner;

?>
<div id="breadcrumb" class="hoc clear">
<div>
    <main>
        <div>
            <form action="<?php echo FRONT_ROOT . "Owner/Remove" ?>" method="post">
                <table style="text-align:center">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Name</th>
                            <th style="width: 170px;">Last Name</th>
                            <th style="width: 120px;">Email</th>
                            <th style="width: 400px;">Phone Number</th>
                            <th style="width: 110px;">Adress</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($ownersList as $owner) {
                        ?><tr>
                                <td><?php echo $owner->getUser()->getFirstName() ?></td>
                                <td><?php echo $owner->getUser()->getLastName() ?></td>
                                <td><?php echo $owner->getUser()->getEmail() ?></td>
                                <td><?php echo $owner->getUser()->getPhoneNumber() ?></td>
                                <td><?php echo $owner->getAdress()?></td>

                                <td><button type="submit" name="id" class="btn" value="<?php echo $owner->getUser()->getId();?>">Remove</button></td>
                            <?php
                        } ?>


                    </tbody>
                </table>
            </form>
        </div>
    </main>
</div>

</div>
<?php
require_once('footer.php');

?>