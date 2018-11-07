<?php


    //Verifica se vem valor para cadastro
if(isset($_POST["firstname"])){
    $nome =  $_POST["firstname"];
    $fone = $_POST["fone"];
    $celular = $_POST["celular"];
    $email = $_POST["email"];

    $conexao  = mysqli_connect("localhost", "root", "", "agenda");


    $sql = "INSERT INTO contato (nome, fone, celular, email)
VALUES ('$nome', '$fone', '$celular', '$email')";

if ($conexao->query($sql) === TRUE) {
    echo "Cadastro efetuado com sucesso";
    header('Location: http://localhost:8080/agenda/index.html');
} else {
    echo "Error: " . $sql . "<br>" . $conexao->error;
}
}


// Verifica se existe a variável txtnome
if (isset($_GET["txtnome"])) {
    $nome = $_GET["txtnome"];
    $conexao  = mysqli_connect("localhost", "root", "", "agenda");

    // mysqli_select_db($base);
    // Verifica se a variável está vazia
    if (empty($nome)) {
        $sql = "SELECT * FROM contato";
    } elseif ($nome != 'listar')  {
        $nome .= "%";
        $sql =  mysqli_query($conexao, "SELECT * FROM contato WHERE nome like '$nome'");
     } else {
        $nome .= "%";
        $sql =  mysqli_query($conexao, "SELECT * FROM contato");
     }

    sleep(1);
    $result = $sql;
    $cont = mysqli_affected_rows($conexao);
    // Verifica se a consulta retornou linhas 
    if ($cont > 0) {
        // Atribui o código HTML para montar uma tabela
        $tabela = "<table border='1'>
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>TELEFONE</th>
                            <th>CELULAR</th>
                            <th>EMAIL</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>";
        $return = "$tabela";
        // Captura os dados da consulta e inseri na tabela HTML
        while ($linha = mysqli_fetch_array($result)) {
            $return.= "<td>" . utf8_encode($linha["NOME"]) . "</td>";
            $return.= "<td>" . utf8_encode($linha["FONE"]) . "</td>";
            $return.= "<td>" . utf8_encode($linha["CELULAR"]) . "</td>";
            $return.= "<td>" . utf8_encode($linha["EMAIL"]) . "</td>";
            $return.= "</tr>";
        }
        echo $return.="</tbody></table>";
    } else {
        // Se a consulta não retornar nenhum valor, exibi mensagem para o usuário
        echo "Não foram encontrados registros!";
    }
}
?>