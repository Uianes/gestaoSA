function verificarLimite(element) {
  const limite = element.maxLength;
  const caracteresDigitados = element.value.length;
  if (element.name === "numeroPatrimonio") {
    document.getElementById("contadorNumeroPatrimonio").textContent = `${caracteresDigitados}/${limite}`;
  } else if (element.name === "localizacao") {
    document.getElementById("contadorLocalizacao").textContent = `${caracteresDigitados}/${limite}`;
  } else if (element.name === "memorando") {
    document.getElementById("contadorMemorando").textContent = `${caracteresDigitados}/${limite}`;
  }
}

function toggleMemorandoInput() {
  let statusSelect = document.getElementById("status");
  let memorandoInput = document.getElementById("memorando");

  if (statusSelect.value === "descarte") {
    memorandoInput.disabled = false;  // Ativa o input
    memorandoInput.setAttribute("required", "required"); // Adiciona "required"
  } else {
    memorandoInput.disabled = true;  // Desativa o input
    memorandoInput.removeAttribute("required");  // Remove "required"
    memorandoInput.value = "";  // Limpa o campo
    document.getElementById("contadorMemorando").textContent = "0/30";  // Reseta o contador
  }
}

function limparCampos() {
  document.getElementById("numeroPatrimonio").value = "";
  document.getElementById("localizacao").value = "";
  document.getElementById("descricao").value = "";
  document.getElementById("dataEntrada").value = "";
  document.getElementById("status").value = "";
  document.getElementById("memorando").value = "";
  document.getElementById("contadorNumeroPatrimonio").textContent = "0/20";
  document.getElementById("contadorLocalizacao").textContent = "0/500";
  document.getElementById("contadorMemorando").textContent = "0/30";
}
