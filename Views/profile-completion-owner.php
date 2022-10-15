<?php

    require_once('validate-session.php');
    include_once('header.php');

?>

<main>
    <h1>Completing my profile!</h1>
    <form action="<?php ECHO FRONT_ROOT . "Owner/Add"?>" method = "post">
    <div class="Dispo"> 
    <label for="adress">Adress
        <input type="text" name="adress" id="adress" >
    </label>
    <div class="button">
        <button type="submit" class="btn">Register as Owner</button>
    </div>
    </form>
   
</main>

<?php

require_once('footer.php');

?>