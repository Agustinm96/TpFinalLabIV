<?php 
  include_once('header.php');
  include_once('nav-bar.php');
?>

<div id="breadcrumb" class="hoc clear"> 
    <h6 class="heading">My pets</h6>
  </div>
</div>
<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->
    <div class="content"> 
      <div class="scrollable">
          <table style="text-align:center;">
            <thead>
              <tr>
                <th style="width: 100px;">Name</th>
                <th style="width: 170px;">BirthDate</th>
                <th style="width: 120px;">Observations</th>
                <th style="width: 100px;">Picture </th>
                <th style="width: 150px;">Race</th>
                <th style="width: 110px;">Size</th>               
                <th style="width: 100px;">Vaccination Plan </th>
                <th style="width: 150px;">Video </th>
              </tr>
            </thead>
            <tbody>
              <?php
                foreach($petList as $pet)
                {
                  ?>
                    <tr>
                      <td><?php echo $pet->getName() ?></td>
                      <td><?php echo $pet->getBirthDate() ?></td>
                      <td><?php echo $pet->getObservation() ?></td>
                       <?php if($pet->getPicture()==NULL) {?> 
                       <form action="<?php echo FRONT_ROOT."Pet/ShowUploadPetPicture" ?>" method="post" style="">  
                        <div>
                        <input type="hidden" name="PETID" value="<?php echo $pet->getIDPET()?>" />       
                        <input type="submit" class="btn" name= "PETName" value = <?php echo "Pic-".$pet->getName()?> style="background-color:#DC8E47;color:white;"/>
                       </div>
                       </form>
                       <?php  }?>
                      <td><img src="<?php echo FRONT_ROOT.IMG_PATH.$pet->getPicture(); ?>" alt= "no-image.php" style="width: 100px;"></td>
                      <td><?php echo $pet->getRace() ?></td>
                      <td><?php echo $pet->getSize() ?></td>
                      <?php if($pet->getVaccinationPlan()==NULL) {?> 
                       <form action="<?php echo FRONT_ROOT."Pet/ShowUploadPetVaccination" ?>" method="post" style="">  
                        <div>
                        <input type="hidden" name="PETID" value="<?php echo $pet->getIDPET() ?>"/>           
                        <input type="submit" class="btn" name= "PETName" value = <?php echo "Vac-".$pet->getName() ?> style="background-color:#DC8E47;color:white;"/>
                       </div>
                       </form>
                       <?php  }?>
                      <td><img src="<?php echo FRONT_ROOT.IMG_PATH.$pet->getVaccinationPlan(); ?>" alt= "no-image.php"  style="width: 100px;"></td>
                      <?php if($pet->getVideoPET()==NULL) {?> 
                       <form action="<?php echo FRONT_ROOT."Pet/ShowUploadVideo" ?>" method="post" style="">  
                        <div>
                        <input type="hidden" name="PETID" value="<?php echo $pet->getIDPET() ?>"/>           
                        <input type="submit" class="btn" name= "PETName" value = <?php echo "Video-".$pet->getName() ?> style="background-color:#DC8E47;color:white;"/>
                       </div>
                       </form>
                       <?php  }?>
                      <td><video controls alt= "VIDEO NO ASIGNADO"  width=320  height=240>
                         <source src="<?php echo FRONT_ROOT.IMG_PATH.$pet->getVideoPET(); ?>" >
                         </video>
                      </td>
                    </tr>
                       <?php
                }
              ?>                       
            </tbody>
          </table>
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>

<?php 
  include_once('footer.php');
?>