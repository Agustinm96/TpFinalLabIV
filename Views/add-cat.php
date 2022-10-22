<?php 
include_once('header.php');
include_once('nav-bar.php');
require_once('validate-session.php');

?>

<div id="breadcrumb" class="hoc clear"> 
    <h6 class="heading">New CAT Register</h6>
  </div>
</div>
<main class="registerCat" style="width: 95%;"> 
<div class="content" >
<div id="comments" style="align-items:center;">
        <h2>Complete the next information</h2>
        <form action="<?php echo FRONT_ROOT."Dog/Add" ?>" method="post" style="">
        <table style="align-items:center;"> 
            <thead>              
              <tr>
                <th>Name</th>
                <td style="max-width: 120px;">    
                  <input type="text" name="name" size="22" min="0" style="max-width: 180px" required>
                </td>
                </tr>
                <tr>
                <th>BirthDate</th>
                <td>
                  <input type="date" name="birthDate" size="22" style="max-width: 140px" required>
                </td>
                </tr>
                <tr>
                <th>Observations</th>
                <td>
                  <textarea name="observation" style="margin-top: 3%;min-height: 100px;height: 75px;max-width: 500px"></textarea>
                </td>
                </tr>     
                <tr>     
                <th>Race</th>
                <td>
                  <input type="text" name="race" style="max-width: 180px" required>
                </td>   
                </tr>
              </tr>
            </thead>
            <tbody align="center">
              </tbody>
</table>
<div>
            <input type="submit" class="btn" value="Register" style="background-color:#DC8E47;color:white;"/>
          </div>
        </form>
        </div>

</div>
</main