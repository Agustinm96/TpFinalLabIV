<?php

    require_once('validate-session.php');
    include_once('header.php');
    include_once('nav-bar.php');

    $userName = ($_SESSION["loggedUser"]->getUserName());
?>
<div id="breadcrumb" class="hoc clear"> 
<main>
    <h1>Loading reserve</h1>
    <form action="<?php ECHO FRONT_ROOT . "Owner/generatingReserve"?>" method = "post">
    <table>
        <thead>              
            <tr>
                <th>Choose a day</th>
                <th>Pet Size Available</th>
                <th>Choose my pet</th>
            </tr>
        </thead>
        <tbody align="center">
            <tr>
                <td><select name="date" id="date">
                    <?php foreach($availabilityList as $day){
                            if($day->getAvailable()){
                                echo "<option value=".$day->getDate().">".$day->getDate()."</option>";
                                }
                            }
                ?></select>
                </td>
                <td><?php echo $keeper->getPetSizeToKeep() ?></td>
                <td>
                    <?php
                    if($petList){
                        ?><select name="pet[]" id="pet[]" multiple required><?php
                        foreach($petList as $pet){
                        
                        echo "<option value=".$pet->getId_Pet().">".$pet->getName()."</option>";
                        }
                    }else{
                        echo "UPS! No pets here! <br>";?>
                        <a href="<?php echo FRONT_ROOT."Pet/ShowAddView" ?>">Add Pet</a><?php
                    }
                    ?>
                </select></td>
                <input type="hidden" name="keeper" value="<?php echo $keeper->getIdKeeper() ?>">
                
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
    </div>
<?php

//require_once('footer.php');

?>