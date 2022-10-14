<?php 
    include_once('header.php');
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
        <form action="<?php echo FRONT_ROOT."Keeper/Modify" ?>" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>              
              <tr>
                <th>Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone Number</th>                
                <th>Username</th>
                <th>Password</th>
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
                <td style="max-width: 120px;">  <!--QUE PASA SI NO QUIERO COMPLETAR TODOS LOS CAMPOS--> 
                  <input type="text" name="firstname" size="22" min="0">
                </td>
                <td>
                  <input type="text" name="lastname" size="22">
                </td>
                <td>
                  <input type="email" name="email" min="0" style="max-width: 120px">
                </td>   
                <td>
                  <input type="text" name="phone" min="0" style="max-width: 120px">
                </td>      
                <td>
                  <input type="text" name="username" min="0" style="max-width: 120px">
                </td>                
                <td>
                  <input type="password" name="password" min="0" style="max-width: 120px">
                </td> 
                <td><input type="text" name="adress" id="adress"></td>
                <td><input type="date" name="initDate" id="initDate"></td>
                <td><input type="date" name="finishDate" id="finishDate"></td>
                <td><select name="daysToWork[]" id="daysToWork" multiple="multiple">Choose the days you want to work
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
                <option value="EveryDay">Every Day</option>
                </select></td>
                <td><input type="checkbox" name="size[]" value="small" checked/>
                <label for="small">Small</label>
                <input type="checkbox" name="size[]" value="medium"/>
                <label for="medium">Medium</label>
                <input type="checkbox" name="size[]" value="big"/>
                <label for="big">Big</label></td>
                <td><input type="text" name="priceToKeep" id="priceToKeep" placeholder="37.500" required/></td>
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