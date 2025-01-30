<div class="modal fade" id="ModalEditarPatrimonio" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-fullscreen-sm-down">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Editar Patrimônio</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limparCampos()"></button>
      </div>
      <form action="./crud/updatePatrimonio.php" method="POST">
        <div class="modal-body">
          <div class="input-group mb-3">
            <span class="input-group-text">Nº Patrimônio</span>
            <input type="text" class="form-control" name="numeroPatrimonio" id="numeroPatrimonioEditar" maxlength="20" required disabled>
            <input type="text" class="form-control" name="numeroPatrimonio_backup" id="numeroPatrimonioEditar_backup" maxlength="20" hidden>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text">Descrição</span>
            <textarea class="form-control" name="descricao" id="descricaoEditar" required></textarea>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text">Data Entrada</span>
            <input type="date" class="form-control" name="dataEntrada" id="dataEntradaEditar" required>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text">Localização</span>
            <select name="localizacao" id="localizacaoEditar" class="form-select" required>
              <option value="SME">SME</option>
              <option value="EMEI Pequeno Paraíso">EMEI Pequeno Paraíso</option>
              <option value="EMEI Vaga-Lume">EMEI Vaga-Lume</option>
              <option value="EMEI Vovó Amália">EMEI Vovó Amália</option>
              <option value="EMEF Sol Nascente">EMEF Sol Nascente</option>
              <option value="EMEF Rui Barbosa">EMEF Rui Barbosa</option>
              <option value="EMEF Antônio João">EMEF Antônio João</option>
              <option value="EMEF São João">EMEF São João</option>
              <option value="EMEF Antônio Liberato">EMEF Antônio Liberato</option>
            </select>
            <textarea class="form-control" name="DescricaoLocalizacaoEditar" id="DescricaoLocalizacaoEditar" maxlength="500" required></textarea>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text">Status</span>
            <input type="text" class="form-control" name="status" id="statusEditar" required disabled>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text">Memorando</span>
            <input id="memorandoEditar" type="text" class="form-control" name="memorando" maxlength="30" disabled>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="limparCampos()">Cancelar</button>
          <input type="submit" class="btn btn-success" value="Editar">
        </div>
      </form>
    </div>
  </div>
</div>