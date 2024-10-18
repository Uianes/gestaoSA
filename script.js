function verificarLimite(elemento) {
  const limite = elemento.maxLength;
  const caracteresDigitados = elemento.value.length;
  if (elemento.name === "numeroPatrimonio") {
    document.getElementById("contadorNumeroPatrimonio").textContent = `${caracteresDigitados}/${limite}`;
  } else if (elemento.name === "localizacao") {
    document.getElementById("contadorLocalizacao").textContent = `${caracteresDigitados}/${limite}`;
  } else if (elemento.name === "memorando") {
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
