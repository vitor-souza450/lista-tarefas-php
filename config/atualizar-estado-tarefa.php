<?php
session_start();

include_once("./utilitarios.php");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["concluida"]) && empty($_GET["id"])) {
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

    if (isset($_GET["concluida"]) && empty($_GET["concluida"]) && $_GET["concluida"] !== "0") {
        $_SESSION["mensagem"] = "Erro: Não foi possível verificar se a tarefa está concluída!";

        redirecionar("../index.php");
    } else {
        $concluida = limparEntrada($_GET["concluida"]);

        switch ($concluida) {
            case "0":
                $concluida = 1;

                break;
            case "1":
                $concluida = 0;

                break;
            default:
                $_SESSION["mensagem"] = "Erro: Não foi possível verificar se a tarefa está concluída!";

                redirecionar("../index.php");
        }
    }

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=listaTarefas", "root", "root1234");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("CALL procAtualizarEstadoTarefa(?, ?)");
        $sql->execute([$id, $concluida]);

        redirecionar("../index.php");
    } catch (PDOException $e) {
        error_log("Erro ao atualizar estado da tarefa: " . $e->getMessage(), 0);

        $_SESSION["mensagem"] = "Erro ao atualizar estado da tarefa!";

        redirecionar("../index.php");
    }
} else {
    $_SESSION["mensagem"] = "Erro: Método de requisição não permitido!";

    redirecionar("../index.php");
}
