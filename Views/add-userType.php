<?php 
include_once('header.php');
//include_once('nav-bar.php');
?>

<div id="" class=""> 
    <h6 class="heading">Ingreso de Tipos de Usuarios</h6>
  </div>
</div>
<div class="" >
  <main class=""> 
    <!-- main body -->
    <div class="" > 
      <div id="" style="align-items:center;">
        <h2>Ingresar Tipo de Usuario</h2>
        <form action="<?php echo 'FRONT_ROOT'."UserType/Add" ?>" method="POST"  style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
               <td>
                  <input type="text" name="name" value="" size="22" required>
                </td>
                <td>
                  <textarea name="description" id="" cols="50" rows="1" required></textarea>
                </td>
              </tr>
              </tbody>
          </table>
          <div>
            <input type="submit" class="btn" value="Crear" style="background-color:#DC8E47;color:white;"/>
          </div>
        </form>
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>


<?php 
include_once('footer.php');
?>