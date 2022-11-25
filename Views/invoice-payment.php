<?php

$invoiceId = $invoice->getIdInvoice();
$keepersName = $availability->getKeeper()->getUser()->getFirstName() . ' ' . $availability->getKeeper()->getUser()->getLastName();
$price = $availability->getKeeper()->getPriceToKeep();
$iva = $price*0.21;
$totalprice = $price + $iva;

?>
<link href="<?php echo CSS_PATH;?>form-pago.css" rel="stylesheet">
<div class='container'>
    <div class='window'>
      <div class='order-info'>
        <div class='order-info-content'>
          <h2>Order Summary</h2>
                  <div class='line'></div>
          <table class='order-table'>
            <tbody>
              <tr>
                <td><img src='https://i.ibb.co/4grWhBR/Pet-Hero2.png' class='full-width'></img>
                </td>
                <td>
                  <br> <span class='thin'>Booked Reserve</span>
                  <br> With Keeper: <?php echo $keepersName ?><br> <span class='thin small'> Date: <?php echo $availability->getDate() ?><br><br></span>
                </td>
  
              </tr>
              <tr>
                <td>
                  <div class='price'>$ <?php echo $price ?></div>
                </td>
              </tr>
            </tbody>
  
          </table>
          <div class='line'></div>
          <div class='total'>
            <span style='float:left;'>
              <div class='thin dense'>IVA 21%</div>
              TOTAL
            </span>
            <span style='float:right; text-align:right;'>
              <div class='thin dense'>$ <?php echo $iva ?></div>
              $ <?php echo $totalprice ?>
            </span>
        </div>
</div>
</div>
        <div class='credit-info'>
            <div class='credit-info-content'>
            <table class='half-input-table'>
                <tr><td>Please select your card: </td><td>
                <select name="card" id="card" class='dropdown-btn' id="current-card">
                <option value="visa"  id='current-card'>Visa</option>
                <option value="mastercard">Master Card</option>
                <option value="american">American Express</option>
                </select><div class='dropdown' id='card-dropdown'>
                </div>
                </td></tr>
            </table>
            <br>
            <br>
            <br>
            Card Number
            <input type="number" class='input-field' maxlength="12" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required/><i>(Máximo 12 dígitos)</i></input>
            <br>
            Card Holder
            <input  type="text" class='input-field' min="10" max="20" placeholder="John Doe" required></input>
            <table class='half-input-table'>
                <tr>
                <td> Expires
                    <input type="number" class='input-field' maxlength="4" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="XXXX" required/></input>
                </td>
                <td>CVC
                    <input type="password" class='input-field'  maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); placeholder="security code" required></input>
                </td>
                </tr>  
                
            </table>
            <form action="<?php echo FRONT_ROOT . "Owner/PayInvoice"?>" method ="post"> 
            <td><input type="hidden" name="invoiceId" id="invoiceId" value="<?php echo $invoiceId ?>"></td>
            <button type="submit" class='pay-btn' >Checkout</button>
            </form>
            </div>
        </div>
        </div>
</div>
