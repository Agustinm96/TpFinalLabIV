<?php

    require_once('validate-session.php');
    include_once('header.php');
    include_once('nav-bar.php');

?>
<div id="breadcrumb" class="hoc clear"> 
<main>
    <h1>Finding a Keeper</h1>
    <form action="<?php ECHO FRONT_ROOT . "Owner/ShowAvailableListView"?>" method = "post">
    <table>
        <thead>              
            <tr>
                <th>Initial Date</th>
                <th>Last Date</th>
            </tr>
        </thead>
        <tbody align="center">
            <tr>
                
                <td><input type="date" name="initDate" id="initDate" min="<?php echo date('Y-m-d') ?>"></td>
                <td><input type="date" name="finishDate" id="finishDate" min="<?php echo date('Y-m-d') ?>"></td>
            </tr>
        </tbody>
    </table>
    <div class="button">
        <button type="submit" class="btn">Find a Keeper!</button>
    </div>
    </form>
    
<?php
        if(isset($message)){
            echo $message;
        }
    ?>
</main>
    </div>
<?php

//require_once('footer.php');

?>