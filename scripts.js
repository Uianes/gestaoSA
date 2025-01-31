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

function abrirModalEditar(numPatrimonio, descricao, dataEntrada, localizacao, descLocalizacao, status, memorando) {
  document.getElementById('numeroPatrimonioEditar').value = numPatrimonio;
  document.getElementById('descricaoEditar').value = descricao;
  document.getElementById('dataEntradaEditar').value = dataEntrada;
  document.getElementById('localizacaoEditar').value = localizacao;
  document.getElementById('DescricaoLocalizacaoEditar').value = descLocalizacao;
  document.getElementById('statusEditar').value = status;
  document.getElementById('memorandoEditar').value = memorando;

  let modalEditar = new bootstrap.Modal(document.getElementById('ModalEditarPatrimonio'));
  modalEditar.show();
}

function abrirModalExcluir(numPatrimonio, descricao, dataEntrada, localizacao, descLocalizacao, status, memorando) {
  document.getElementById('numeroPatrimonioExcluir').value = numPatrimonio;
  document.getElementById('descricaoExcluir').value = descricao;
  document.getElementById('dataEntradaExcluir').value = dataEntrada;
  document.getElementById('localizacaoExcluir').value = localizacao;
  document.getElementById('descricaoLocalizacaoExcluir').value = descLocalizacao;
  document.getElementById('statusExcluir').value = status;
  document.getElementById('memorandoExcluir').value = memorando;

  let modalExcluir = new bootstrap.Modal(document.getElementById('ModalExcluirPatrimonio'));
  modalExcluir.show();
}