<?php
function limparEntrada($valor)
{
    $valor = trim($valor);
    $valor = stripslashes($valor);
    $valor = htmlspecialchars($valor);

    return $valor;
}

function redirecionar($url)
{
    header("Location: $url");
    exit();
}

function validarComprimentoTexto($texto, $comprimento)
{
    return strlen($texto) <= $comprimento;
}

function validarID($id)
{
    if (!is_numeric($id)) return "Erro: O ID deve ser um número!";

    if (is_float($id)) return "Erro: O ID deve ser um número inteiro!";

    if ((int) $id < 1) return "Erro: O ID deve ser um número maior ou igual a 1!";

    return true;
}
