<?php 
    include_once('header.php');
    include_once('nav-bar.php'); 

    use Models\Keeper;
    
    $arraySize =$keeper->getPetSizeToKeep();
    $arrayDays=$keeper->getArrayDays();

    if(!empty($array)){
        echo '<script language="javascript">alert("You have loaded reserves, if you modify your availability those reserves are going to be deleted");</script>';
    }
    
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
        <form action="<?php echo FRONT_ROOT ."Keeper/ModifyAvailability" ?>" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
        <table> 
            <thead>              
            <tr>
                <th>Adress</th>
                <th>Initial Date</th>
                <th>Last Date</th>
                <th>Working Days</th>
                <th>Pet's size</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody align="center">
            <tr>
                <td><input type="hidden" name="idKeeper" value="<?php echo $keeper->getIdKeeper()?>" id="idKeeper">
                    <input type="text" name="adress" value="<?php echo $keeper->getAdress()?>"id="adress"></td>
                <td><input type="date" name="initDate" value = "<?php echo $keeper->getStartingDate()?>" id="initDate" min="<?php echo date('Y-m-d') ?>"></td>
                <td><input type="date" name="finishDate"  value = "<?php echo $keeper->getLastDate()?>" id="finishDate" min="<?php echo date('Y-m-d') ?>"></td>
                <td><select name="daysToWork[]" id="daysToWork" multiple="multiple" value="<?php foreach($arrayDays as $day){echo $day;} ?>" required>Choose the days you want to work
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
                </select></td>
                <td><select name="size[]" id="petSizeToKeep" value="<?php foreach($arraySize as $size){echo $size;}?>" multiple required>
                <option value="small">Small</option>
                <option value="medium">Medium</option>
                <option value="big">Big</option>
                </select>
                <td><input type="text" name="priceToKeep" id="priceToKeep" value="<?php echo $keeper->getPriceToKeep()?>" placeholder="<?php echo $keeper->getPriceToKeep()?>" required/></td>
                <td><input type="number" name="petsAmount" id="petsAmount" placeholder="min=1 max=10" min="1" max="10" required/></td>

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