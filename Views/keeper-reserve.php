<?php

    require_once('header.php');
    require_once('nav-bar.php');

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
                                <td align='center'><input type="text" name="petName" value="<?php echo $reserve["petName"] ?>" align='center' readonly></td>
                                <td align='center'><input type="text" name="petNameType" value="<?php if($reserve["petType"]==1){echo "Dog";}elseif($reserve["petType"]==2){echo "Cat";}  ?>" align='center' readonly></td>   
                                    
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