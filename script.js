// Função para verificar o limite de caracteres digitados em um campo de entrada
function verificarLimite(element) {
  const limite = element.maxLength; // Obtém o limite máximo de caracteres do campo
  const caracteresDigitados = element.value.length; // Obtém o número de caracteres digitados no campo

  // Atualiza o contador de caracteres de acordo com o nome do campo
  if (element.name === "numeroPatrimonio") {
    document.getElementById("contadorNumeroPatrimonio").textContent = `${caracteresDigitados}/${limite}`;
  } else if (element.name === "localizacao") {
    document.getElementById("contadorLocalizacao").textContent = `${caracteresDigitados}/${limite}`;
  } else if (element.name === "memorando") {
    document.getElementById("contadorMemorando").textContent = `${caracteresDigitados}/${limite}`;
  }
}

// Função para habilitar ou desabilitar o campo de memorando com base no status selecionado
function toggleMemorandoInput() {
  if (document.getElementById("status").value === "descarte") {
    // Se o status for "descarte", habilita o campo de memorando e o torna obrigatório
    document.getElementById("memorando").disabled = false;
    document.getElementById("memorando").setAttribute("required", "required");
  } else {
    // Caso contrário, desabilita o campo de memorando, remove a obrigatoriedade e limpa o campo
    document.getElementById("memorando").disabled = true;
    document.getElementById("memorando").removeAttribute("required");
    document.getElementById("memorando").value = "";
    document.getElementById("contadorMemorando").textContent = "0/30"; // Reseta o contador de caracteres
  }
}

// Função para limpar todos os campos do formulário
function limparCampos() {
  document.getElementById("numeroPatrimonio").value = ""; // Limpa o campo de número de patrimônio
  document.getElementById("localizacao").value = ""; // Limpa o campo de localização
  document.getElementById("descricao").value = ""; // Limpa o campo de descrição
  document.getElementById("dataEntrada").value = ""; // Limpa o campo de data de entrada
  document.getElementById("status").value = ""; // Limpa o campo de status
  document.getElementById("memorando").value = ""; // Limpa o campo de memorando
  
  // Reseta os contadores de caracteres
  document.getElementById("contadorNumeroPatrimonio").textContent = "0/20";
  document.getElementById("contadorLocalizacao").textContent = "0/500";
  document.getElementById("contadorMemorando").textContent = "0/30";
}
