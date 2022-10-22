<?php
include_once('header.php');
include_once('nav-bar.php');
require_once('validate-session.php');

?>
<head>
    <meta charset="UTF-8">
    <title>PHP File Uploads</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="main.css" />
</head>
<body>
    <h1>PHP File Uploads</h1>
    <form action="<?php echo FRONT_ROOT."Pet/UploadPicture" ?>" method="post" enctype="multipart/form-data">
       <input type="hidden" name="MAX_FILE_SIZE" value="20000000"/>
        <p>
            <label for="pic">Image</label>
            <input type="file" name="pic" />
        </p>
        <p>
            <input type="submit" value="Upload" />
            <input type="hidden" name="PETID" value = <?php echo $PETID ?> />
        </p>
    </form>
</body>
</html>