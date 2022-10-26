<?php
include_once('header.php');
include_once('nav-bar.php');
?>

<h1 align='center'>Welcome <?php echo $_SESSION["loggedUser"]->getFirstName() ?></h1>

<?php if ($_SESSION["loggedUser"]->getUserType()->getId() == 1) { ?>

    <li><a href="#">Menu</a>
        <ul>
            <li><a href="<?php echo FRONT_ROOT . "User/ShowMyProfile" ?>">MY PROFILE</a></li>
            <li><a href="<?php echo FRONT_ROOT . "Pet/ShowPerfilView" ?>">PET LIST</a></li>
            <li><a href="<?php echo FRONT_ROOT . "Keeper/ShowListView" ?>">KEEPERS LIST</a></li>
            <li><a href="<?php echo FRONT_ROOT . "Owner/ShowAskForAKeeper" ?>">ASK FOR A KEEPER</a></li>
            <li><a href="<?php echo FRONT_ROOT . "Home/Logout" ?>">LOGOUT</a></li>
        </ul>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>

    <?php } else if ($_SESSION["loggedUser"]->getUserType()->getId() == 2) { ?>

    <li><a href="#" align="center">Menu</a>
        <ul>
            <li><a href="<?php echo FRONT_ROOT . "User/ShowMyProfile" ?>">MY PROFILE</a></li>
            <li><a href="<?php echo FRONT_ROOT . "Keeper/ShowMyAvailability" ?>">AVAILABILITY</a></li>
            <li><a href="<?php echo FRONT_ROOT . "Home/Logout" ?>">LOGOUT</a></li>
        </ul>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
    <?php } else if ($_SESSION["loggedUser"]->getUserType()->getId() == 3) { ?>
        <?php
        require_once(VIEWS_PATH . "footer.php");
        ?>
    <?php } ?>