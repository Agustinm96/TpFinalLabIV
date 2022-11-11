<?php

    require_once('header.php');
    require_once('nav-bar.php');

?>

<div>
    <main>
        <div>
                <table style="text-align:center">
                    <thead>
                        <tr>
                            <th style="width: 300px;">Date</th>
                            
                            <th style="width: 300px;">Pet name</th>
                            <th style="width: 300px;">Pet Type</th>
                            <th style="width: 300px;">My Decision</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($pendingReservesList as $reserve){
                        ?><form action="<?php echo FRONT_ROOT . "Keeper/modifyingReserve" ?>" method="post"><?php
                        ?><tr>
                                <td align='center'><input type="date" name="date" value="<?php echo $reserve["date"] ?>" readonly></td>
                                
                                <td align='center'><input type="text" name="petName" value="<?php echo $reserve["pet"]->getName() ?>" readonly></td>
                                <td align='center'><input type="text" name="petType" value="<?php if($reserve["pet"]->getPetType()->getPetTypeId()==1){echo "Dog";}elseif($reserve["pet"]->getPetType()->getPetTypeId()==2){echo "Cat";} ?>" readonly></td>
                                <input type="hidden" name="petId" id="petId" value="<?php echo $reserve["pet"]->getId_Pet()?>">
                                <input type="hidden" name="availabilityId" id="availabilityId" value="<?php echo $reserve["availabilityId"]?>">
                                <input type="hidden" name="reserveId" id="reserveId" value="<?php echo $reserve["reserveId"]?>">
                                <td>
                                <button type="submit" name="id" class="btn" style="margin-right:5px;" value="1">Confirm</button>
                                <button type="submit" name="id" class="btn" style="margin-left:5px;" value="2">Cancel</button>
                                </td>         
                            </tr> 
                        </form>
                        <?php }?>
                    </tbody>
                </table>
            
        </div>
        <?php
        if(isset($message)){
            echo $message;
        }
    ?>
    </main>
</div>