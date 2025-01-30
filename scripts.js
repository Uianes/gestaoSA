// Função para limpar campos de entrada nos modais
function limparCampos() {
    // Selecionar todos os elementos de entrada
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        // Ignorar botões de submit e campos específicos
        if (input.type === 'submit' || input.id === 'statusDescarte') {
            return;
        }
        // Limpar o valor do campo
        input.value = '';
    });

    // Resetar contadores de caracteres
    document.getElementById("contadorNumeroPatrimonioCadastrar").innerText = "0/20";
    document.getElementById("contadorDescricaoLocalizacaoCadastrar").innerText = "0/500";
    document.getElementById("contadorMemorandoCadastrar").innerText = "0/30";
    document.getElementById("contadorNumeroPatrimonioDescarte1").innerText = "0/20";
    document.getElementById("contadorMemorandoDescarte").innerText = "0/30";
}

// Função para atualizar o contador de caracteres de um campo
function atualizarContador(input, contadorId) {
    const contador = document.getElementById(contadorId);
    const maxLength = input.maxLength;
    contador.innerText = `${input.value.length}/${maxLength}`;
}

// Função para habilitar ou desabilitar o campo 'memorando' com base no 'status'
function toggleMemorando(selectId, memorandoId, contadorMemorandoID) {
    const status = document.getElementById(selectId);
    const memorando = document.getElementById(memorandoId);

    if (status.value == "Descarte") {
        memorando.disabled = false;
        memorando.required = true;
    } else if (status.value == "Tombado") {
        memorando.disabled = true;
        memorando.required = false;
        memorando.value = '';
        // Atualizar o contador de caracteres do memorando
        atualizarContador(memorando, contadorMemorandoID);
    }
}