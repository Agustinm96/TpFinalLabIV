<?php

//require_once('nav-bar.php');

?>

<!-- ################################################################################################ -->
<div>
  <div>
    <div> 
      <ul>
        <li><a href="Owner/ShowAddView"?>">Home</a></li>
        <li><a href="Owner/ShowAddView"?>">Add Owner</a></li>
        <li><a href="Owner/ShowListView"?>">List Owners</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- ################################################################################################ -->
<div>
    <main>
        <div>
            <h2>Becoming a new Owner!</h2>
            <form action="" method="post">
            
            <div class="section-inputs">
            
            <label for="firstName">First Name
                <input type="text" name="firstName" placeholder="" required/>
            </label>
            
            <label for="LastName">Last Name
                <input type="text" name="lastName" id="lastName" placeholder="" required/>
            </label>
            
            <label for="dni">DNI
                <input type="text" name="dni" id="dni" placeholder="6 or more characters" min="6" required />
            </label>
            
            <label for="email">Email
                <input type="email" name="email" id="email" placeholder="" min="1" required />
            </label>
            
            <label for="phone">Phone Number
                <input type="text" name="phoneNumber" id="phoneNumber" placeholder="" required/>
            </label>

            <label for="username">Username
                <input type="text" name="username" id="username" placeholder="" required/>
            </label>

            <label for="password">Password
                <input type="password" name="password" id="password" placeholder="" required/>
            </label>
            
            <div class="button">
                <button type="submit" class="btn">Become a Owner</button>
            </div>
            </form>
        </div>
        <?php
        if(isset($message))
            echo $message;
    ?>
    </main>
</div>