<?php
include_once('header.php');
?>
<h1>Wellcome: <?php echo $_SESSION["loggedUser"]->getFirstName()?></h1>