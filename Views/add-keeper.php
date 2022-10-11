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
            <h2>Becoming a new Keeper!</h2>
            <form action="<?php ECHO FRONT_ROOT . "Keeper/Add"?>" method="post">
            
            <div class="section-inputs">
            
            <label for="firstName">First Name
                <input type="text" name="firstName" placeholder="Lionel" required/>
            </label>
            
            <label for="LastName">Last Name
                <input type="text" name="lastName" id="lastName" placeholder="Messi" required/>
            </label>
            
            <label for="dni">DNI
                <input type="text" name="dni" id="dni" placeholder="6 or more characters" min="6" required />
            </label>
            
            <label for="email">Email
                <input type="email" name="email" id="email" placeholder="johnFalkner@gmail.com" min="1" required />
            </label>
            
            <label for="phone">Phone Number
                <input type="text" name="phoneNumber" id="phoneNumber" placeholder="(223) 549-1488" required/>
            </label>
            
            </div>
                <div class="petSize-info">
                    <label for="petSize">Pet's size i'm willing to keep</label>
                    <input type="checkbox" name="size[]" value="small" checked/>
                    <label for="small">Small</label>
                    <input type="checkbox" name="size[]" value="medium"/>
                    <label for="medium">Medium</label>
                    <input type="checkbox" name="size[]" value="big"/>
                    <label for="big">Big</label>
                </div>
            <div class="button">
                <button type="submit" class="btn">Become a Keeper</button>
            </div>
            </form>
        </div>
        <?php
        if(isset($message))
            echo $message;
    ?>
    </main>
</div>
<!-- ################################################################################################ -->
