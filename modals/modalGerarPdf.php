<div class="modal fade" id="ModalGerarPDF" tabindex="-1" aria-labelledby="ModalEscolasLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalEscolasLabel">Selecione as Escolas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-check mb-2">
          <input class="form-check-input" type="checkbox" id="checkAll" onclick="toggleAllCheckboxes(this)">
          <label class="form-check-label" for="checkAll">Selecionar Todas</label>
        </div>
        <form action="pdf.php" method="POST" onsubmit="return validarCheck()" target="_blank">
          <div class="form-check">
            <input class="form-check-input checkSchool" type="checkbox" name="locais[]" value="SME" onclick="uncheckMainCheckbox()">
            <label class="form-check-label">SME</label>
          </div>
          <div class="form-check">
            <input class="form-check-input checkSchool" type="checkbox" name="locais[]" value="EMEI Pequeno Paraíso" onclick="uncheckMainCheckbox()">
            <label class="form-check-label">EMEI Pequeno Paraíso</label>
          </div>
          <div class="form-check">
            <input class="form-check-input checkSchool" type="checkbox" name="locais[]" value="EMEI Vaga-Lume" onclick="uncheckMainCheckbox()">
            <label class="form-check-label">EMEI Vaga-Lume</label>
          </div>
          <div class="form-check">
            <input class="form-check-input checkSchool" type="checkbox" name="locais[]" value="EMEI Vovó Amália" onclick="uncheckMainCheckbox()">
            <label class="form-check-label">EMEI Vovó Amália</label>
          </div>
          <div class="form-check">
            <input class="form-check-input checkSchool" type="checkbox" name="locais[]" value="EMEF Sol Nascente" onclick="uncheckMainCheckbox()">
            <label class="form-check-label">EMEF Sol Nascente</label>
          </div>
          <div class="form-check">
            <input class="form-check-input checkSchool" type="checkbox" name="locais[]" value="EMEF Rui Barbosa" onclick="uncheckMainCheckbox()">
            <label class="form-check-label">EMEF Rui Barbosa</label>
          </div>
          <div class="form-check">
            <input class="form-check-input checkSchool" type="checkbox" name="locais[]" value="EMEF Antônio João" onclick="uncheckMainCheckbox()">
            <label class="form-check-label">EMEF Antônio João</label>
          </div>
          <div class="form-check">
            <input class="form-check-input checkSchool" type="checkbox" name="locais[]" value="EMEF São João" onclick="uncheckMainCheckbox()">
            <label class="form-check-label">EMEF São João</label>
          </div>
          <div class="form-check">
            <input class="form-check-input checkSchool" type="checkbox" name="locais[]" value="EMEF Antônio Liberato" onclick="uncheckMainCheckbox()">
            <label class="form-check-label">EMEF Antônio Liberato</label>
          </div>
          <div class="mt-3">
            <button type="submit" class="btn btn-primary">Gerar PDF</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>