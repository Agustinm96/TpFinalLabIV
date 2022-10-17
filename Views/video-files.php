<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP File VIDEO Uploads</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="main.css" />
</head>
<body>
    <h1>PHP File VIDEO Uploads</h1>
    <form action="<?php echo FRONT_ROOT."Pet/UploadVideo" ?>" method="post" enctype="multipart/form-data">
       <input type="hidden" name="MAX_FILE_SIZE" value="20000000"/>
      <?php var_dump($PETID); ?>
        <p>
            <label for="video">VACCINATION PLAN</label>
            <input type="file" name="video" />
        </p>
        <p>
            <input type="submit" value="Upload" />
            <input type="hidden" name="PETID" value = <?php echo $PETID ?> />
        </p>
    </form>
</body>
</html>