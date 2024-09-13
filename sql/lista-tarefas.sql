DROP DATABASE IF EXISTS listaTarefas;
CREATE DATABASE listaTarefas;
USE listaTarefas;

DROP TABLE IF EXISTS tarefas;
CREATE TABLE tarefas(
    id INT UNSIGNED AUTO_INCREMENT NOT NULL,
    titulo VARCHAR(30) NOT NULL,
    descricao VARCHAR(50) NOT NULL,
    concluida BOOLEAN DEFAULT FALSE NOT NULL,
    PRIMARY KEY(id)
);

DROP VIEW IF EXISTS viewResgatarTarefas;
CREATE VIEW viewResgatarTarefas AS
SELECT id AS idTarefa, titulo AS tituloTarefa, descricao AS descricaoTarefa, concluida AS estaConcluida
FROM tarefas;

DELIMITER //

DROP PROCEDURE IF EXISTS procCadastrarTarefa//
CREATE PROCEDURE procCadastrarTarefa(IN procTitulo VARCHAR(30), IN procDescricao VARCHAR(50))
BEGIN
    INSERT INTO tarefas(titulo, descricao) VALUES(procTitulo, procDescricao);
END//

DROP PROCEDURE IF EXISTS procAtualizarEstadoTarefa//
CREATE PROCEDURE procAtualizarEstadoTarefa(IN procID INT, IN procConcluida BOOLEAN)
BEGIN
    UPDATE tarefas
    SET concluida = procConcluida
    WHERE id = procID;
END//

DROP PROCEDURE IF EXISTS procDeletarTarefa//
CREATE PROCEDURE procDeletarTarefa(IN procID INT)
BEGIN
    DELETE FROM tarefas WHERE id = procID;
END//

DELIMITER ;