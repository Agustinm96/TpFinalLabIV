<?php
include_once('header.php');
?>
<div class="wrapper row1">
  <header id="header" class="clear">
    <div id="logo" class="fl_left">
      <h1>PET HERO</h1>
    </div>
    <!-- <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a class="drop" href="#">Actions</a>
          <ul>
            <li><a href="">ADD</a></li>
            <li><a href="">LIST/REMOVE</a></li>
      </ul>
    </nav> -->
  </header>
</div>
<div class="wrapper row2 bgded" style="background-image:url('../images/demo/backgrounds/1.png');">
  <div class="overlay">
  </div>
</div>
<!-- #######################################################################3 -->
<div class="wrapper row3 img-login">
  <div class="div-login"><br>
  <?php if ($message) {
      echo $message;
    } ?>
    <h1 class="text-login">LOGIN</h1>
  </div>
  <div class="div-login">
    <form action="<?php echo FRONT_ROOT . "Home/Login" ?>" method="post">
      <input class="input-login" type="text" name="username" placeholder="Nombre Usuario" required>
      <input class="input-login" type="password" name="password" placeholder="Contraseña" required>
      <button class="btn-login btn" type="submit" name="btnLogin">Ingresar</button>
    </form>
    <p>or</p>
    <a href="<?php echo FRONT_ROOT."User/ShowAddView" ?>">Crear nuevo usuario</a>

    

  </div>
</div>