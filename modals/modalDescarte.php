<div class="modal fade" id="ModalDescartePatrimonio" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-fullscreen-sm-down">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Editar Patrimônio - Digite o número do patrimônio</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limparCampos()"></button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3">
          <span class="input-group-text">Nº Patrimônio</span>
          <input type="text" class="form-control" id="numeroPatrimonioDescarte" oninput="atualizarContador(this,'contadorNumeroPatrimonioDescarte1')" maxlength="20" required>
          <span class="input-group-text" id="contadorNumeroPatrimonioDescarte1">0/20</span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="limparCampos()">Cancelar</button>
        <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="carregarDadosDescarte(document.getElementById('numeroPatrimonioDescarte').value), limparCampos()">Prosseguir</button>
      </div>
      </form>
    </div>
  </div>
</div>