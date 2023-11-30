<?php
session_start();
include ("blocks/function.php");
include "blocks/redirection.php";
redirectionConnectionIsConected();
$pdo = dbconnect();
$errors = [];
$types = ["Alfa Roméo","AlphaTauri","Alpine","Aston Martin","Ferrari","Haas","McLaren","Mercedes","Red Bull","Williams"];

$query = $pdo->query('SELECT * FROM users');
$resultas = $query->fetchAll();
$allwoedExtension = ["image/jpeg", "image/png", "image/webp"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["lastname"])){
        $errors["lastname"] = "Veuillez saisir un nom";
    }
    if(empty($_POST["name"])){
        $errors["name"] = "Veuillez saisir un prénom";
    }
    if(empty($_POST["type"])){
        $errors["type"] = "Veuillez saisir un poste";
    }

    if(empty($_POST["minutes"])){
        $errors["minutes"] = "Veuillez saisir une minutes";
    }elseif (!is_numeric($_POST["minutes"])){
        $errors["minutes"] = "Veuillez saisir un chiffre";
    }

    if(empty($_POST["seconde"])){
        $errors["seconde"] = "Veuillez saisir une seconde";
    }elseif (!is_numeric($_POST["seconde"])){
        $errors["seconde"] = "Veuillez saisir un chiffre";
    }elseif ($_POST["seconde"] > 60){
        $errors["seconde"] = "Veuillez saisir un chiffre en dessous de la minutes";
    }

    if(empty($_POST["centiemes"])){
        $errors["centiemes"] = "Veuillez saisir une centiemes";
    }elseif (!is_numeric($_POST["centiemes"])){
        $errors["centiemes"] = "Veuillez saisir un chiffre";
    }elseif ($_POST["centiemes"] > 1000){
        $errors["centiemes"] = "Veuillez saisir un chiffre en dessous de la seconde";
    }

    if ($_FILES["photos"]["error"] != 0) {
        $errors [] = "inconu";
    }
    if (in_array($_FILES["photos"]["type"], $allwoedExtension)) {
        if ($_FILES["photos"]["size"] > 2097152) {
            $errors [] = "tros grosse";
        }
    } else {
        $errors [] = "Pas bon";
    }
    if (count($resultas) < 20 && count($errors) == 0 ) {
        if (!in_array($_POST["type"],$types)) {
            $errors ["result"] = "Hop Hop jeune fourbe";
        }else{
            $nameAssets = "assets/" . uniqid() . '-' . $_FILES["photos"]["name"];
            move_uploaded_file($_FILES["photos"]["tmp_name"], $nameAssets);
            $qury = $pdo->prepare("INSERT INTO `f1`.`users` (`name`, `firstname`,`minutes`,`seconde`,`centiemes`, `poste`,`image`) VALUES(:name, :firstname, :minutes, :seconde, :centiemes, :poste, :image)");
            $qury->execute([
                "name" => $_POST['name'],
                "firstname" => $_POST['lastname'],
                "minutes" => $_POST['minutes'],
                "seconde" => $_POST['seconde'],
                "centiemes" => $_POST['centiemes'],
                "poste" => $_POST['type'],
                "image" => $nameAssets,
            ]);
            redirectionIndex();
        }
    } else {
        $errors ["result"] = "La limite de 20 Pilotes et atteinte";
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
    <?php
    include "blocks/style.php";
    ?>
    <title>Edit</title>
</head>
<body>
<?php
include "blocks/header.php";
?>

<h1 class="text-center">Bonjour <?php
    echo ($_SESSION["user"]);
    ?></h1>
<section class="login-container">
    <div class="">
        <h4 class="text-dark">Ajouter un Pilote</h4>

        <form action="" method="post" enctype="multipart/form-data">
            <p>Nombre de Pilote max : <br>
                <?php
                echo (count($resultas));
                ?>
                /20
            </p>
            <!---------------------------------------------------------------------------->
            <div class="form-group">
            <input class="form-control <?php displayBsClassForm($errors, 'lastname');?>"
                   type="text" name="lastname" placeholder="Nom" required="required"
                   value="<?php keepFormValue("lastname");?>"/>
                <?php displayBsErrorForm($errors, 'lastname'); ?>
            </div>

            <!--------------------------------------------------------------------------->

            <div class="form-group">
            <input class="form-control <?php displayBsClassForm($errors, 'name');?>"
                   type="text" name="name" placeholder="Prenom" required="required"
                   value="<?php keepFormValue("name");?>"/>
                <?php displayBsErrorForm($errors, 'name'); ?>
            </div>
            <!---------------------------------------------------------------------------->
            <div class="form-group">
                <label class="mb-2" for="">Minutes</label>
            <input class="form-control <?php displayBsClassForm($errors, 'minutes');?>"
                   type="number" name="minutes" placeholder="Minutes" required="required"
                   value="<?php keepFormValue("minutes");?>"/>
                <?php displayBsErrorForm($errors, 'minutes'); ?>
            </div>
            <!---------------------------------------------------------------------------->
            <div class="form-group">
                <label class="mb-2" for="">Seconde</label>
                <input class="form-control <?php displayBsClassForm($errors, 'seconde');?>"
                       type="number" name="seconde" placeholder="Seconde" required="required"
                       value="<?php keepFormValue("seconde");?>"/>
                <?php displayBsErrorForm($errors, 'seconde'); ?>
            </div>
            <!---------------------------------------------------------------------------->
            <div class="form-group">
                <label class="mb-2" for="">Centièmes</label>
                <input class="form-control <?php displayBsClassForm($errors, 'centiemes');?>"
                       type="number" name="centiemes" placeholder="Centièmes" required="required"
                       value="<?php keepFormValue("centiemes");?>"/>
                <?php displayBsErrorForm($errors, 'centiemes'); ?>
            </div>
            <!---------------------------------------------------------------------------->
            <div class="form-group">
                <label class="mb-2" for="">Ecurie</label>
                <select name="type" class="form-select ">
                    <option></option>
                    <?php
                    foreach($types as $type){
                        if($_SERVER["REQUEST_METHOD"]=='POST' && $_POST["type"] == $type){
                            $actif = 'selected';
                        }
                        echo('<option value="'.$type.'">'.$type.'</option>');
                    }
                    ?>
                </select>
                <?php displayBsErrorForm($errors, 'type'); ?>
            </div>
            <!---------------------------------------------------------------------------->
            <label class="mb-2"" for="">photo</label>
            <input type="file" class="form-control mb-3" name="photos">

            <!---------------------------------------------------------------------------->
            <button type="submit">Ajouter un Pilote</button>
            <?php
            if (count($errors)>0){
                echo ('<div>'.$errors["result"].'</div>');
            }

            ?>
            <div>

            </div>
        </form>
    </div>
</section>


<?php
include "blocks/js.php";
?>
</body>
</html>
