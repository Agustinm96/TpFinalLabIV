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
                            <th style="width: 300px;">Owner's user name</th>
                            <th style="width: 300px;">Pet name & Type</th>
                            <th style="width: 300px;">My Decision</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($pendingReservesList as $reserve){
                        ?><form action="<?php echo FRONT_ROOT . "Keeper/modifyingReserve" ?>" method="post"><?php
                        ?><tr>
                                <td align='center'><input type="date" name="date" value="<?php echo $reserve->getDate() ?>" readonly></td>
                                <td align='center'><input type="text" name="userName" value="<?php echo $reserve->getUserName() ?>" readonly></td>
                                <td align='center'><input type="text" name="petName" value="<?php echo $reserve->getPetList() ?>" readonly></td>
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