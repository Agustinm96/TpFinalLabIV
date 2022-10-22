<?php 
    include_once('header.php'); 
    include_once('nav-bar.php');
    require_once("validate-session.php");

    use Models\Keeper;
    use Models\User;
?>

<div id="breadcrumb" class="hoc clear"> 
    <h6 class="heading">Update Zone</h6>
    </div>
</div>
<div class="wrapper row3" >
    <main class="container" style="width: 95%;"> 
    <div class="content" > 
        <div id="comments" style="align-items:center;">
        <h2>Updating Me!</h2>
        <form action="<?php echo FRONT_ROOT ."User/ModifyProfile" ?>" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
            <table> 
            <thead>              
                <tr>
                <th>Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone Number</th>                
                <th>Username</th>
                <th>Password</th>
                </tr>
            </thead>
            <tbody align="center">
            <tr>
                <td style="max-width: 120px;">
                    <input type="text" name="firstname" value="<?php echo $user->getFirstName()?>" size="22" min="0" required>
                </td> 
                <td>
                    <input type="text" name="lastname" size="22" value="<?php echo $user->getLastName()?>" placeholder="<?php echo $user->getLastName()?>" required>
                </td>
                <td>
                    <input type="email" name="email" min="0" style="max-width: 120px" value="<?php echo $user->getEmail()?>" required>
                </td>   
                <td>
                    <input type="text" name="phone" min="0" style="max-width: 120px" value="<?php echo $user->getPhoneNumber()?>" required>
                </td>      
                <td>
                    <input type="text" name="username" min="0" style="max-width: 120px" value="<?php echo $user->getUserName()?>" required>
                </td>                
                <td>
                    <input type="password" name="password" min="0" style="max-width: 120px" value="<?php echo $user->getPassword()?>" required>
                </td> 
        <div>
            <input type="submit" class="btn" value="Update Me!" style="background-color:#DC8E47;color:white;"/>
        </div>
        </form>
    </div>
    <?php if ($message) {
        echo $message;
    } ?>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
</main>
</div>