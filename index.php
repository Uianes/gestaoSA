<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GestãoSA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style.css">
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
          <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#ModalEditarPatrimonio">Editar Patrimônio</button>
        </li>
        <li class="nav-item">
          <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#ModalExcluirPatrimonio">Excluir Patrimônio</button>
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

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM patrimonio";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
          // output data of each row
          echo "
            <table class='table table-bordered mt-3 table-striped'>
              <thead>
                <tr>
                  <th scope='col'>Nº Patrimônio</th>
                  <th scope='col'>Descrição</th>
                  <th scope='col'>Data Entrada</th>
                  <th scope='col'>Localização</th>
                  <th scope='col'>Status</th>
                  <th scope='col'>Memorando</th>
                  <th scope='col'>Editar</th>
                </tr>
              </thead>
              <tbody class='table-group-divider'>
                <tr>
            ";
          while ($row = mysqli_fetch_assoc($result)) {
            echo "
              <th scope='row'>" . $row["N_Patrimonio"] . "</th>
                <td>" . $row["Descricao"] . "</td>
                <td>" . $row["Data_Entrada"] . "</td>
                <td>" . $row["Localizacao"] . "</td>
                <td>" . $row["Status"] . "</td>
                <td>" . $row["Memorando"] . "</td>
                <td class='text-center'>
                  <button class='mx-1 btn' type='button' data-bs-toggle='modal' data-bs-target='#ModalEditarPatrimonio' value='" . $row["N_Patrimonio"] . "'><i class='bi bi-pencil-fill'></i></button>
                  <button class='mx-1 btn btn-danger' value='" . $row["N_Patrimonio"] . "'><i class='bi bi-trash-fill'></i></button>
                 </td>
              </tr>
            ";
          }
          echo "</tbody> </table>";
        } else {
          echo "0 results";
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
            <h1 class="modal-title fs-5" id="modalCadastrarLabel">Cadastrar Patrimônio</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="./insertPatrimonio.php" method="POST">
            <div class="modal-body">
              <div class="input-group mb-3">
                <span class="input-group-text">Nº Patrimônio</span>
                <input type="text" class="form-control" name="numeroPatrimonio" id="numeroPatrimonioCadastrar" maxlength="20" required>
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
                <textarea class="form-control" name="localizacao" id="localizacaoCadastrar" maxlength="500" required></textarea>
                <span class="input-group-text" id="contadorLocalizacaoCadastrar">0/500</span>
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
                <input id="memorandoCadastrar" type="text" class="form-control" name="memorando" maxlength="30" disabled>
                <span class="input-group-text" id="contadorMemorandoCadastrar">0/30</span>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" onclick="limparCamposCadastrar()" data-bs-dismiss="modal">Cancelar</button>
              <input type="submit" class="btn btn-success">
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Editar Patrimônio Step 1 -->
    <div class="modal fade" id="ModalEditarPatrimonio" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalEditarLabel">Editar Patrimônio - Digite o número do patrimônio</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
          </div>
          <form action="" method="POST">
            <div class="modal-body">
              <div class="input-group mb-3">
                <span class="input-group-text">Nº Patrimônio</span>
                <input type="text" class="form-control" name="numeroPatrimonio" id="numeroPatrimonioEditar1" maxlength="20" required>
                <span class="input-group-text" id="contadorNumeroPatrimonioEditar1">0/20</span>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger"  data-bs-dismiss="modal">Cancelar</button>
              <input type="submit" class="btn btn-success">
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Editar Patrimônio Step 2 -->
    <div class="modal fade" id="ModalEditarPatrimonioStep2" tabindex="-1" aria-labelledby="modalEditarStep2Label" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalEditarStep2Label">Editar Patrimônio</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
          </div>
          <form action="./updatePatrimonio.php" method="POST">
            <div class="modal-body">
              <div class="input-group mb-3">
                <span class="input-group-text">Nº Patrimônio</span>
                <input type="text" class="form-control" name="numeroPatrimonio" id="numeroPatrimonioEditar2" maxlength="20" required>
                <span class="input-group-text" id="contadorNumeroPatrimonioEditar2">0/20</span>
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
                <textarea class="form-control" name="localizacao" id="localizacaoEditar" maxlength="500" required></textarea>
                <span class="input-group-text" id="contadorLocalizacaoEditar">0/500</span>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Status</span>
                <select id="statusEditar" name="status" class="form-select" required>
                  <option selected disabled value="">Selecione uma Opção</option>
                  <option value="tombado">Tombado</option>
                  <option value="descarte">Descarte</option>
                </select>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text">Memorando</span>
                <input id="memorandoEditar" type="text" class="form-control" name="memorando" maxlength="30" disabled>
                <span class="input-group-text" id="contadorMemorandoEditar">0/30</span>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger"  data-bs-dismiss="modal">Cancelar</button>
              <input type="submit" class="btn btn-success">
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Excluir Patrimônio -->
    <div class="modal fade" id="ModalExcluirPatrimonio" tabindex="-1" aria-labelledby="modalExcluirLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalExcluirLabel">Excluir Patrimônio</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
          </div>
          <form action="./deletePatrimonio.php" method="POST">
            <div class="modal-body">
              <div class="input-group mb-3">
                <span class="input-group-text">Nº Patrimônio</span>
                <input type="text" class="form-control" name="numeroPatrimonio" id="numeroPatrimonioExcluir" maxlength="20" required>
                <span class="input-group-text" id="contadorNumeroPatrimonioExcluir">0/20</span>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger"  data-bs-dismiss="modal">Cancelar</button>
              <input type="submit" class="btn btn-success">
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Descarte Patrimônio -->
    <div class="modal fade" id="ModalDescartePatrimonio" tabindex="-1" aria-labelledby="modalDescarteLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalDescarteLabel">Descarte Patrimônio</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
          </div>
          <form action="./insertPatrimonio.php" method="POST">
            <div class="modal-body">
              <div class="input-group mb-3">
                <span class="input-group-text">Nº Patrimônio</span>
                <input type="text" class="form-control" name="numeroPatrimonio" id="numeroPatrimonioDescarte" maxlength="20" required>
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
                <span class="input-group-text" id="contadorLocalizacaoDescarte">0/500</span>
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
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
              <input type="submit" class="btn btn-success">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
</body>

</html>