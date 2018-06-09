<?php
require_once './../vendor/autoload.php';

use YoHang88\LetterAvatar\LetterAvatar;

$avatar = new LetterAvatar('Max Mustermann', 'square', 64);
$avatar->saveAs('./img.png')
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>
</head>
<body>
<img src="<?php echo $avatar;?>" alt="">
</body>
</html>