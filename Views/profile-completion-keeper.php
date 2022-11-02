<?php

    require_once('validate-session.php');
    include_once('header.php');

?>

<main>
    <h1>Completing my profile!</h1>
    <form action="<?php ECHO FRONT_ROOT . "Keeper/Add"?>" method = "post">
    <table>
        <thead>              
            <tr>
                <th>Adress</th>
                <th>Initial Date</th>
                <th>Last Date</th>
                <th>Working Days</th>
                <th>Pet's size</th>
                <th>Price</th>
                <th>How many pets you want to take care</th>
            </tr>
        </thead>
        <tbody align="center">
            <tr>
                <td><input type="text" name="adress" id="adress" required></td>
                <td><input type="date" name="initDate" id="initDate" min="<?php echo date('Y-m-d') ?>"></td>
                <td><input type="date" name="finishDate" id="finishDate" min="<?php echo date('Y-m-d') ?>"></td>
                <td><select name="daysToWork[]" id="daysToWork" multiple="multiple" required>Choose the days you want to work
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
                </select></td>
                <td><select name="size[]" id="petSizeToKeep" multiple required>
                <option value="small">Small</option>
                <option value="medium">Medium</option>
                <option value="big">Big</option>
                </select>
                <td><input type="text" name="priceToKeep" id="priceToKeep" placeholder="2.500" required/></td>
                <td><input type="number" name="petsAmount" id="petsAmount" placeholder="min=1 max=10" min="1" max="10" required/></td>
            </tr>
        </tbody>
    </table>
    <div class="button">
        <button type="submit" class="btn">Ready to Work!</button>
    </div>
    </form>
    
<?php
        if(isset($message)){
            echo $message;
        }
    ?>
</main>

<?php

require_once('footer.php');

?>