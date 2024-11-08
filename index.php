<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GestãoSA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

  <nav class="navbar bg-body-secondary border-bottom">
    <div class="container-fluid d-flex justify-content-start">
      <a class="navbar-brand" href="#">GestãoSA</a>
      <div class="flex-grow-1 ms-1">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
          aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <form action="" class="d-flex">
        <input class="form-control me-1" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
      </form>
    </div>
  </nav>

  <!-- offcanvas navbar -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Navegação</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
        <li class="nav-item">
          <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#ModalCadastrarPatrimonio">Cadastrar Patrimônio</button>
        </li>
        <li class="nav-item">
          <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#ModalDescartePatrimonio">Descarte Patrimônio</button>
        </li>
      </ul>
    </div>
  </div>

  <div class="container-fluid">
    <!-- tabela -->
    <div class="row justify-content-center">
      <div class="col-10">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "gestaosa";

        // Cria a conexão
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Verifica a conexão
        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }

        // Consulta SQL
        $sql = "SELECT * FROM patrimonio";
        $result = mysqli_query($conn, $sql);

        // Array para armazenar os dados (para JSON)
        $data = [];

        if (mysqli_num_rows($result) > 0) {
          // Cabeçalho da tabela
          echo "
                <table class='table table-bordered mt-3 table-striped'>
                    <thead>
                        <tr>
                            <th scope='col'>Nº Patrimônio</th>
                            <th scope='col'>Descrição</th>
                            <th scope='col'>Data Entrada</th>
                            <th scope='col'>Localização</th>
                            <th scope='col'>Descrição Localização</th>
                            <th scope='col'>Status</th>
                            <th scope='col'>Memorando</th>
                            <th scope='col'>Editar</th>
                        </tr>
                    </thead>
                    <tbody class='table-group-divider'>
            ";

          // Preenche as linhas da tabela e armazena no array para o JSON
          while ($row = mysqli_fetch_assoc($result)) {
            // Adiciona cada linha ao array para o JSON
            $data[] = $row;

            // Exibe a linha na tabela
            echo "
                    <tr>
                        <th scope='row'>" . $row["N_Patrimonio"] . "</th>
                        <td>" . $row["Descricao"] . "</td>
                        <td>" . $row["Data_Entrada"] . "</td>
                        <td>" . $row["Localizacao"] . "</td>
                        <td>" . $row["Descricao_Localizacao"] . "</td>
                        <td>" . $row["Status"] . "</td>
                        <td>" . $row["Memorando"] . "</td>
                        <td class='text-center'>
                            <button class='mx-1 btn' type='button' onclick='carregarDados(\"" . $row["N_Patrimonio"] . "\")'><i class='bi bi-pencil-fill'></i></button>
                            <button class='mx-1 btn btn-danger' onclick='excluirDados(\"" . $row["N_Patrimonio"] . "\")'><i class='bi bi-trash-fill'></i></button>
                        </td>
                    </tr>
                ";
          }

          echo "</tbody> </table>";

          // Salva o JSON em um arquivo
          $jsonData = json_encode($data, JSON_PRETTY_PRINT);
          file_put_contents('temp_patrimonio.json', $jsonData);
        } else {
          echo "Nenhum resultado encontrado";
        }

        mysqli_close($conn);
        ?>
      </div>
    </div>

    <!-- Pagination -->
    <div class="row justify-content-center">
      <div class="col-10">
        <nav aria-label="Page navigation"></nav>
        <ul class="pagination justify-content-end">
          <li class="page-item"><a class="page-link" href="#"><i class="bi bi-caret-left"></i></a></li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#"><i class="bi bi-caret-right"></i></a></li>
        </ul>
        </nav>
      </div>
    </div>

    <!-- Modal Cadastrar Patrimônio -->
    <div class="modal fade" id="ModalCadastrarPatrimonio" tabindex="-1" aria-labelledby="modalCadastrarLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Cadastrar Patrimônio</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limparCampos()"></button>
          </div>
          <form action="./insertPatrimonio.php" method="POST">
            <div class="modal-body">
              <div class="input-group mb-3">
                <span class="input-group-text">Nº Patrimônio</span>
                <input type="text" class="form-control" name="numeroPatrimonio" id="numeroPatrimonioCadastrar" oninput="atualizarContador(this, 'contadorNumeroPatrimonioCadastrar')" maxlength="20" required>
                <span class="input-group-text" id="contadorNumeroPatrimonioCadastrar">0/20</span>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Descrição</span>
                <textarea class="form-control" name="descricao" id="descricaoCadastrar" required></textarea>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Data Entrada</span>
                <input type="date" class="form-control" name="dataEntrada" id="dataEntradaCadastrar" required>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Localização</span>
                <select name="localizacao" id="localizacaoCadastrar" class="form-select" required>
                  <option selected disabled value="">Selecione uma Opção</option>
                  <option value="EMEI Pequeno Paraíso">EMEI Pequeno Paraíso</option>
                  <option value="EMEI Vaga-Lume">EMEI Vaga-Lume</option>
                  <option value="EMEI Vovó Amália">EMEI Vovó Amália</option>
                  <option value="EMEF Sol Nascente">EMEF Sol Nascente</option>
                  <option value="EMEF Rui Barbosa">EMEF Rui Barbosa</option>
                  <option value="EMEF Antônio João">EMEF Antônio João</option>
                  <option value="EMEF São João">EMEF São João</option>
                  <option value="EMEF Antônio Liberato">EMEF Antônio Liberato</option>
                </select>
                <textarea class="form-control" name="DescricaoLocalizacao" id="DescricaoLocalizacaoCadastrar" oninput="atualizarContador(this, 'contadorDescricaoLocalizacaoCadastrar')" maxlength="500" required></textarea>
                <span class="input-group-text" id="contadorDescricaoLocalizacaoCadastrar">0/500</span>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Status</span>
                <select id="statusCadastrar" name="status" class="form-select" required>
                  <option selected disabled value="">Selecione uma Opção</option>
                  <option value="tombado">Tombado</option>
                  <option value="descarte">Descarte</option>
                </select>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Memorando</span>
                <input id="memorandoCadastrar" type="text" class="form-control" name="memorando" oninput="atualizarContador(this, 'contadorMemorandoCadastrar')" maxlength="30" disabled>
                <span class="input-group-text" id="contadorMemorandoCadastrar">0/30</span>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="limparCampos()">Cancelar</button>
              <input type="submit" class="btn btn-success" value="Cadastrar">
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Editar Patrimônio-->
    <div class="modal fade" id="ModalEditarPatrimonio" tabindex="-1" aria-labelledby="modalEditarStep2Label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Editar Patrimônio</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limparCampos()"></button>
          </div>
          <form action="./updatePatrimonio.php" method="POST">
            <div class="modal-body">
              <div class="input-group mb-3">
                <span class="input-group-text">Nº Patrimônio</span>
                <input type="text" class="form-control" name="numeroPatrimonio" id="numeroPatrimonioEditar" maxlength="20" required disabled>
                <input type="text" class="form-control" name="numeroPatrimonio_backup" id="numeroPatrimonioEditar_backup"  maxlength="20" hidden>
                <span class="input-group-text" id="contadornumeroPatrimonioEditar">0/20</span>
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
                <span class="input-group-text" id="contadorDescricaoLocalizacaoEditar">0/500</span>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Status</span>
                <input type="text" class="form-control" name="status" id="statusEditar" required disabled>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Memorando</span>
                <input id="memorandoEditar" type="text" class="form-control" name="memorando" maxlength="30" disabled>
                <span class="input-group-text" id="contadorMemorandoEditar">0/30</span>
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

    <!-- Modal Excluir Patrimônio -->
    <div class="modal fade" id="ModalExcluirPatrimonio" tabindex="-1" aria-labelledby="modalEditarStep2Label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Excluir Patrimônio</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limparCampos()"></button>
          </div>
          <form action="./deletePatrimonio.php" method="POST">
            <div class="modal-body">
              <div class="input-group mb-3">
                <span class="input-group-text">Nº Patrimônio</span>
                <input type="text" class="form-control" id="numeroPatrimonioExcluir" maxlength="20" required disabled>
                <input type="text" class="form-control" name="numeroPatrimonio_backup" id="numeroPatrimonioExcluir_backup" maxlength="20" hidden>
                <span class="input-group-text" id="contadornumeroPatrimonioExcluir" disabled>0/20</span>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Descrição</span>
                <textarea class="form-control" id="descricaoExcluir" required disabled></textarea>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Data Entrada</span>
                <input type="date" class="form-control" id="dataEntradaExcluir" required disabled>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Localização</span>
                <input type="text" class="form-control" id="localizacaoExcluir" disabled>
                <textarea class="form-control" id="descricaoLocalizacaoExcluir" maxlength="500" required disabled></textarea>
                <span class="input-group-text" id="contadorDescricaoLocalizacaoExcluir">0/500</span>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Status</span>
                <input type="text" class="form-control" id="statusExcluir" required disabled>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Memorando</span>
                <input id="memorandoExcluir" type="text" class="form-control" maxlength="30" disabled>
                <span class="input-group-text" id="contadorMemorandoExcluir">0/30</span>
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

    <!-- Modal Descarte Patrimônio Step 1 -->
    <div class="modal fade" id="ModalDescartePatrimonio" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Editar Patrimônio - Digite o número do patrimônio</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limparCampos()"></button>
          </div>
          <form action="" method="POST">
            <div class="modal-body">
              <div class="input-group mb-3">
                <span class="input-group-text">Nº Patrimônio</span>
                <input type="text" class="form-control" name="numeroPatrimonio" id="numeroPatrimonioDescarte" maxlength="20" required>
                <span class="input-group-text" id="contadorNumeroPatrimonioDescarte1">0/20</span>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="limparCampos()">Cancelar</button>
              <input type="submit" class="btn btn-success" value="Confirmar exclusão">
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Descarte Patrimônio Step 2-->
    <div class="modal fade" id="ModalDescartePatrimonioStep2" tabindex="-1" aria-labelledby="modalDescarteLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5">Descarte Patrimônio</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="limparCampos()"></button>
          </div>
          <form action="./insertPatrimonio.php" method="POST">
            <div class="modal-body">
              <div class="input-group mb-3">
                <span class="input-group-text">Nº Patrimônio</span>
                <input type="text" class="form-control" name="numeroPatrimonio" id="numeroPatrimonioDescarte" maxlength="20" disabled required>
                <span class="input-group-text" id="contadorNumeroPatrimonioDescarte">0/20</span>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Descrição</span>
                <textarea class="form-control" name="descricao" id="descricaoDescarte" required></textarea>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Data Entrada</span>
                <input type="date" class="form-control" name="dataEntrada" id="dataEntradaDescarte" required>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Localização</span>
                <textarea class="form-control" name="localizacao" id="localizacaoDescarte" maxlength="500" required></textarea>
                <span class="input-group-text" id="contadorDescricaoLocalizacaoDescarte">0/500</span>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Status</span>
                <select id="statusDescarte" name="status" class="form-select" required>
                  <option selected disabled value="">Selecione uma Opção</option>
                  <option value="tombado">Tombado</option>
                  <option value="descarte">Descarte</option>
                </select>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Memorando</span>
                <input id="memorandoDescarte" type="text" class="form-control" name="memorando" maxlength="30" disabled>
                <span class="input-group-text" id="contadorMemorandoDescarte">0/30</span>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="limparCampos()">Cancelar</button>
              <input type="submit" class="btn btn-success">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    async function carregarDados(patrimonio) {
      try {
        // Carrega o arquivo JSON
        const response = await fetch('temp_patrimonio.json');
        if (!response.ok) {
          throw new Error('Erro ao carregar o arquivo JSON');
        }
        const data = await response.json();

        // Encontra o objeto correspondente ao patrimônio selecionado
        const patrimonioData = data.find(item => item.N_Patrimonio == patrimonio);
        if (!patrimonioData) {
          console.error('Patrimônio não encontrado no JSON');
          return;
        }

        // Preenche os campos do modal com os dados do patrimônio
        document.getElementById("numeroPatrimonioEditar").value = patrimonioData.N_Patrimonio;
        document.getElementById("numeroPatrimonioEditar_backup").value = patrimonioData.N_Patrimonio;
        document.getElementById("descricaoEditar").value = patrimonioData.Descricao;
        document.getElementById("dataEntradaEditar").value = patrimonioData.Data_Entrada;
        document.getElementById("localizacaoEditar").value = patrimonioData.Localizacao;
        document.getElementById("DescricaoLocalizacaoEditar").value = patrimonioData.Descricao_Localizacao;
        document.getElementById("statusEditar").value = patrimonioData.Status;
        document.getElementById("memorandoEditar").value = patrimonioData.Memorando;
        
        // Atualiza contador
        atualizarContador(patrimonioData.N_Patrimonio, "contadorNumeroPatrimonioEditar");
        atualizarContador(patrimonioData.Descricao_Localizacao, "contadorDescricaoLocalizacaoEditar");
        atualizarContador(patrimonioData.Memorando, "contadorMemorandoEditar");


        // Exibe o modal
        var modal = new bootstrap.Modal(document.getElementById('ModalEditarPatrimonio'));
        modal.show();

      } catch (error) {
        console.error('Erro:', error);
      }
    }

    async function excluirDados(patrimonio) {
      try {
        // Carrega o arquivo JSON
        const response = await fetch('temp_patrimonio.json');
        if (!response.ok) {
          throw new Error('Erro ao carregar o arquivo JSON');
        }
        const data = await response.json();

        // Encontra o objeto correspondente ao patrimônio selecionado
        const patrimonioData = data.find(item => item.N_Patrimonio == patrimonio);
        if (!patrimonioData) {
          console.error('Patrimônio não encontrado no JSON');
          return;
        }

        // Preenche os campos do modal com os dados do patrimônio
        document.getElementById("numeroPatrimonioExcluir").value = patrimonioData.N_Patrimonio;
        document.getElementById("numeroPatrimonioExcluir_backup").value = patrimonioData.N_Patrimonio;
        document.getElementById("descricaoExcluir").value = patrimonioData.Descricao;
        document.getElementById("dataEntradaExcluir").value = patrimonioData.Data_Entrada;
        document.getElementById("localizacaoExcluir").value = patrimonioData.Localizacao;
        document.getElementById("statusExcluir").value = patrimonioData.Status;
        document.getElementById("memorandoExcluir").value = patrimonioData.Memorando;

        // Atualiza contador
        atualizarContador(patrimonioData.N_Patrimonio, "contadorNumeroPatrimonioExcluir");
        atualizarContador(patrimonioData.Descricao_Localizacao, "contadorDescricaoLocalizacaoExcluir");
        atualizarContador(patrimonioData.Memorando, "contadorMemorandoExcluir");

        // Exibe o modal
        var modal = new bootstrap.Modal(document.getElementById('ModalExcluirPatrimonio'));
        modal.show();

      } catch (error) {
        console.error('Erro:', error);
      }
    }

    function limparCampos() {
      // Limpar campos dos modais
      const inputs = document.querySelectorAll('input, select, textarea');
      inputs.forEach(input => {
        if (input.type === 'submit') {
          return; // Ignora inputs do tipo 'submit'
        }
        input.value = ''; // Limpa os demais inputs
      });

      // contador
      document.getElementById("contadorNumeroPatrimonioCadastrar").innerText = "0/20";
      document.getElementById("contadorDescricaoLocalizacaoCadastrar").innerText = "0/500";
      document.getElementById("contadorMemorandoCadastrar").innerText = "0/30";
      document.getElementById("contadornumeroPatrimonioEditar").innerText = "0/20";
      document.getElementById("contadorDescricaoLocalizacaoEditar").innerText = "0/500";
      document.getElementById("contadorMemorandoEditar").innerText = "0/30";
      document.getElementById("contadornumeroPatrimonioExcluir").innerText = "0/20";
      document.getElementById("contadorDescricaoLocalizacaoExcluir").innerText = "0/500";
      document.getElementById("contadorMemorandoExcluir").innerText = "0/30";
      document.getElementById("contadorNumeroPatrimonioDescarte1").innerText = "0/20";
      document.getElementById("contadorNumeroPatrimonioDescarte").innerText = "0/20";
      document.getElementById("contadorDescricaoLocalizacaoDescarte").innerText = "0/500";
      document.getElementById("contadorMemorandoDescarte").innerText = "0/30";
    }

    function atualizarContador(input, contadorId) {
      const contador = document.getElementById(contadorId);
      const maxLength = input.maxLength;
      contador.innerText = `${input.value.length}/${maxLength}`;
    }

    function toggleMemorando(selectId, memorandoId, contadorMemorandoID) {
            const status = document.getElementById(selectId);
            const memorando = document.getElementById(memorandoId);

            if (status.value === "descarte") {
                memorando.disabled = false;
                memorando.required = true;
            } else if (status.value === "tombado") {
                memorando.disabled = true;
                memorando.required = false;
                memorando.value = '';
                atualizarContador(memorando, contadorMemorandoID);
            }
        }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
</body>

</html>