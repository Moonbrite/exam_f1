<?php
session_start();
if(!array_key_exists("user",$_SESSION)) {
    header('Location: connection.php');
    exit();
}
include ("blocks/function.php");
$pdo = dbconnect();
$errors = [];

if(array_key_exists("user",$_SESSION)) {
    if (array_key_exists("modifier",$_GET)){
        $query = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $query->execute(["id"=>$_GET['modifier']]);
        $result = $query->fetch();
    }
}
$allwoedExtension =["image/jpeg","image/png"];
if($_SERVER["REQUEST_METHOD"]=="POST") {
    if(empty($_POST["lastname"])){
        $errors["lastname"] = "Veuillez saisir un nom";
    }
    if(empty($_POST["name"])){
        $errors["name"] = "Veuillez saisir un prénom";
    }
    if(empty($_POST["type"])){
        $errors["type"] = "Veuillez saisir un écurie";
    }

    if ($_FILES["photos"]["error"] != 0 and $_FILES["photos"]["error"] != 4){
        $errors [] ="inconu";
    }
    if (in_array($_FILES["photos"]["type"],$allwoedExtension)){
        if ($_FILES["photos"]["size"]>2097152){
            $errors [] = "tros grosse";
        }
    }
    if ($_FILES["photos"]["error"] != 4) {
        $erros_uplod = $errors;
        if (!empty($erros_uplod)){
            $errors["image"] = $erros_uplod;
        }
    }

    if (count($errors)== 0) {
        if ($_FILES["photos"]["error"] != 4) {
            move_uploaded_file($_FILES["photos"]["tmp_name"],$result["image"]);
        }
        $qury = $pdo->prepare("UPDATE `f1`.`users` SET name = :name , firstname = :firstname ,minutes = :minutes ,seconde = :seconde,centiemes = :centiemes, poste = :poste WHERE  id = :id;");
        $qury->execute([
            "name" => $_POST['name'],
            "firstname" => $_POST['lastname'],
            "minutes" => $_POST['minutes'],
            "seconde" => $_POST['seconde'],
            "centiemes" => $_POST['centiemes'],
            "poste" => $_POST['type'],
            "id"=>$result["id"],
        ]);
        header('Location: index.php');
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
    <?php
    include "blocks/style.php";
    ?>
    <title>admin</title>
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
        <h4 class="text-dark">Modifier un Pilote</h4>

        <form action="" method="post" enctype="multipart/form-data">
            <!---------------------------------------------------------------------------->
            <div class="form-group">
                <input class="form-control <?php displayBsClassForm($errors, 'lastname');?>"
                       type="text" name="lastname" placeholder="Nom" required="required"
                       value="<?php keepFormValue("firstname", $result);?>"/>
                <?php displayBsErrorForm($errors, 'lastname'); ?>
            </div>

            <!--------------------------------------------------------------------------->

            <div class="form-group">
                <input class="form-control <?php displayBsClassForm($errors, 'name');?>"
                       type="text" name="name" placeholder="Prenom" required="required"
                       value="<?php keepFormValue("name", $result);?>"/>
                <?php displayBsErrorForm($errors, 'name'); ?>
            </div>
            <!---------------------------------------------------------------------------->
            <div class="form-group">
                <label class="mb-2" for="">Minutes</label>
                <input class="form-control <?php displayBsClassForm($errors, 'minutes');?>"
                       type="number" name="minutes" placeholder="Minutes" required="required"
                       value="<?php keepFormValue("minutes", $result);?>"/>
                <?php displayBsErrorForm($errors, 'minutes'); ?>
            </div>
            <!---------------------------------------------------------------------------->
            <div class="form-group">
                <label class="mb-2" for="">Seconde</label>
                <input class="form-control <?php displayBsClassForm($errors, 'seconde');?>"
                       type="number" name="seconde" placeholder="Seconde" required="required"
                       value="<?php keepFormValue("seconde", $result);?>"/>
                <?php displayBsErrorForm($errors, 'seconde'); ?>
            </div>
            <!---------------------------------------------------------------------------->
            <div class="form-group">
                <label class="mb-2" for="">Centièmes</label>
                <input class="form-control <?php displayBsClassForm($errors, 'centiemes');?>"
                       type="number" name="centiemes" placeholder="Centièmes" required="required"
                       value="<?php keepFormValue("centiemes", $result);?>"/>
                <?php displayBsErrorForm($errors, 'centiemes'); ?>
            </div>
            <!---------------------------------------------------------------------------->
            <div class="form-group">
                <label class="mb-2" for="">Ecurie</label>
                <select  name="type" class="form-select mb-3">
                    <?php
                    $types = ["Alfa Roméo","AlphaTauri","Alpine","Aston Martin","Ferrari","Haas","McLaren","Mercedes","Red Bull","Williams"];
                    foreach($types as $type){
                        $actif = '';
                        if($_SERVER["REQUEST_METHOD"]=='POST' && $_POST["type"] == $type || $result["poste"] == $type){
                            $actif = 'selected';
                        }
                        echo('<option '.$actif.' value="'.$type.'">'.$type.'</option>');
                    }
                    ?></select>
                <?php displayBsErrorForm($errors, 'type'); ?>
            </div>
            <!---------------------------------------------------------------------------->

            <div>
                <?php
                echo ('<img class="img-previsu img-thumbnail mb-3" src="'.htmlspecialchars($result["image"]).'?id='.uniqid().'" alt="">');
                ?>
            </div>

            <label class="mb-2" for="">Photo</label>
            <input type="file" class="form-control mb-3" name="photos">

            <!---------------------------------------------------------------------------->
            <button type="submit">Modifier le Pilote</button>
        </form>
    </div>

</section>




<?php
include "blocks/js.php";
?>
</body>
</html>


