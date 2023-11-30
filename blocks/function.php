<?php

function dbconnect(){
    try {
        $host = 'localhost';
        $dbName = 'f1';
        $user = 'root';
        $password = '';
        $pdo = new PDO(
            'mysql:host='.$host.';dbname='.$dbName.';charset=utf8',
            $user,
            $password);
        // Cette ligne demandera à pdo de renvoyer les erreurs SQL si il y en a
        $pdo->setAttribute(PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    catch (PDOException $e) {
        throw new InvalidArgumentException('Erreur connexion à la base de
données : '.$e->getMessage());
        exit;
    }
}


function displayBsClassForm($errors, $input){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(array_key_exists($input, $errors)){
            echo('is-invalid');
        } else {
            echo('is-valid');
        }
    }

}

function displayBsErrorForm($errors, $input){
    if(array_key_exists($input, $errors)){
        echo('<div  class="invalid-feedback">
        '.$errors[$input].'
      </div>');
    }
}

function keepFormValue($input, $result = ""){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        echo($_POST[$input]);
    } else {
        if(!empty($result)){
            echo(htmlentities($result[$input]));
        }
    }
}


?>