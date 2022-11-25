<?php
include_once('header.php');
include_once('nav-bar.php');
require_once('validate-session.php');

?>

<div id="" class="hoc clear">
<?php if ($_SESSION["loggedUser"]->getUserType()->getId()==1) { ?>
  <table>
<tbody>
<h1 class ="heading"> Search Keeper</h1>
<td style="max-width: 120px;">
                 <form action="<?php echo FRONT_ROOT . "Chat/LookForKeeper" ?>" method="post" style="">    
                  <input type="text" name="searchParameter" size="22" min="0" style="max-width: 180px">
                  <input type="submit" class="btn" value="Search" style="background-color:#DC8E47;color:green;"/>
</form>
                </td>

</tbody>
</table>
</div>
<?php } ?>
<div id="" class="hoc clear">
<?php if (isset($result)&&($result)) { ?>
     <h2 class="heading">KEEPER RESULT</h2>
      <?php if(is_object($result)){ ?>
          <table style="text-align:center;">
              <thead>
                <tr>
                  <th style="width: 100px;">Keeper: </th>
                  <td><?php echo $result->getUser()->getLastName() . " " 
                      .$result->getUser()->getFirstName() ?></td>
                  </tr>
                  <div>
                      <form action="<?php echo FRONT_ROOT . "Chat/NewChat" ?>" method="post" style="">
                        <input type="hidden" name="id_User" value="<?php echo $result->getUser()->getId()?>" />
                       <td><input type="submit" class="btn"  
                       value= "ADD CHAT"
                     style="background-color:#DC8E47;color:white;" />
                  </td>
                      </form>
                  </div>
                  <div>
                  <form target="_blank" action="<?php echo FRONT_ROOT . "Chat/ViewInfo" ?>" method="post" style="">
                        <input type="hidden" name="id_User" value="<?php echo $result->getUser()->getId()?>" />
                       <td><input type="submit" class="btn"  
                       value= "View Info"
                     style="background-color:#DC8E47;color:white;" />
                  </td>
                      </form>
                      </div>
           </table>
        <?php } ?>
  <?php foreach($result as $user){ ?>
                <table style="text-align:left;">
              <thead>
                <tr>
                  <th style="width: 100px;">Keeper: </th>
                  <td><?php echo $user->getUser()->getLastName() . " " .$user->getUser()->getFirstName() ?></td>
                </tr>
                <div>
                <form action="<?php echo FRONT_ROOT . "Chat/NewChat" ?>" method="post" style="">
                      <input type="hidden" name="id_User" value="<?php echo $user->getUser()->getId()?>" />
                      <td><input type="submit" class="btn"  
                      value= "ADD CHAT"
                   style="background-color:#DC8E47;color:white;" /></td>
                </form>
                </div>
                <div>
                  <form target="_blank" action="<?php echo FRONT_ROOT . "Review/ViewInfo" ?>" method="post" style="">
                        <input type="hidden" name="id_User" value="<?php echo $user->getUser()->getId()?>" />
                       <td><input type="submit" class="btn"  
                       value= "View Info"
                     style="background-color:#DC8E47;color:white;" />
                  </td>
                      </form>
                      </div>
              </table>
              <?php } ?>

  <?php } ?>

</div>

<div id="breadcrumb" class="hoc clear">
  <h6 class="heading">CHATS</h6>

<?php
if (isset($message)) { ?>
  <table style="text-align:center;">
  <h1 class="heading"> <?php echo $message; ?> </h1>
</table>
<?php }
?>
<div class="wrapper row3">
<aside>
    <!-- main body -->
    <div class="content">
      <div class="scrollable">
      <?php
        if ($chatList != null) {
        ?>
              <?php foreach($chatList as $chat){ ?>
                <table style="text-align:left;">
              <thead>
                <tr>
                </tr>
                <form target="_blank" action="<?php echo FRONT_ROOT . "ChatMessage/ShowChatStarted" ?>" method="post" style="">
                      <input type="hidden" name="id_Chat" value="<?php echo $chat->getId_Chat() ?>" />
                      <?php if($_SESSION["loggedUser"]->getUserType()->getId()==1) {?>
                      <td><input type="submit" class="btn" name="StartingChat" 
                      value=" <?php echo $chat->getId_Keeper()->getLastName(). 
                  " " . $chat->getId_Keeper()->getFirstName();?>"
                   style="background-color:#DC8E45;color:RED;" /></td>
             <?php }?>
             <?php if($_SESSION["loggedUser"]->getUserType()->getId()==2) {?>
                      <td><input type="submit" class="btn" name="StartingChat" 
                      value=" <?php echo $chat->getId_Owner()->getLastName(). 
                  " " . $chat->getId_Owner()->getFirstName();?>"
                   style="background-color:#DC8E47;color:GREEN;" /></td>
             <?php }?>
             </form>
              </table>
              <?php } ?>

        <?php }; ?>
      </div>
    </div>
    <div class="clear">
    </div>
    </aside>
</div>
</div>
