<?php
include "ligaBD.php";

require_once "mail.php";

$nome = $_POST['nome'];
$email = $_POST['email'];
$cargo = $_POST['cargo'];
$password = $_POST['password'];


$consulta = $liga->query("SELECT email FROM utilizador WHERE email='$email'");
$exibe = $consulta->fetch_assoc();

if(mysqli_num_rows($consulta) ){
    echo "<div class='alert alert-danger'>Email já cadastrado!</div>";
} else{
    $query = "INSERT INTO utilizador (nome, email, cargo, password) VALUES('$nome','$email', '$cargo', '$password')";
        if(mysqli_query($liga,$query)){
            $destinario = $_POST['email'];
            if(isset($_POST['nome']) && !empty(['nome']) && isset($_POST['email']) && !empty(['email']) && isset($_POST['cargo']) && !empty(['cargo'])  && isset($_POST['password']) && !empty(['password'])){

                $assunto = "🎉 Bem-vindo(a) à FeelSync";
                $mensagem = "<html><head>
                            <div style= border-radius: 5px; width: 100%; padding: 10px;'>
                            <h3 style='margin-left: 3%;'> O seu registo foi efetuado com sucesso na APP FeelSync – Comece hoje a acompanhar o bem-estar da sua empresa!</h3>
                            <hr>
                            <p style='margin-left: 3%;'> 
                            É com muito gosto que lhe damos as boas-vindas à FeelSync, a sua nova plataforma de análise de indicadores de bem-estar.</p>
                            <p style='margin-left: 3%;'> Na FeelSync, acreditamos que compreender os seus dados é o primeiro passo para melhorar a sua qualidade de vida. A nossa plataforma foi criada para lhe oferecer uma experiência clara, intuitiva e personalizada, ajudando-o(a) a acompanhar métricas relevantes, identificar tendências e tomar decisões mais conscientes sobre a sua saúde e bem-estar.</p>
                            <p style='margin-left: 3%;'> A sua conta já está ativa. Basta iniciar sessão e começar a explorar os recursos disponíveis.</p>
                            <p style='margin-left: 3%;'> 🔗 Aceda agora: https://www.feelsync.com </p>
                            <p style='margin-left: 3%;'> Se tiver alguma dúvida ou precisar de ajuda, a nossa equipa está sempre disponível para o(a) apoiar: 
                            support@feelsync.com
                            </p> 
                            <p style='margin-left: 3%;'> Obrigado por confiar na FeelSync. Estamos felizes por tê-lo(a) connosco nesta jornada.</p>
                            <p style='margin-left: 3%;'> Com estima, </p>
                            <h4 style='margin-left: 3%;'> Equipa FeelSync </h4>
                            </div>
                            </head></html>";
            if(send($assunto, $mensagem, $email)){
                    echo "Enviado";
                 } else{
                    echo "<div class='alert alert-danger'>Erro ao enviar email</div>";
                }
            } else{
                echo "<div class='alert alert-danger'>Preencha todos os campos</div>";
            }  
        }
            header("Location: ../html/index.html"); 
}
mysqli_close($liga);
?>