<div class="modal fade" id="ModalExcluirPatrimonio" tabindex="-1" aria-labelledby="modalEditarStep2Label" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-fullscreen-sm-down">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Excluir Patrimônio</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limparCampos()"></button>
      </div>
      <form action="./crud/deletePatrimonio.php" method="POST">
        <div class="modal-body">
          <div class="input-group mb-3">
            <span class="input-group-text">Nº Patrimônio</span>
            <input type="text" class="form-control" id="numeroPatrimonioExcluir" maxlength="20" readonly>
            <input type="text" class="form-control" name="numeroPatrimonio_backup" id="numeroPatrimonioExcluir_backup" maxlength="20" hidden>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text">Descrição</span>
            <textarea class="form-control" id="descricaoExcluir" readonly></textarea>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text">Data Entrada</span>
            <input type="date" class="form-control" id="dataEntradaExcluir" readonly>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text">Localização</span>
            <input type="text" class="form-control" id="localizacaoExcluir" readonly>
            <textarea class="form-control" id="descricaoLocalizacaoExcluir" maxlength="500" readonly></textarea>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text">Status</span>
            <input type="text" class="form-control" id="statusExcluir" readonly>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text">Memorando</span>
            <input id="memorandoExcluir" type="text" class="form-control" maxlength="30" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="limparCampos()">Cancelar</button>
          <input type="submit" class="btn btn-danger" value="Excluir">
        </div>
      </form>
    </div>
  </div>
</div>