<?php
include_once('header.php');
include_once('nav-bar-owner.php');
?>
<br>
<h1 align='center'>Welcome <?php echo $_SESSION["loggedUser"]->getFirstName()?></h1>

<nav align='center'>
    <ul>
        <li><a href="#">Menu</a>
        <ul>
            <li><a href="<?php echo FRONT_ROOT . "User/ShowMyProfile"?>">MY PROFILE</a></li>
            <li><a href="<?php echo FRONT_ROOT ?>">PET LIST (NOT FUNCTIONAL YET)</a></li>
            <li><a href="<?php echo FRONT_ROOT . "Keeper/ShowListView"?>">KEEPERS LIST</a></li>
            <li><a href="<?php echo FRONT_ROOT . "Home/Logout"?>">LOGOUT</a></li>
    </ul>
</nav>
<?php
    if(isset($message)){
        echo $message;
    }
?>