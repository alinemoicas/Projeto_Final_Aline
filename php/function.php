<?php
include_once ('ligaBD.php');
include_once ('settings.php');

    function verifica_dados($liga){
        if(isset($_POST['env']) && $_POST['env'] == "form"){
            $email = addslashes($_POST['email']);
            $sql = $liga->prepare("SELECT * FROM utilizador WHERE email = ?");
            $sql->bind_param("s", $_POST['email']);
            $sql->execute();
            $get = $sql->get_result();
            $total = $get->num_rows;

            if($total > 0){
                $dados = $get->fetch_assoc();
                add_dados_recover($liga, $email);
            }else {

            }
        }
    }

    function add_dados_recover($liga, $email){
        $rash = sha1(rand());
        $sql = $liga->prepare("INSERT INTO recupera_solicitacao (email, rash) VALUES (?, ?)");
        $sql->bind_param("ss", $email, $rash);
        $sql->execute();

        if($sql->affected_rows > 0){
            enviar_email($liga, $email, $rash);
        }
    }

    function enviar_email($liga, $email, $rash){
        $destinario = $email;

        $subject = "ALTERAÇÃO DE SENHA";
        $headers = "Mime-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message = "<html><head>";
        $message .= "
                <h2 style='margin-left: 20%;'> Processo de recuperação ou alteração de password!</h2>
                <br>
                <p style='margin-left: 20%;'> Foi solicitado a alteração senha no site FeelSync.</p>
                <br>
                <p style='margin-left: 20%;'> Por favor tenha em conta que esta ação irá alterar a sua palavra-passe atual.</p> 
                <br>
                <p style='margin-left: 20%;'> Para confirmar este processo por favor clique no seguinte link:</p> 
                <br>
                <a style='margin-left: 20%;' href='".recupera."?pagina=recupera&rash={$rash}'>".recupera."?pagina=recupera&rash={$rash}</a> 
                <br>
                <h5 style='margin-left: 20%;'> Se não solicitou este pedido por favor ignore este email.</h5>
                <h4 style='text-align: center;'> FeelSync</h4>
                ";
        $message .="</head></html>";

        if(mail($destinario, $subject, $message, $headers)){
            echo "<div class='alert alert-success'>Dados enviados com sucesso! Verifique o seu email.</div>";
        } else{
            echo "<div class='alert alert-danger'>Erro ao enviar email</div>".$sql->error;
        }
    }

    function verifica_rash($liga){
        if(isset($_POST['env']) && $_POST['env'] == "upd"){
            $npassword = addslashes(sha1($_POST['password']));
            $sql = $liga->prepare("SELECT * FROM recupera_solicitacao WHERE rash = ? AND status = 0");
            $sql->bind_param("s", $_GET['rash']);
            $sql->execute();
            $get = $sql->get_result();
            $total = $get->num_rows;

            if($total > 0){
                $dados = $get->fetch_assoc();
                atualiza_senha($liga, $dados['email'], $npassword);
                deleta_rashs($liga, $dados['email']);
                echo "<div class='alert alert-success'>Password alterada com sucesso!</div>";
                redireciona("?pagina=login");
            } else{
                echo "<div class='alert alert-danger'>Rash inválida</div>";
               }
        } 
    }

    function atualiza_senha($liga, $email, $password){
        $sql = $liga->prepare("UPDATE utilizador SET password = ? WHERE email = ?");
        $sql->bind_param("ss", $password,  $email);
        $sql->execute();

        if($sql->affected_rows > 0){
            return true;
        } else{
            return false;
        }
    }

    function deleta_rashs($liga, $email){
        $sql = $liga->prepare("DELETE FROM recupera_solicitacao WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();

        if($sql->affected_rows > 0){
            return true;
        } else{
            return false;
        }
    }

    function redireciona($dir){
        echo "<meta http-equiv='refresh' content='1; url={$dir}'>";
    }
?>