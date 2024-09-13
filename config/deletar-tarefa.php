<?php
session_start();

include_once("./utilitarios.php");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["id"]) && empty($_GET["id"])) {
        $_SESSION["mensagem"] = "Erro: O ID da tarefa é obrigatório!";

        redirecionar("../index.php");
    } else {
        $id = limparEntrada($_GET["id"]);

        $validarID = validarID($id);

        if ($validarID !== true) {
            $_SESSION["mensagem"] = $validarID;

            redirecionar("../index.php");
        }
    }

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=listaTarefas", "root", "root1234");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("CALL procDeletarTarefa(?)");
        $sql->execute([$id]);

        $_SESSION["mensagem"] = "Tarefa deletada com sucesso!";

        redirecionar("../index.php");
    } catch (PDOException $e) {
        error_log("Erro ao deletar tarefa: " . $e->getMessage(), 0);

        $_SESSION["mensagem"] = "Erro ao deletar tarefa!";

        redirecionar("../index.php");
    }
} else {
    $_SESSION["mensagem"] = "Erro: Método de requisição não permitido!";

    redirecionar("../index.php");
}
