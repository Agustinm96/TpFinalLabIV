<?php

    require_once('validate-session.php');
    include_once('header.php');

?>

<main>
    <h1>Completing my profile!</h1>
    <form action="<?php ECHO FRONT_ROOT . "Keeper/Add"?>" method = "post">
    <div class="Dispo"> 
    <label for="adress">Adress
        <input type="text" name="adress" id="adress" >
    </label>
    <label for="initialDate">Initial Date
        <input type="date" name="initDate" id="initDate">
    </label> <!--VALIDAR FECHAS-->
    <br>
    <br>
    <label for="finishDate">Finish Date
        <input type="date" name="finishDate" id="finishDate">
    </label>
    <br>
    <br>
    <span>Choose the days you want to work!</span>
    <br>
    <select name="daysToWork[]" id="daysToWork" multiple="multiple">Choose the days you want to work
        <option value="Monday">Monday</option>
        <option value="Tuesday">Tuesday</option>
        <option value="Wednesday">Wednesday</option>
        <option value="Thursday">Thursday</option>
        <option value="Friday">Friday</option>
        <option value="Saturday">Saturday</option>
        <option value="Sunday">Sunday</option>
        <option value="EveryDay">Every Day</option>
    </select>
    </div>
    <br>
    <span>Choose the pets size you're willing to take care</span>
    <br>
    <div class="petSize-info">
        <input type="checkbox" name="size[]" value="small" checked/>
        <label for="small">Small</label>
        <input type="checkbox" name="size[]" value="medium"/>
        <label for="medium">Medium</label>
        <input type="checkbox" name="size[]" value="big"/>
        <label for="big">Big</label>
    </div>
    <br>
    <label for="phone">Price To Keep
        <input type="text" name="priceToKeep" id="priceToKeep" placeholder="37.500" required/>
    </label>
    <div class="button">
        <button type="submit" class="btn">Ready to Work!</button>
    </div>
    </form>
   
</main>

<?php

require_once('footer.php');

?>