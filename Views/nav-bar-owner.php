
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
            <li class="active"><a href="<?php echo FRONT_ROOT?>Owner/ShowHomeView">Main Menu</a></li>
            <li><a class="drop" href="#">My Pets</a>
              <ul>
                <li><a href="<?php echo FRONT_ROOT."Dog/ShowAddView" ?>">Add Pet</a></li>
                <li><a href="<?php echo FRONT_ROOT."Dog/ShowListView" ?>">List Pets</a></li>
              </ul>
            </li>
            <li><a class="drop" href="#">Keepers</a>
              <ul>
                <li><a href="<?php echo FRONT_ROOT."Keeper/ShowListView" ?>">See All Keepers</a></li>
                <li><a href="<?php echo FRONT_ROOT."Keeper/ShowListView" ?>">See availables keepers</a></li>
              </ul>
            </li>
            <li><a href="<?php echo FRONT_ROOT."Owner/ShowMyProfile"?>">My Profile</a></li>
            <li><a href="<?php echo FRONT_ROOT."Home/Logout"?>">Logout</a></li>
        </ul>
    </nav> 
    </header>
  </div>