<?php
include_once('header.php');
include_once('nav-bar.php');
require_once('validate-session.php');

?>
<!--
<div>
<?php if ($_SESSION["loggedUser"]->getUserType()->getId()==1) { ?>
  <table>
<tbody>
<h1 class ="heading"> Search Keeper</h1>
<td style="max-width: 120px;">
                 <form action="<?php echo FRONT_ROOT . "Chat/LookForKeeper" ?>" method="post" style="">    
                  <input type="text" name="searchParameter" size="22" min="0" style="max-width: 180px">
                  <input type="submit" class="btn" value="Search" style="background-color:#DC8E47;color:green;"/>
                </td>
</div>
</tbody>
</table>
<?php } ?>
<?php if (isset($result)) { ?>
  <div id="breadcrumb" class="hoc clear">
  <h2 class="heading">KEEPER RESULT</h2>
  <?php foreach($result as $user){ ?>
                <table style="text-align:left;">
              <thead>
                <tr>
                  <th style="width: 100px;">Keeper: </th>
                  <td><?php echo $user->getLastName() . " " .$user->getFirstName() ?></td>
                </tr>
                <form action="<?php echo FRONT_ROOT . "Chat/NewChat" ?>" method="post" style="">
                      <input type="hidden" name="id_Chat" value="<?php echo $user->getId() ?>" />
                      <td><input type="submit" class="btn" name="StartingChat" 
                      value=" START CHAT"
                   style="background-color:#DC8E47;color:white;" /></td>
              </table>
              <?php } ?>

  <?php }
?>
-->
</div>

<div id="breadcrumb" class="hoc clear">
  <h6 class="heading">CHATS</h6>
</div>
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
                <form target="_parent" action="<?php echo FRONT_ROOT . "ChatMessage/ShowChatStarted" ?>" method="post" style="">
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
              </table>
              <?php } ?>

        <?php }; ?>
      </div>
    </div>
    <div class="clear">
    </div>
    </aside>
</div>

