export const modal = document.querySelector("#modal");
const secaoModal = document.querySelector("#secao-modal");
const mensagemModal = document.querySelector("#mensagem-modal");

export function alternarModal(mensagem = undefined) {
  [modal, secaoModal].forEach((elemento) =>
    elemento.classList.toggle("inativo")
  );

  if (mensagem) mensagemModal.innerText = mensagem;
}
