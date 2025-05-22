<?php
include ('ligaBD.php');

if(isset($_POST['email']) || isset($_POST['password'])){

    if(strlen($_POST['email']) == 0){
        echo"Prencha o seu email!";
    } else if(strlen($_POST['password']) == 0){
        echo "Preencha a sua password!";
    } else {

        $email = $liga->real_escape_string($_POST['email']);
        $password = $liga->real_escape_string($_POST['password']);

        $sql_code = "SELECT * FROM utilizador WHERE email = '$email' AND password = '$password'";
        $sql_query = $liga->query($sql_code) or die("Falha na execução do código SQL".$mysqli->error);

        $quantidade = $sql_query->num_rows;

        if($quantidade == 1){
            $user = $sql_query->fetch_assoc();

            if(isset($_SESSION)){
                session_start();
            }

            $_SESSION['id'] = $user['id'];
            $_SESSION['nome'] = $user['nome'];

  
            header("Location: ../html/index.html");
        }else {
            #echo "<script>alert('Email ou password incorretos!');</script>";
            echo"<div class='alert alert-danger'>Email ou password incorretos!</div>";
        }
    }
}
?>