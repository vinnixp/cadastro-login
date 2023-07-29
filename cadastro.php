<?php

$servidor = "localhost";
$user = "root";
$password = "";
$bd = "cadlogin";


$conn = new mysqli($servidor,$user,$password,$bd);
if(!$conn){
    echo"deu errado";
}

if($_SERVER["REQUEST_METHOD"]=="POST"){

    /*
    print_r($_POST['usuario']);
    print_r('<br>');
    print_r($_POST['senha']);
    */


    //Recupera os valores do formulário

    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $confirmasenha = $_POST["confirmeSenha"];


    //Verifica se as senhas são iguais

    if($senha === $confirmasenha){
        $sql = "SELECT * FROM usuario WHERE usuario = '$usuario'";
        $retorno = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($retorno);


        if($row){
            echo"<script>alert('Esse usuário já existe!');</script>";
        }else{
            $hashsenha = password_hash($senha,  PASSWORD_BCRYPT);
            $sql = "INSERT INTO usuario (usuario,senha) values('$usuario','$hashsenha')";
            $retorno = mysqli_query($conn, $sql);

            if($retorno ===true){
                echo"<script>alert('Usuário cadastrado com sucesso!');</script>";
            }else{
                echo"Erro ao cadastrar". $conn->error;
            }

        }

    }else{
        echo"<script>alert('As senhas não são iguais!');</script>";
    }

}

$conn-> close();


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cadastro</title>
</head>
<body>

    <div class="login">
        <h1>Cadastre sua conta</h1>
        <form class="form"  action="cadastro.php" method="POST">

            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <label for="confirmeSenha">Confirme seu senha:</label>
            <input type="password" id="confirmeSenha" name="confirmeSenha" required>

            <button class="submit" type="submit">Cadastrar</button>
            

        </form>
    </div>
    
</body>
</html>