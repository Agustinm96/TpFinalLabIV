<?php
include_once('header.php');
?>

<div id="breadcrumb" class="hoc clear"> 
<table style="text-align:center">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Name</th>
                            <th style="width: 170px;">Last Name</th>
                            <th style="width: 120px;">Email</th>
                            <th style="width: 400px;">Phone Number</th>
                            <th style="width: 110px;">SCORE</th>
                            <th style="width: 110px;">Review Counts</th>
                        </tr>
                    </thead>
                    <tbody>
                                <td><?php echo $keeper->getFirstName() ?></td>
                                <td><?php echo $keeper->getLastName() ?></td>
                                <td><?php echo $keeper->getEmail() ?></td>
                                <td><?php echo $keeper->getPhoneNumber() ?></td>  
                                <td><?php echo $score ?></td>
                                <td><?php echo $scoreCount?></td>
                    </tbody>
                    <th style="width: 100px;">Comentarios</th>
                   <?php if(!is_null($reviewList)){ ?>
                    <?php foreach($reviewList as $review){ ?>
                        <th style="width: 100px;">User</th>
                        <th style="width: 170px;">Comentario</th>
                        <td><?php echo $review->getId_Owner()->getLatstName() . " " .
                         $review->getId_Owner()->getFirstName() ?></td>
                                <td><?php echo $review->getReview() ?></td>
                        <?php } ?>
                        <?php }else{ ?>
                            <th style="width: 170px;">Este keeper No posee Comentarios Aun</th>
                            <?php } ?>
                </table>

                        </div>