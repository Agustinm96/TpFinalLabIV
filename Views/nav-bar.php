
<div class="bgded overlay" style="background-image:url('<?php echo IMG_PATH; ?>FlamingMoeHome.jpg');"> 
  <div class="wrapper row0">
    <div id="topbar" class="hoc clear">   
      <div class="fl_right">     
        <ul class="nospace">
          <li><i class="fas fa-phone"></i> (123) 456 7890</li>
          <li><i class="far fa-envelope"></i> PetHero@User.com</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="wrapper row1">
    <header id="header" class="hoc clear"> 
      <div id="logo" class="fl_left">
        <h1><a href="#">PET HERO</a></h1>
      </div>
      <!-- Add path routes below -->
      <nav id="mainav" class="fl_right">
        <ul class="clear">
            <li class="active"><a href="<?php echo FRONT_ROOT?>Admin/ShowHomeView">Main Menu</a></li>
            <li><a class="drop" href="#">Users</a>
      
            <ul>
              <li><a href="<?php echo FRONT_ROOT."User/ShowAddView" ?>">Add user</a></li>
              <li><a href="<?php echo FRONT_ROOT."Owner/ShowListView" ?>">Owners list</a></li>
                <li><a href="<?php echo FRONT_ROOT."Keeper/ShowListView" ?>">Keepers list</a></li>
                <li><a href="<?php echo FRONT_ROOT."User/ShowListView" ?>">All users</a></li>

              </ul>
            </li>
            <li><a class="drop" href="#">User Types</a>
              <ul>
                <li><a href="<?php echo FRONT_ROOT."UserType/ShowAddView" ?>">Add UserType</a></li>
                <li><a href=<?php echo FRONT_ROOT."UserType/ShowListView" ?>>User Types</a></li>
              </ul>
            </li>
            <li><a href="<?php echo FRONT_ROOT."Pet/ShowListView" ?>">Pet List</a>
            <li><a href="<?php echo FRONT_ROOT."Home/Logout"?>">Logout</a></li>
        </ul>
    </nav> 
    </header>
  </div>