<?php
session_start();
include "blocks/function.php";
$pdo = dbconnect();
$query = $pdo->query('SELECT * FROM users ORDER BY minutes,seconde,centiemes');
$resultas = $query->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php
    include "blocks/style.php"
    ?>
    <title>Document</title>
</head>
<body>

<?php
include "blocks/header.php"
?>


<section class="d-flex justify-content-center align-items-center podium">
    <img class="podiumdeouf" src="assets/podium-removebg-preview.png" alt="">
    <?php
        for ($i =0;$i <3;$i++){
            echo('<img class="image-podium p'.$i.'" src="'.$resultas[$i]["image"].'" alt="">');
        }
    ?>
</section>

<div class="container marge">
    <div class="row">
        <?php
        for ($i =0;$i <3;$i++){
            $nomPernom = $resultas[$i]["firstname"] . " " . $resultas[$i]["name"];
            echo(' <div class="font d-flex justify-content-center col-4 t'.$i.'">'.$nomPernom.'</div>');
        }
        ?>
    </div>

</div>




<?php
include "blocks/js.php"
?>
</body>
</html>
