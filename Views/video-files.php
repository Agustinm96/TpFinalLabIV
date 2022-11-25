<?php
include_once('header.php');
include_once('nav-bar.php');
require_once('validate-session.php');

?>
<head>
    <meta charset="UTF-8">
    <title>PHP Video Uploads</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="main.css" />
</head>
<body>
    <h1>PHP Video Uploads</h1>
    <h2>Solo se acepta formato mp4</h2>
    <form action="<?php echo FRONT_ROOT."Pet/UploadVideo" ?>" method="post" enctype="multipart/form-data">
       <input type="hidden" name="MAX_FILE_SIZE" value="20000000"/>
        <p>
            <label for="video">Video</label>
            <input type="file" name="video" />
        </p>
        <p>
            <input type="submit" value="Upload" />
            <input type="hidden" name="PETID" value = <?php echo $PETID ?> />
        </p>
    </form>
</body>
</html>