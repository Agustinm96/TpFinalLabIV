<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap.min.css">
    <link href="<?php echo CSS_PATH;?>layout.css" rel="stylesheet" type="text/css" media="all">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Factura</title>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-10 ">
            <h1>Factura</h1>
        </div>
        <div class="col-xs-2">
            <img src="<?php echo FRONT_ROOT . IMG_PATH."logo.jpg";?>" alt="logo">
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-10">
            <h1 class="h6"><?php $remitente = $reserve->getAvailability()->getKeeper()->getUser()->getFirstName() . " " . $reserve->getAvailability()->getKeeper()->getUser()->getLastName(); echo $remitente?></h1>
            <h1 class="h6"><?php echo "PetHero.com" ?></h1>
        </div>
        <div class="col-xs-2 text-center">
            <strong>Fecha de Reserva</strong>
            <br>
            <?php echo $reserve->getAvailability()->getDate()?>
            <br>
            <strong>Factura No.</strong>
            <br>
            <?php echo $reserve->getId() ?>
        </div>
    </div>
    <hr>
    <div class="row text-center" style="margin-bottom: 2rem;">
        <div class="col-xs-6">
            <h1 class="h2">Cliente</h1>
            <strong><?php $cliente = $reserve->getPet()->getId_User()->getFirstName() . " " . $reserve->getPet()->getId_User()->getLastName(); echo $cliente?></strong>
        </div>
        <div class="col-xs-6">
            <h1 class="h2">Remitente</h1>
            <strong><?php echo $remitente ?></strong>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-condensed table-bordered table-striped">
                <thead>
                <tr>
                    <th>Mascota a Cuidar</th>
                    <th>Tipo de mascota</th>
                    <th>Precio de estadía</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $reserve->getPet()->getName()?></td>
                        <td><?php echo $reserve->getPet()->getPetType()->getPetTypeName()?></td>
                        <td>$<?php echo $reserve->getAvailability()->getKeeper()->getPriceToKeep()?></td>
                        <td>$<?php echo $reserve->getAvailability()->getKeeper()->getPriceToKeep()?></td>
                    </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-center">
            <p class="h5"><?php echo "Gracias por elegir Pet Hero :)" ?></p>
        </div>
    </div>
</div>
</body>
</html>