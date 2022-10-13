<?php 
//include_once('header.php');
//include_once('nav-bar.php');
?>

<div id="breadcrumb" class="hoc clear"> 
    <h6 class="heading">Listado de Tipos de Usuarios</h6>
  </div>
</div>
<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->
    <div class="content"> 
      <div class="scrollable">
      <form action="<?php echo FRONT_ROOT?>UserType/Remove" method="GET"> 
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 150px;">Nombre</th>
              <th style="width: 450px;">Descripción</th>              
              <th style="width: 100px;">Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach($userTypeList as $userType)
              {
                ?>
                  <tr>
                    <td><?php echo $userType->getName() ?></td>
                    <td><?php echo $userType->getDescription() ?></td>
                    <td><button type="submit" name="id" class="btn" value="<?php echo $userType->getId() ?>">Eliminar</button></td>
                  </tr>
                <?php
              }
            ?>           
          </tbody>
        </table>
      </form> 
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>

<?php 
//include_once('footer.php');
?>