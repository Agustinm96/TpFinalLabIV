<?php
include_once('header.php');
include_once('nav-bar.php');
?>
<br>
<h1 align='center'>Welcome <?php echo $_SESSION["loggedUser"]->getFirstName()?></h1>

<nav align='center'>
    <ul>
        <li><a href="#">Menu</a>
        <ul>
            <li><a href="<?php echo FRONT_ROOT . "Keeper/ShowMyProfile"?>">MY PROFILE</a></li>
            <li><a href="<?php echo FRONT_ROOT . "Keeper/SetAvailabilityView"?>">SET  AVAILABILITY</a></li>
            <li><a href="<?php echo FRONT_ROOT . "Home/Logout"?>">LOGOUT</a></li>
    </ul>
</nav>
<?php
    if(isset($message)){
        echo $message;
    }
?>
<?php
    include_once('footer.php');
?>