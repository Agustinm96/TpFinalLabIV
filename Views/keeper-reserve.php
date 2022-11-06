<?php

    require_once('header.php');
    require_once('nav-bar.php');

    /*SOLO PARA VER LAS RESERVAS YA ACEPTADAS Y LAS HISTORICAS, NO LAS PENDING RESERVES*/ 
    // if($reserve->getReserveRequest()){
                                        /*<button type="submit" name="id" class="btn" style="margin-right:5px;" value="1">Confirm</button>
                                        <button type="submit" name="id" class="btn" value="2">Cancel</button></td>*/
?>

<div>
    <main>
        <div>
            <?php if($reserveList){
                ?><form action="<?php echo FRONT_ROOT . "Keeper/modifyingReserve" ?>" method="post">
                <table style="text-align:center">
                    <thead>
                        <tr>
                            <th style="width: 300px;">Date</th>
                            <th style="width: 300px;">Owner's user name</th>
                            <th style="width: 300px;">Pet name</th>
                            <th style="width: 300px;">Type</th>
                            <th style="width: 300px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($reserveList as $reserve) {
                        ?><tr>
                                <td align='center'><input type="date" name="date" value="<?php echo $reserve["date"] ?>" readonly></td>
                                <td align='center'><input type="text" name="userName" id="userName" value="<?php echo $reserve["userName"] ?>" readonly></td>

                                <td align='center'><input type="text" name="petName" value="<?php echo $reserve["petName"] ?>" align='center' readonly></td>
                                <td align='center'><input type="text" name="petNameType" value="<?php echo $reserve["petType"] ?>" align='center' readonly></td>   
                                    
                                    <?php $date=date('Y-m-d'); 
                                    if($reserve["date"]>=$date){
                                        ?><td>Accepted</td><?php 
                                        }
                                        else{
                                            ?>--><td>Done</td><?php
                                                }
                                        }?>
                            </tr>                                                                                                                   
                    </tbody>
                </table>
            </form><?php
            }else{
                ?><h2>U DON'T HAVE ANY RESERVES SET YET :)</h2><?php
            }?>
            
        </div>
        <?php
        if(isset($message)){
            echo $message;
        }
    ?>
    </main>
</div>