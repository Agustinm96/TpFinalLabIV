<?php 
include_once('header.php');
include_once('nav-bar.php');
require_once('validate-session.php');

?>

<div id="breadcrumb" class="hoc clear"> 
    <h6 class="heading">New Pet Register</h6>
  </div>
</div>
<main class="registerDog" style="width: 95%;"> 
<div class="content" >
<div id="comments" style="align-items:center;">
        <h2>Complete the next information</h2>
        <form action="<?php echo FRONT_ROOT."Dog/Add" ?>" method="post" style="">
        <table> 
            <thead>              
              <tr>
                <th>Name</th>
                <th>BirthDate</th>
                <th>Observations</th>
                <th>Size</th>                
                <th>Race</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 120px;">    
                  <input type="text" name="name" size="22" min="0" required>
                </td>
                <td>
                  <input type="date" name="birthDate" max="<?php echo date('Y-m-d') ?>" size="22" required>
                </td>
                <td>
                  <textarea name="observation" style="margin-top: 3%;min-height: 35px;height: 20px"></textarea>
                </td>
                <td>
                  <select name="size" cols="60" rows="1" required>
                     <option value="small">Small</option>
                     <option value="medium">Medium</option>   
                     <option value="big">Big</option>                 
                  </select>
                </td>
                <td>
                  <input type="text" name="race" style="max-width: 120px" required>
                </td>                          
              </tr>
              </tbody>

</table>
<div>
            <input type="submit" class="btn" value="Register" style="background-color:#DC8E47;color:white;"/>
          </div>
        </form>
        </div>

</div>
</main

