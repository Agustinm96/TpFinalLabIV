<?php

require_once('header.php');
require_once('nav-bar.php');

?>

<div>
<main>
    <div>
        <?php if($invoicesToPayList){?>
            <table style="text-align:center">
                <thead>
                    <tr>
                        <th style="width: 300px;">Invoice number</th>
                        <th style="width: 300px;">Pet name</th>
                        <th style="width: 300px;">Date</th>
                        <th style="width: 300px;">Price</th>
                        <th style="width: 300px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                        foreach ($invoicesToPayList as $invoiceToPay) {
                            ?><form action="<?php echo FRONT_ROOT . "Owner/ShowInvoicePaymentFromPage" ?>" method="post">
                        <tr>
                            <td align='center'><input type="number" name="invoiceId" value="<?php echo $invoiceToPay->getIdInvoice() ?>" readonly></td>
                            <td align='center'><input type="text" name="petName" value="<?php echo $invoiceToPay->getReserve()->getPet()->getName() ?>" align='center' readonly></td>
                            <td align='center'><input type="date" name="date" value="<?php echo $invoiceToPay->getReserve()->getAvailability()->getDate()  ?>" align='center' readonly></td>   
                            <td align='center'><input type="number" name="price" value="<?php echo $invoiceToPay->getReserve()->getAvailability()->getKeeper()->getPriceToKeep()  ?>" align='center' readonly></td>  
                            <td><button class="btn">Pay</button></td> 
                        </tr> 
                    </form>   
                    <?php
                        }       ?>                                                                                                        
                </tbody>
            </table>
    <?php    
    }else{
            ?><h2>U DON'T HAVE ANY INVOICE TO PAY :)</h2><?php
        }?>
        
    </div>
    <?php
    if(isset($message)){
        echo $message;
    }
?>
</main>
</div>