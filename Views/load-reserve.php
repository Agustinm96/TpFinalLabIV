<?php

    require_once('validate-session.php');
    include_once('header.php');
    include_once('nav-bar.php');

    $userName = ($_SESSION["loggedUser"]->getUserName());
?>

<main>
    <h1>Loading reserve</h1>
    <form action="<?php ECHO FRONT_ROOT . "Owner/generatingReserve"?>" method = "post">
    <table>
        <thead>              
            <tr>
                <th>Initial Date</th>
                <th>Available keeper's days</th>
                <th>Pet Size Available</th>
                <th>Choose my pet</th>
            </tr>
        </thead>
        <tbody align="center">
            <tr>
                <td><input type="date" name="date" id="date" min="<?php echo date('Y-m-d') ?>" ></td><!-- mostrar solo los dias disponibles del keeper -->
                <td><?php $array = $keeper->getavailabilityArray();
                foreach($array as $day){
                    if($day->getAvailable()){
                        echo $day->getDate() . '<br>';
                    }
                }?></td>
                <td><?php $arraySize =  $keeper->getPetSizeToKeep();
                                    foreach ($arraySize as $sizeValue) {
                                        echo ucfirst($sizeValue) . "<br>";
                                    } ?></td>
                <td>
                    <?php
                    if($petList){
                        ?><select name="pet[]" id="pet[]" multiple required><?php
                        foreach($petList as $pet){
                        
                        echo "<option value=".$pet->getIDPET().">".$pet->getName()."</option>";
                        }
                    }else{
                        echo "UPS! No pets here! <br>";?>
                        <a href="<?php echo FRONT_ROOT."Pet/ShowAddView" ?>">Add Pet</a><?php
                    }
                    ?>
                </select></td>
                <input type="hidden" name="keeper" value="<?php echo $keeper->getIdKeeper() ?>">
                <input type="hidden" name="userName" value="<?php echo $userName ?>">
            </tr>
        </tbody>
    </table>
    <div class="button">
        <button type="submit" class="btn">Generate</button>
    </div>
    </form>
    
<?php
        if(isset($message)){
            echo $message;
        }
    ?>
</main>

<?php

//require_once('footer.php');

?>