<?php 
include_once('header.php');
include_once('nav-bar.php');
require_once('validate-session.php');

?>

<div id="breadcrumb" class="hoc clear"> 
    <h6 class="heading">New DOG Register</h6>
  </div>
</div>
<main class="registerDog" style="width: 95%; max-width: 1200px;"> 
<div class="content" >
<div id="comments" style="align-items:center;">
        <h2>Complete the next information</h2>
        <form action="<?php echo FRONT_ROOT.$petType->getPetTypeName()."/Add" ?>" method="post" style="">
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
                <?php if($petType->getPetTypeId()==0){?>
                <tr>
                <th>Size</th>   
                <td>
                  <select name="size" cols="80" rows="1" required>
                     <option value="small">Small</option>
                     <option value="medium">Medium</option>   
                     <option value="big">Big</option>                 
                  </select>
                </td>
                </tr>
                <?php } ?>
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
    <?php var_dump($petType->getPetTypeId()); ?>
            <input type="hidden" name="petType" value= "<?php echo( $petType->getPetTypeId());?>" />
            <input type="submit" class="btn" value="Register" style="background-color:#DC8E47;color:white;"/>
          </div>
        </form>
        </div>

</div>
</main