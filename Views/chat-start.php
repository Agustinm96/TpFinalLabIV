<?php
include_once('header.php');
include_once('nav-bar.php');
require_once('validate-session.php');

?>
<div id="breadcrumb" class="hoc clear">
  <h6 class="heading">CHATS</h6>
</div>
<?php
if (!isset($chat)) { ?>
  <table style="text-align:center;">
  <h1 class="heading"> <?php echo $message; ?> </h1>
</table>
<?php }
?>


<tr> CHATING WITH <?php echo $chat->getId_Keeper()->getLastName().
               " " . $chat->getId_Keeper()->getFirstName()?></tr> 
<div class="wrapper row3">
    <!-- main body -->
    <div class="content">
      <div class="scrollable">
      <?php
        if ($msgList != null) {
        ?>
              <table style="text-align:center;">
              <?php foreach($msgList as $msg){ ?>
                <?php if($msg->getuserName() == $_SESSION["loggedUser"]->getFirstName() . 
                " " . $_SESSION["loggedUser"]->getLastName()){
                  ?>
                  <tr>
                <th style="text-align:right;"><?php echo $msg->getuserName(). 
                ": " . $msg->getMsg() ?> </th>
                </tr>
                <?php }else{ ?>
                  <tr>
                <th style="text-align:left;"><?php echo $msg->getuserName(). 
                ": " . $msg->getMsg() ?> </th>
                </tr>
                  <?php }?>
                <?php }?>
            
              </table>
        <?php }; ?>
        <thead>
                <tr>
                </tr>
                <form action="<?php echo FRONT_ROOT . "ChatMessage/AddMSG" ?>" method="post" style="">
                <tr>
                <td>
                  <textarea name="newMSG" style="margin-top: 3%;min-height: 100px;height: 75px;max-width: 500px" required></textarea>
                </td>
                </tr>
                      <input type="hidden" name="id_Chat" value="<?php echo $chat->getId_Chat() ?>" />
                      <td><input type="submit" class="btn" name="StartingChat" 
                      value=" SEND "
                   style="background-color:#DC8E47;color:white;" /></td>
                </form>
       </thead>
      </div>
    </div>
    <div class="clear">
    </div>
</div>

