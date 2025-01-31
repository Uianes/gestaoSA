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
      <form class="d-flex">
        <div class="input-group mx-1">
          <input class="form-control" type="search" id="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="button" onclick="searchTabela(document.getElementById('search').value)"><i class="bi bi-search"></i></button>
        </div>
        <button class="btn btn-outline-primary" type="button" onclick="location.reload(true)"><i class="bi bi-arrow-clockwise"></i></button>
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
        <table class='table table-bordered mt-3 table-striped' id="table">
          <thead class="text-center">
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
            <?php
            include 'db_connection.php';
            $conn = open_connection();
            $sql = "SELECT * FROM patrimonio";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $dataEntrada = date('d/m/Y', strtotime($row['Data_Entrada']));
                echo "<tr>";
                echo "<td>" . $row['N_Patrimonio'] . "</td>";
                echo "<td>" . $row['Descricao'] . "</td>";
                echo "<td>" . $dataEntrada . "</td>";
                echo "<td>" . $row['Localizacao'] . "</td>";
                echo "<td>" . $row['Descricao_Localizacao'] . "</td>";
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['Memorando'] . "</td>";
                echo "<td class='text-center'>
                        <button class='btn btn-primary btn-sm'
                          onclick=\"abrirModalEditar('{$row['N_Patrimonio']}', '{$row['Descricao']}', '{$row['Data_Entrada']}', '{$row['Localizacao']}', '{$row['Descricao_Localizacao']}', '{$row['Status']}', '{$row['Memorando']}')\">
                          <i class='bi bi-pencil'></i>
                        </button>
                        <button class='btn btn-danger btn-sm'><i class='bi bi-trash'></i></button>
                      </td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='8' class='text-center'>Nenhum patrimônio encontrado</td></tr>";
            }

            close_connection($conn);
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    <div class="row justify-content-center">
      <div class="col-10">
        <nav aria-label="Page navigation"></nav>
        <ul class="pagination justify-content-end">
        </ul>
        </nav>
      </div>
    </div>

    <!-- Modal Cadastrar Patrimônio -->
    <?php include './modals/modalCadastrar.php'; ?>

    <!-- Modal Editar Patrimônio-->
    <?php include './modals/modalEditar.php'; ?>

    <!-- Modal Excluir Patrimônio -->
    <?php include './modals/modalExcluir.php'; ?>

    <!-- Modal Descarte Patrimônio 1 -->
    <?php include './modals/modalDescarte.php'; ?>

    <!-- Modal Descarte Patrimônio 2-->
    <?php include './modals/modalDescarte2.php'; ?>
  </div>

  <script src="./scripts.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
</body>

</html>