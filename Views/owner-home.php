<?php
include_once('header.php');
include_once('nav-bar-owner.php');
?>
<h1>Welcome: <?php echo $_SESSION["loggedUser"]->getFirstName()?></h1>

<?php
    if(isset($message)){
        echo $message;
    }
?>