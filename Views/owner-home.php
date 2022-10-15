<?php
include_once('header.php');
include_once('nav-bar-owner.php');
?>
<h1>Wellcome: <?php echo $_SESSION["loggedUser"]->getFirstName()?></h1>