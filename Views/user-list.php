<?php 
  include_once('header.php');
  //include_once('nav-bar.php');
?>

<div id="breadcrumb" class="hoc clear"> 
    <h6 class="heading">Listado de Usuarios</h6>
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
                <th style="width: 100px;">First Name</th>
                <th style="width: 170px;">Last Name</th>
                <th style="width: 120px;">DNI</th>
                <th style="width: 400px;">Email</th>
                <th style="width: 110px;">Phone Number</th>                
                <th style="width: 120px;">Username</th>
                <th style="width: 120px;">Rol</th>
              </tr>
            </thead>
            <tbody>
              <?php
                foreach($userList as $user)
                {
                  ?>
                    <tr>
                      <td><?php echo $user->getFirstName() ?></td>
                      <td><?php echo $user->getLastName() ?></td>
                      <td><?php echo $user->getDni() ?></td>
                      <td><?php echo $user->getEmail() ?></td>
                      <td><?php echo $user->getPhoneNumber() ?></td>
                      <td><?php echo $user->getUsername() ?></td>
                      <td><?php echo $user->getUserType()->getName() ?></td>
                    </tr>
                  <?php
                }
              ?>                           
            </tbody>
          </table>
          <form action="<?php echo FRONT_ROOT."User/Remove" ?>" method="get">
            <table style="max-width: 35%;" >
            <thead>
              <tr>
                <th style="width: 100px;">DNI</th>
                <th style="width: 170px;">Accion</th>
              </tr>
            </thead>
            <tbody align=center>
              <tr>
                <td>
                  <input type="number" name="dni" style="height: 40px;" min="0">  
                </td>
                <td>
                  <button type="submit" class="btn" value="">Remover</button>
                </td>
              </tr>
            </tbody>
            </tr>
          </table>
          <form>
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>

<?php 
  include_once('footer.php');
?>