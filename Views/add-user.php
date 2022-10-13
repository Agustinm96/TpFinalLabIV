<?php 
    include_once('header.php');
    //include_once('nav-bar.php');
?>

<div id="" class=""> 
    <h6 class="heading">Ingreso de Usuarios</h6>
  </div>
</div>
<div class="" >
  <main class=""> 
    <!-- main body -->
    <div class="" > 
      <div id="" style="align-items:center;">
        <h2>Ingresar Usuario</h2>
        <form action="<?php echo FRONT_ROOT?>User/Add" method="POST" style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>              
              <tr>
                <th>Name</th>
                <th>Last Name</th>
                <th>DNI</th>
                <th>Email</th>
                <th>Phone Number</th>                
                <th>Username</th>
                <th>Password</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 120px;">    
                  <input type="text" name="firstname" size="22" min="0" required>
                </td>
                <td>
                  <input type="text" name="lastname" size="22" required>
                </td>
                <td>
                  <input type="number" name="dni" min="0" style="max-width: 120px" required>
                </td>
                <td>
                  <input type="email" name="email" min="0" style="max-width: 120px" required>
                </td>   
                <td>
                  <input type="number" name="phone" min="0" style="max-width: 120px" required>
                </td>      
                <td>
                  <select name="userTypeId" style="margin-top: 3%;min-height: 35px;height: 20px" required>
                    <?php
                      foreach($userTypeList as $userType)
                      {
                        ?>
                           <option value="<?php echo $userType->getId() ?>"><?php echo $userType->getName() ?></option>
                        <?php
                      }
                    ?>                                
                  </select>
                </td>
                <td>
                  <input type="text" name="username" min="0" style="max-width: 120px" required>
                </td>                
                <td>
                  <input type="password" name="password" min="0" style="max-width: 120px" required>
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