<?php
session_start();
include ("blocks/function.php");
include "blocks/redirection.php";
redirectionConnectionIsConected();
$pdo = dbconnect();
$errors = [];
$types = ["Gardien","Attaquant","Milieu","Défenseur"];

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
    if(empty($_POST["date_of_birth"])){
        $errors["date_of_birth"] = "Veuillez saisir une date de naissance";
    }
    if(empty($_POST["type"])){
        $errors["type"] = "Veuillez saisir un poste";
    }

    if(strtotime($_POST["date_of_birth"]) == false){
        $errors["date_of_birth"] = "Le format de la date est invalide !";
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
    if (count($resultas) < 23 && count($errors) == 0 ) {
        if (!in_array($_POST["type"],$types)) {
            $errors ["result"] = "Hop Hop jeune fourbe";
        }else{
            $nameAssets = "assets/" . uniqid() . '-' . $_FILES["photos"]["name"];
            move_uploaded_file($_FILES["photos"]["tmp_name"], $nameAssets);
            $qury = $pdo->prepare("INSERT INTO `f1`.`users` (`name`, `firstname`, `date_of_birth`, `poste`,`image`) VALUES (:name, :firstname, :date_of_birth, :poste, :image)");
            $qury->execute([
                "name" => $_POST['name'],
                "firstname" => $_POST['lastname'],
                "date_of_birth" => $_POST['date_of_birth'],
                "poste" => $_POST['type'],
                "image" => $nameAssets,
            ]);
            redirectionIndex();
        }
    } else {
        $errors ["result"] = "La limite de 23 joueur et atteinte";
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
        <h4 class="text-dark">Ajouter un Joueur</h4>

        <form action="" method="post" enctype="multipart/form-data">
            <p>Nombre de joueur max : <br>
                <?php
                echo (count($resultas));
                ?>
                /23
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
            <input class="form-control <?php displayBsClassForm($errors, 'date_of_birth');?>"
                   type="date" name="date_of_birth" placeholder="Date de Naisance" required="required"
                   value="<?php keepFormValue("date_of_birth");?>"/>
                <?php displayBsErrorForm($errors, 'date_of_birth'); ?>
            </div>
            <!---------------------------------------------------------------------------->
            <div class="form-group">
                <select name="type" class="form-select mb-3">
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
