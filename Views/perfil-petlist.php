<?php 
  include_once('header.php');
  include_once('nav-bar.php');
?>

<div id="breadcrumb" class="hoc clear"> 
    <h6 class="heading">Mis mascotas</h6>
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
                <?php if($pet->getPetType()=="dog"){ ?>
                <th style="width: 400px;">Race</th>
                <th style="width: 110px;">Size</th>               
                <th style="width: 100px;">Vaccination Plan </th>
                <?php } ?>
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
                      <td><?php echo $pet->getObservations() ?></td>
                      <td><?php echo $pet->getPicture() ?></td>
                      <?php  if($pet->getPetType()=="dog"){ ?>
                      <td><?php echo $pet->geRace() ?></td>
                      <td><?php echo $pet->getSize() ?></td>
                      <td><?php echo $pet->getVaccinationPlan() ?></td>
                      <?php } ?>
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