<?php
session_start();

include_once("./utilitarios.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["titulo"]) && empty($_POST["titulo"])) {
        $_SESSION["mensagem"] = "Erro: Por favor, informe um título para sua tarefa!";

        redirecionar("../index.php");
    } else {
        $titulo = limparEntrada($_POST["titulo"]);

        $_SESSION["titulo"] = $titulo;

        if (!validarComprimentoTexto($titulo, 30)) {
            $_SESSION["mensagem"] = "Erro: Por favor, informe um título com até 30 caracteres!";
            $_SESSION["titulo"] = "";

            redirecionar("../index.php");
        }
    }

    if (isset($_POST["descricao"]) && empty($_POST["descricao"])) {
        $_SESSION["mensagem"] = "Erro: Por favor, informe uma descrição para sua tarefa!";

        redirecionar("../index.php");
    } else {
        $descricao = limparEntrada($_POST["descricao"]);

        $_SESSION["descricao"] = $descricao;

        if (!validarComprimentoTexto($descricao, 50)) {
            $_SESSION["mensagem"] = "Erro: Por favor, informe uma descrição com até 50 caracteres!";
            $_SESSION["descricao"] = "";

            redirecionar("../index.php");
        }
    }

    unset($_SESSION["titulo"]);
    unset($_SESSION["descricao"]);

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=listaTarefas", "root", "root1234");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("CALL procCadastrarTarefa(?, ?)");
        $sql->execute([$titulo, $descricao]);

        $_SESSION["mensagem"] = "Tarefa cadastrada com sucesso!";

        redirecionar("../index.php");
    } catch (PDOException $e) {
        error_log("Erro ao cadastrar tarefa: " . $e->getMessage(), 0);

        $_SESSION["mensagem"] = "Erro ao cadastrar tarefa!";

        redirecionar("../index.php");
    }
} else {
    $_SESSION["mensagem"] = "Erro: Método de requisição não permitido!";

    redirecionar("../index.php");
}
