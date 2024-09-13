import { modal, alternarModal } from "./utilitarios.js";

const form = document.querySelector("#form");
const titulo = document.querySelector("#titulo");
const descricao = document.querySelector("#descricao");
const pesquisa = document.querySelector("#pesquisa");
const semTarefas = document.querySelector("#sem-tarefas");
const listaTarefas = document.querySelector("#lista-tarefas");
const botaoFecharModal = document.querySelector("#botao-fechar-modal");
const anoAtual = document.querySelector("#ano-atual");

document.addEventListener("DOMContentLoaded", () => {
  const dataAtual = new Date();

  anoAtual.innerText = dataAtual.getFullYear();
});

document.addEventListener("click", (event) => {
  if (event.target === modal) alternarModal();
});

document.addEventListener("keydown", (event) => {
  if (event.key === "Escape" && !modal.classList.contains("inativo"))
    alternarModal();
});

form.addEventListener("submit", (event) => {
  event.preventDefault();

  const valorTitulo = titulo.value.trim();
  const valorDescricao = descricao.value.trim();

  if (!titulo.checkValidity() || !valorTitulo) {
    alternarModal("Erro: Por favor, informe um título para sua tarefa!");
    limparCampo(titulo);

    return;
  }

  if (!validarComprimentoTexto(valorTitulo, 30)) {
    alternarModal("Erro: Por favor, informe um título com até 30 caracteres!");
    limparCampo(titulo);

    return;
  }

  if (!titulo.checkValidity() || !valorDescricao) {
    alternarModal("Erro: Por favor, informe uma descrição para sua tarefa!");
    limparCampo(descricao);

    return;
  }

  if (!validarComprimentoTexto(valorDescricao, 50)) {
    alternarModal(
      "Erro: Por favor, informe uma descrição com até 50 caracteres!"
    );
    limparCampo(descricao);

    return;
  }

  form.submit();
});

pesquisa.addEventListener("input", (event) => {
  const valorPesquisa = event.currentTarget.value.trim().toLowerCase();
  const itensLista = document.querySelectorAll("li");

  if (itensLista.length > 0) {
    let temPesquisa = false;

    itensLista.forEach((elemento) => {
      const titulo = elemento.querySelector("h3").innerText.toLowerCase();
      const descricao = elemento.querySelector("p").innerText.toLowerCase();

      if (
        !titulo.includes(valorPesquisa) &&
        !descricao.includes(valorPesquisa)
      ) {
        elemento.classList.add("inativo");
      } else {
        elemento.classList.remove("inativo");

        temPesquisa = true;
      }
    });

    if (!temPesquisa) {
      semTarefas.classList.remove("inativo");
      listaTarefas.classList.add("inativo");
    } else {
      semTarefas.classList.add("inativo");
      listaTarefas.classList.remove("inativo");
    }
  }
});

botaoFecharModal.addEventListener("click", () => alternarModal());

function limparCampo(campo) {
  campo.value = "";

  if (window.screen.width >= 992) campo.focus();
  else campo.blur();
}

function validarComprimentoTexto(texto, comprimento) {
  return texto.length <= comprimento;
}
