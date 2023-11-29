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
    if(empty($_POST["date_of_birth"])){
        $errors["date_of_birth"] = "Veuillez saisir une date de naissance";
    }
    if(empty($_POST["type"])){
        $errors["type"] = "Veuillez saisir un poste";
    }

    if(strtotime($_POST["date_of_birth"]) == false){
        $errors["date_of_birth"] = "Le format de la date est invalide !";
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
        if ($_FILES["image"]["error"] != 4) {
            move_uploaded_file($_FILES["photos"]["tmp_name"],$result["image"]);
        }
        $qury = $pdo->prepare("UPDATE `foot_2_ouf`.`users` SET name = :name , firstname = :firstname , date_of_birth = :date_of_birth , poste = :poste WHERE  id = :id;");
        $qury ->execute([
            "id"=>$_GET['modifier'],
            "name"=>$_POST['name'],
            "firstname"=>$_POST['lastname'],
            "date_of_birth"=>$_POST['date_of_birth'],
            "poste"=>$_POST['type'],
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

<h1>Bonjour <?php
    echo ($_SESSION["user"]);
    ?></h1>
<section class="login-container">
    <div class="">
        <h4 class="text-dark">Ajouter un Joueur</h4>

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
                <input class="form-control <?php displayBsClassForm($errors, 'date_of_birth');?>"
                       type="date" name="date_of_birth" placeholder="Date de Naisance" required="required"
                       value="<?php keepFormValue("date_of_birth", $result);?>"/>
                <?php displayBsErrorForm($errors, 'date_of_birth'); ?>
            </div>
            <!---------------------------------------------------------------------------->
            <div class="form-group">
                <select  name="type" class="form-select mb-3">
                    <?php
                    $types = ["Gardien","Attaquant","Milieu","Défenseur"];
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
            <input type="file" class="form-control mb-3" name="photos">

            <!---------------------------------------------------------------------------->
            <button type="submit">Ajouter un Joueur</button>
        </form>
    </div>

</section>




<?php
include "blocks/js.php";
?>
</body>
</html>


