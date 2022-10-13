<?php 
    include_once('header.php');
?>
<main>
    <form action="<?php echo FRONT_ROOT?>Home/Login" method="POST">
        <p>Username</p>
    <input type="text">
        <p>Password</p>
        <input type="password">
        <br><br>
        <div class="button">
                <button type="submit" class="btn">Login</button>
            </div>
        </form>
        <p>or</p>
        <a href="<?php echo VIEWS_PATH?>add-user.php">Create new user</a>
</main>