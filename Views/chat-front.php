<?php
include_once('header.php');
require_once('validate-session.php');

?>

<?php
if (!isset($chat)) { ?>
  <table style="text-align:center;">
  <h1 class="heading"> <?php echo $message; ?> </h1>
</table>
<?php }
?>
<div class="contenedorchat" style="position:relative; max-weight:800px; margin:auto;">
    <div class="menu">
        <link rel="stylesheet" href="<?php echo CSS_PATH;?>chatcss.css">    
            <div class="back"><i class="fa fa-chevron-left"></i>
             <img src="https://i.imgur.com/DY6gND0.png" draggable="false"/></div>
             <div class="name"><?php if($_SESSION["loggedUser"]->getUserType()->getId()==1){
                echo $chat->getId_Keeper()->getLastName(). 
             " " . $chat->getId_Keeper()->getFirstName();
            }else{
                echo $chat->getId_Owner()->getLastName(). 
             " " . $chat->getId_Owner()->getFirstName();
            }?></div>
            <div class="last"><?php if($_SESSION["loggedUser"]->getUserType()->getId()==1){
                 echo "Keeper";}else{ echo "OWNER";} ?></div>
        </div>
    <ol class="chat">
    <?php
        if ($msgList != null) {
        ?>
    <?php foreach($msgList as $msg){ ?>
       <?php if($msg->getuserName() == $_SESSION["loggedUser"]->getFirstName() . 
                " " . $_SESSION["loggedUser"]->getLastName()){ ?> 
   <li class="self">
        <div class="avatar"><img src="https://i.imgur.com/HYcn9xO.png" draggable="false"/></div>
      <div class="msg">
        <p><?php echo $msg->getMsg(); ?></p>
        <time><?php echo $msg->getDataTime();?></time>
      </div>
      </li>
    <?php }else{ ?>
    <li class="other">
        <div class="avatar"><img src="https://i.imgur.com/DY6gND0.png" draggable="false"/></div>
      <div class="msg">
      <p><?php echo $msg->getMsg(); ?></p>
        <time><?php echo $msg->getDataTime();?></time>
      </div>
    </li>
    <?php } ?>
    <?php } ?>
    <?php } ?>
    </ol>
    <form action="<?php echo FRONT_ROOT . "ChatMessage/AddMSG" ?>" method="post" style="">
    <tr>
    <td><input class="textarea" name="newMSG" type="text" placeholder="Type here!"/>
        <div class="emojis">   
            <input type="submit" class="emojis" 
                      value="->"/>
        </div>
     </td>
     </tr>
    <input type="hidden" name="id_Chat" value="<?php echo $chat->getId_Chat() ?>" />
                   </form>
</div>