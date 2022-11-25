<?php 
include_once('header.php');
include_once('nav-bar.php');
require_once('validate-session.php');

?>

<div id="breadcrumb" class="hoc clear"> 
    <h6 class="heading">PET REGISTER</h6>
  
<main class="registerDog" style="width: 95%; max-width: 1200px;"> 
<div class="content" >
<div id="comments" style="align-items:center;">
        <h2>Elije el TIPO DE MASCOTA QUE DESEES AGREGAR</h2>
        <form action="<?php echo FRONT_ROOT."PetType/Add" ?>" method="get" style="">
            <thead>              
              <tr>
              <div>
              <th>PERRO / DOG</th>
            <input type="hidden" name="PETID" value="1" />
            <input type="hidden" name="namePET" value="Dog"/>
            <input type="submit" class="btnDog" value="DOG" style="background-color:#DC8E47;color:white;"/>
          </div>
              </tr>
              </form>    
          <form action="<?php echo FRONT_ROOT."PetType/Add" ?>" method="get" style="">
              <tr>
              <div>
              <th>GATO / CAT</th>
            <input type="hidden" name="PETID" value="2" />
            <input type="hidden" name="namePET" value="Cat"/>
            <input type="submit" class="btnCat" value="CAT" style="background-color:#DC8E47;color:white;"/>
          </div>
              </tr>
          </form>
          <form action="<?php echo FRONT_ROOT."PetType/Add" ?>" method="get" style="">
              <tr>
              <div>
              <th>COBAYA / GUINEA PIG</th>
            <input type="hidden" name="PETID" value="3" />
            <input type="hidden" name="namePET" value="GuineaPig"/>
            <input type="submit" class="btnGuineaPig" value="GUINEA PIG" style="background-color:#DC8E47;color:white;"/>
          </div>
              </tr>
            </thead>
            <tbody align="center">
              </tbody>
        </form>
        </div>

</div>
</div>
</main

