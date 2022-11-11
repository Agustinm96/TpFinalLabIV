<?php
include_once('header.php');
include_once('nav-bar.php');
require_once('validate-session.php');

?>
<?php
if (isset($message)) {
  echo $message;
}
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
        <?php
        if ($petList != null) {
        ?>
          <?php
          foreach ($petList as $pet) {
          ?>
            <table style="text-align:center;">
              <thead>
                <tr>
                  <th style="width: 100px;">Name</th>
                  <td><?php echo $pet->getName() ?></td>
                </tr>
                <tr>
                  <th style="width: 170px;">BirthDate</th>
                  <td><?php echo $pet->getBirthDate() ?></td>
                </tr>
                <tr>
                  <th style="width: 120px;">Observations</th>
                  <td><?php echo $pet->getObservation() ?></td>
                </tr>
                <tr>
                  <th style="width: 100px;">Picture </th>
                  <?php if ($pet->getPicture()) {
                  ?>
                    <td><img src="<?php echo FRONT_ROOT . IMG_PATH . $pet->getPicture(); ?>" alt="no-image.php" style="width: 100px;"></td>
                  <?php } else if ($pet->getPicture() == NULL) { ?>
                    <form action="<?php echo FRONT_ROOT . "Pet/ShowUploadPetPicture" ?>" method="post" style="">

                      <input type="hidden" name="PETID" value="<?php echo $pet->getId_Pet() ?>" />
                      <td><input type="submit" class="btn" name="PETName" value=<?php echo "Pic-" . $pet->getName() ?> style="background-color:#DC8E47;color:white;" /></td>

                    </form>
                  <?php } ?>
                </tr>
                <tr>
                  <th style="width: 150px;">Race</th>
                  <td><?php echo $pet->getRace() ?></td>
                </tr>
                <?php if (($pet->getPetType()->getPetTypeId() == "1") || ($pet->getPetType()->getPetTypeId() == "2")) { ?>
                  <tr>
                    <?php if ($pet->getPetType()->getPetTypeId() == "1") { ?>
                      <th style="width: 110px;">Size</th>
                      <td><?php echo $pet->getSize() ?></td>
                  </tr>
                <?php } ?>
                <tr>
                  <th style="width: 100px;">Vaccination Plan </th>
                  <?php if ($pet->getVaccinationPlan()) { ?>
                    <td><img src="<?php echo FRONT_ROOT . IMG_PATH . $pet->getVaccinationPlan(); ?>" alt="no-image.php" style="width: 100px;"></td>
                  <?php } else if ($pet->getVaccinationPlan() == NULL) { ?>
                    <form action="<?php echo FRONT_ROOT . "Pet/ShowUploadPetVaccination" ?>" method="post" style="">
                      <input type="hidden" name="PETID" value="<?php echo $pet->getId_Pet() ?>" />
                      <td><input type="submit" class="btn" name="PETName" value=<?php echo "Vac-" . $pet->getName() ?> style="background-color:#DC8E47;color:white;" /></td>

                    </form>
                  <?php  } ?>
                </tr>
                <tr>
                  <th style="width: 150px;">Video </th>
                  <?php if ($pet->getVideoPET()) { ?>
                    <td><video controls alt="VIDEO NO ASIGNADO" width=320 height=240>
                        <source src="<?php echo FRONT_ROOT . IMG_PATH . $pet->getVideoPET(); ?>">
                    </td>
                  <?php } else if ($pet->getVideoPET() == NULL) { ?>
                    <form action="<?php echo FRONT_ROOT . "Pet/ShowUploadVideo" ?>" method="post" style="">
                      <input type="hidden" name="PETID" value="<?php echo $pet->getId_Pet() ?>" />
                      <td><input type="submit" class="btn" name="PETName" value=<?php echo "Video-" . $pet->getName() ?> style="background-color:#DC8E47;color:white;" /></td>
                    </form>
                  <?php  } ?>
                  </video>
                </tr>
                </tr>
              <?php  } ?>
            <?php  } ?>
          <?php } ?>
              </thead>
            </table>
      </div>
    </div>
    <div class="clear"></div>
  </main>
</div>