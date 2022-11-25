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
        <form action="<?php echo FRONT_ROOT.$pet->getPetType()->getPetTypeName()."/Modify" ?>" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
            <table> 
            <thead>              
                <tr>
                <th>Name</th>
                <td style="max-width: 120px;">
                    <input type="text" name="name" value="<?php echo $pet->getName()?>" size="22" min="0" required>
                </td>
                </tr> 
                <tr>
                <th>BirthDate</th>
                <td style="max-width: 120px;">
                    <input type="date" name="birthDate" value="<?php echo $pet->getBirthDate()?>" size="22" min="0" required>
                </td>
                </tr>
                <tr>
                <th>Observations</th>
                <td style="max-width: 120px;">
                    <input type="textarea" name="observations" value="<?php echo $pet->getObservation()?>" size="22" min="0" required>
                </td>
                </tr>
                <?php if($pet->getpetType()->getPetTypeId()==1){?>
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
                <?php if($pet->getpetType()->getPetTypeId()==1||$pet->getpetType()->getPetTypeId()==2) {?>
                <tr>
                <th>Race</th>
                <td>
                  <input type="text" name="race" value="<?php echo $pet->getRace()?>" style="max-width: 180px" required>
                </td>   
                </tr>
                <?php } ?>              
                <?php if($pet->getpetType()->getPetTypeId()==3){?>
                <tr>
                <th>Gender</th>   
                <td>
                  <select name="gender" cols="80" rows="1" required>
                     <option value="female">Hembra</option>
                     <option value="male">Macho</option>                    
                  </select>
                </td>
                </tr>
                <tr>
                <th>Heno</th>   
                <td>
                  <select name="heno" cols="80" rows="1" required>
                     <option value="alfalfa">Alfalfa</option>
                     <option value="avena">Avena</option>
                     <option value="trigo">Trigo</option>   
                     <option value="festuca">Festuca</option>   
                     <option value="indiferente">Indiferente</option>                       
                  </select>
                </td>
                </tr>
                <?php } ?>
            </thead>
            <tbody align="center">
        <div>
            <input type="hidden" name="PETID" value="<?php echo $pet->getId_Pet() ?>" />
            <input type="submit" class="btn" value="Update Me!" style="background-color:#DC8E47;color:white;"/>
        </div>
                </tbody>
        </form>
    </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
</main>
</div>