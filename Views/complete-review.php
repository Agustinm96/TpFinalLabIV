<?php
include_once('header.php');
require_once('validate-session.php');

?>

<div id="breadcrumb" class="hoc clear"> 
    <h6 class="heading">Answering Review</h6>
  </div>
</div>

<main class="registerDog" style="width: 95%; max-width: 1200px;"> 
<div class="content" >
    <div id="comments" style="align-items:center;">
        <h2>Complete the information about
             <?php echo $review->getId_Keeper()->getLastName() . " " .
             $review->getId_Keeper()->getUserName()  ?></h2>
    </div>
        <form action="<?php echo FRONT_ROOT . "Review/CompleteReview" ?>" method = "post">
            <table style="align-items:center;"> 
             <thead>
                <div>              
                 <tr>
                 <th> Califique el servicio del Keeper <?php echo $review->getId_Keeper()->getLastName() ?></th>
                 <td style="max-width: 120px;">    
                 <select name="score" cols="80" rows="1" required>
                     <option value="1">1</option>
                     <option value="2">2</option>   
                     <option value="3">3</option> 
                     <option value="3">4</option>
                     <option value="3">5</option>
                 </td>
                 </tr>
                </div> 
                     <div> 
                     <tr>
                     <th>Que comentario puedes dejarnos al respecto ?</th>
                     <td>
                     <textarea name="review" style="margin-top: 3%;min-height: 100px;height: 75px;max-width: 500px" required></textarea>
                     </td>
                     </tr>
                    </div> 
            </thead>
            <div>
              <input type="hidden" name="id_Review" value= "<?php echo  $review->getId_Review()?>" />
              <input type="submit" class="btn" value="Completar" style="background-color:#DC8E47;color:white;"/>
            </div>
            </table>
        </form>
</div>
<div id="" class="hoc clear"> 
<form action="<?php echo FRONT_ROOT . "Home/showAddView" ?>" method = "get">
<input type="submit" class="btn" value="VOLVER" style="background-color:#DC8E47;color:white;"/>
</form>

</div>