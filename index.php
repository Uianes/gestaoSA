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
  <nav class="navbar bg-body-secondary border-bottom sticky-top">
    <div class="container-fluid d-flex justify-content-start">
      <a class="navbar-brand" href="#">GestãoSA</a>
      <button class="btn btn-primary ms-3" type="button" data-bs-toggle="modal" data-bs-target="#ModalCadastrarPatrimonio">
        Cadastrar Patrimônio
      </button>
      <form class="d-flex ms-auto" method="POST">
        <div class="input-group mx-1">
          <input class="form-control" type="search" name="search" placeholder="Busca" aria-label="busca">
          <button class="btn btn-success" type="submit" title='Buscar'><i class="bi bi-search"></i></button>
        </div>
      </form>
      <form method="POST">
        <button class="btn btn-primary" name="reload" type="submit" title='Recarregar tabela'><i class="bi bi-arrow-clockwise"></i></button>
      </form>
    </div>
  </nav>

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

            $search = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
              $search = $_POST['search'];
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reload'])) {
              $search = '';
            }

            $sql = "SELECT * FROM patrimonio";
            if ($search !== '') {
              $sql .= " WHERE N_Patrimonio LIKE '%$search%'";
            }

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

                if ($row['Status'] === 'Tombado') {
                  echo "<td class='text-center'>
                        <button class='btn btn-primary btn-sm' title='Editar'
                          onclick=\"abrirModalEditar('{$row['N_Patrimonio']}', '{$row['Descricao']}', '{$row['Data_Entrada']}', '{$row['Localizacao']}', '{$row['Descricao_Localizacao']}', '{$row['Status']}', '{$row['Memorando']}')\">
                          <i class='bi bi-pencil-fill'></i>
                        </button>
                        <button class='btn btn-danger btn-sm' title='Excluir'
                          onclick=\"abrirModalExcluir('{$row['N_Patrimonio']}', '{$row['Descricao']}', '{$row['Data_Entrada']}', '{$row['Localizacao']}', '{$row['Descricao_Localizacao']}', '{$row['Status']}', '{$row['Memorando']}')\">
                          <i class=\"bi bi-trash-fill\"></i>
                        </button>
                        <button class='btn btn-warning btn-sm' title='Descarte'
                          onclick=\"abrirModalDescarte('{$row['N_Patrimonio']}', '{$row['Descricao']}', '{$row['Data_Entrada']}', '{$row['Localizacao']}', '{$row['Descricao_Localizacao']}', '{$row['Memorando']}')\">
                          <i class=\"bi bi-archive-fill\"></i>
                        </button>
                      </td>";
                } else {
                  echo "<td class='text-center'>
                        <button class='btn btn-primary btn-sm' title='Editar'
                          onclick=\"abrirModalEditar('{$row['N_Patrimonio']}', '{$row['Descricao']}', '{$row['Data_Entrada']}', '{$row['Localizacao']}', '{$row['Descricao_Localizacao']}', '{$row['Status']}', '{$row['Memorando']}')\">
                          <i class='bi bi-pencil-fill'></i>
                        </button>
                        <button class='btn btn-danger btn-sm' title='Excluir'
                          onclick=\"abrirModalExcluir('{$row['N_Patrimonio']}', '{$row['Descricao']}', '{$row['Data_Entrada']}', '{$row['Localizacao']}', '{$row['Descricao_Localizacao']}', '{$row['Status']}', '{$row['Memorando']}')\">
                          <i class=\"bi bi-trash-fill\"></i>
                        </button>
                      </td>";
                }
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

    <?php include './modals/modalCadastrar.php'; ?>

    <?php include './modals/modalEditar.php'; ?>

    <?php include './modals/modalExcluir.php'; ?>

    <?php include './modals/modalDescarte.php'; ?>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
  <script src="./scripts.js"></script>
</body>

</html>