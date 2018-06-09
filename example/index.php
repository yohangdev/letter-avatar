<?php
require_once './../vendor/autoload.php';

use YoHang88\LetterAvatar\LetterAvatar;

$avatar = new LetterAvatar('Max Mustermann', 'circle', 64);
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Example</title>
</head>
<body>
    <img src="<?php echo $avatar;?>" alt="">
</body>
</html>