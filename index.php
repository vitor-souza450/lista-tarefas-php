<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gerencie suas tarefas de forma fácil!">
    <meta name="author" content="Vitor Souza">
    <title>Lista de Tarefas</title>
    <link rel="stylesheet" href="./css/estilo.css">
    <script type="module" src="./js/script.js"></script>
    <?php
    if (isset($_SESSION["mensagem"])):
        $mensagem = $_SESSION["mensagem"];
    ?>
        <script type="module">
            import {
                alternarModal
            } from "./js/utilitarios.js";

            window.addEventListener("load", () => {
                alternarModal("<?php echo $mensagem; ?>");
            });
        </script>
    <?php
        unset($_SESSION["mensagem"]);
    endif;
    ?>
</head>

<body>
    <?php
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=listaTarefas", "root", "root1234");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $pdo->prepare("SELECT * FROM viewResgatarTarefas");
        $sql->execute();

        $resultado = $sql->fetchAll();
    } catch (PDOException $e) {
        error_log("Erro ao resgatar tarefas: " . $e->getMessage(), 0);
    }
    ?>

    <header>
        <h1>Lista de Tarefas</h1>
    </header>

    <section class="secao-pagina">
        <h2>Cadastre uma Tarefa</h2>
        <form action="./config/cadastrar-tarefa.php" method="POST" id="form" novalidate>
            <input type="text" name="titulo" id="titulo" class="campo" placeholder="Defina um título para sua tarefa" value="<?php echo $_SESSION["titulo"] ?? ""; ?>" maxlength="30" required>
            <textarea name="descricao" id="descricao" class="campo" placeholder="Descreva o que pretende fazer" maxlength="50" required><?php echo $_SESSION["descricao"] ?? ""; ?></textarea>
            <input type="submit" value="Cadastrar" class="botao botao-enviar-form">
        </form>
    </section>

    <section class="secao-pagina">
        <h2>Pesquise por uma Tarefa</h2>
        <input type="search" name="pesquisa" id="pesquisa" class="campo" placeholder="Pesquise pelo título ou descrição">
    </section>

    <main class="secao-pagina">
        <h2>Veja suas Tarefas</h2>
        <p id="sem-tarefas" class="sem-tarefas <?php echo !empty($resultado) ? "inativo" : ""; ?>">Nenhuma tarefa adicionada / encontrada.</p>
        <ul id="lista-tarefas" <?php echo empty($resultado) ? 'class="inativo"' : ""; ?>>
            <?php
            if (!empty($resultado)):
                foreach ($resultado as $coluna):
            ?>
                    <li id="<?php echo $coluna["idTarefa"]; ?>" <?php echo $coluna["estaConcluida"] ? 'class="concluida"' : ""; ?>>
                        <h3>
                            <?php echo $coluna["tituloTarefa"]; ?>
                        </h3>
                        <p>
                            <?php echo $coluna["descricaoTarefa"]; ?>
                        </p>
                        <div class="area-acoes-tarefa">
                            <a href="./config/atualizar-estado-tarefa.php?id=<?php echo $coluna["idTarefa"]; ?>&concluida=<?php echo $coluna["estaConcluida"]; ?>" class="botao botao-atualizar-estado-tarefa">Concluir / Inconcluir</a>
                            <a href="./config/deletar-tarefa.php?id=<?php echo $coluna["idTarefa"]; ?>" class="botao botao-deletar-tarefa">Deletar</a>
                        </div>
                    </li>
            <?php
                endforeach;
            endif;
            ?>
        </ul>
    </main>

    <div id="modal" class="modal inativo">
        <section id="secao-modal" class="secao-modal inativo">
            <h4>Atenção:</h4>
            <p id="mensagem-modal" class="mensagem-modal"></p>
            <button type="button" id="botao-fechar-modal" class="botao botao-fechar-modal">Fechar</button>
        </section>
    </div>

    <footer>
        <p>
            Copyright &copy; <span id="ano-atual">2024</span> by Vitor Souza.
        </p>
    </footer>
</body>

</html>