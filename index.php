<?php
session_start();
include "blocks/function.php";
$pdo = dbconnect();
if (array_key_exists("postes",$_GET)) {
    $query = $pdo->prepare('SELECT * FROM users WHERE poste = :poste');
    $query->execute(["poste" => $_GET['postes']]);
    $resultas = $query->fetchAll();
}else{
    $query = $pdo->query('SELECT * FROM users ORDER BY minutes,seconde,centiemes');
    $resultas = $query->fetchAll();
}


if(array_key_exists("user",$_SESSION)) {
    if (array_key_exists("suprimer",$_GET)){

        $queryFilePath = $pdo->prepare("SELECT image FROM users WHERE id = :id");
        $queryFilePath->execute(["id" => $_GET['suprimer']]);
        $filePath = $queryFilePath->fetch();
        $file =$filePath["image"];
        unlink($file);

        $query = $pdo->prepare("DELETE  FROM users WHERE id = :id");
        $query->execute(["id"=>$_GET['suprimer']]);

        header("Location:index.php");
        exit();

    }if (array_key_exists("suprimertout",$_GET)){

        $queryAllFilePaths = $pdo->query("SELECT image FROM users");
        $allFilePaths = $queryAllFilePaths->fetchAll(PDO::FETCH_COLUMN);

        $query = $pdo->query("DELETE FROM users");
        $query->execute();

        foreach ($allFilePaths as $filePath) {
            if (!empty($filePath) && file_exists($filePath)) {
                unlink($filePath);
            }
        }
        header("Location:index.php");
        exit();
    }
}


?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!---------------------------------------------------------------------------->
    <?php
    include "blocks/style.php"
    ?>
    <!---------------------------------------------------------------------------->
    <title>CL</title>
</head>

<body>
<!---------------------------------------------------------------------------->
<?php
include "blocks/header.php"
?>
<!---------------------------------------------------------------------------->

<section class="">
    <?php
    if (!array_key_exists("postes",$_GET)) {
        echo ('<h1 class="text-center mb-5">Les meilleur pilote</h1>');
    }else{
        echo ('<h1 class="text-center mb-5">Les pilote de '.($_GET["postes"]).'</h1>');
    }
    ?>
    <!---------------------------------------------------------------------------->
    <div class="container row m-auto mb-5 flex-row-reverse">
        <?php
        $placeSurlePodium = 0;
        foreach ($resultas as $resulta) {
            $placeSurlePodium++;
            $nomPernom = $resulta["firstname"] . " " . $resulta["name"];
            $timer = $resulta["minutes"]. ":" .$resulta["seconde"]. ".".$resulta["centiemes"];
            echo('<div class="col-lg-6 ');if(!array_key_exists("postes",$_GET)){ echo ('decalage');} echo('"><div class="card">
            <div class="card-body text-center ');
            if (array_key_exists("postes",$_GET)) { echo ($_GET["postes"]);}
            echo ('">');
            if (!array_key_exists("postes",$_GET)){
                echo (' <h2>'.$placeSurlePodium.'</h2>');
            }
            if (array_key_exists("postes",$_GET)){
                echo ('<img src="'.$resulta['image'].'?id='.uniqid().'" alt="">');
            }
            echo('<h5 class="card-title">' . htmlspecialchars($nomPernom) . '</h5>
            <p class="card-text">Temps de la course : ' . htmlspecialchars($timer) . '</p>
            <p class="card-text ' . htmlspecialchars($resulta["poste"]) . ' ">Poste : ' . htmlspecialchars($resulta["poste"]) . '</p>');
            if (array_key_exists("user", $_SESSION)) {
                echo('<a class="btn btn-danger" href="?suprimer=' . htmlspecialchars($resulta["id"]) . '">Suprimer le joueur</a>
                        <a class="btn btn-success" href="edit.php?modifier=' . htmlspecialchars($resulta["id"]) . '">Modifier le joueur</a>');
            }
            echo('</div></div></div>');
        }
        ?>
    </div>
    <!---------------------------------------------------------------------------->
    <?php
    if (array_key_exists("user",$_SESSION)) {
        if (count($resultas) > 0 ) {
            echo ('<div class="text-center"><h3>Tout suprimer</h3><a class="btn btn-danger text-center mb-3" href="?suprimertout=all">Suprimer tout les joueurs</a></div>');
        }else{
            echo ('<h2 class="text-center">Pas de Joueur</h2>');
        }
    }
    ?>
</section>

<?php
include "blocks/arrow_scroll.php"
?>
<!---------------------------------------------------------------------------->
<?php
include "blocks/js.php"
?>
<!---------------------------------------------------------------------------->
</body>
</html>
