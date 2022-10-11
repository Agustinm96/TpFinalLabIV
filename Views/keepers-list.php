<?php

require_once('nav-bar.php');

?>

<!-- ################################################################################################ -->
<div>
  <div>
    <div> 
      <ul>
        <li><a href="<?php echo FRONT_ROOT . "Keeper/ShowAddView"?>">Home</a></li>
        <li><a href="<?php echo FRONT_ROOT . "Keeper/ShowAddView"?>">Add Keeper</a></li>
        <li><a href="<?php echo FRONT_ROOT . "Keeper/ShowListView"?>">List Keepers</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- ################################################################################################ -->
<div>
    <main>
        <div>
            <form action="<?php ECHO FRONT_ROOT . "Keeper/ShowListView" ?>" method="post">
            <table style="text-align:center">
                <thead>
                    <tr>
                        <th style="width: 5%">Id</th>
                        <th style="width: 5%">First Name</th>
                        <th style="width: 5%">Last Name</th>
                        <th style="width: 5%">DNI</th>
                        <th style="width: 5%">Email</th>
                        <th style="width: 5%">Phone Number</th>
                        <th style="width: 5%">Pet Size willing to keep</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                        foreach($keepersList as $keeper){
                            ?>
                            <tr>
                                <td><?php echo $keeper->getIdKeeper()?></td>
                                <td><?php echo $keeper->getFirstName()?></td>
                                <td><?php echo $keeper->getLastName()?></td>
                                <td><?php echo $keeper->getDni()?></td>
                                <td><?php echo $keeper->getEmail()?></td>
                                <td><?php echo $keeper->getPhoneNumber()?></td>
                                <td><?php $array =  $keeper->getPetSizeToKeep();
                                foreach($array as $sizeValue){
                                    echo ucfirst($sizeValue). "<br>";}
                                    ?></td>
                            </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
            </form>
        </div>
    </main>
</div>
