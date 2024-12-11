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
  // armazena no array para o JSON
  while ($row = mysqli_fetch_assoc($result)) {
    // Formata a data para o padrão brasileiro (dd/mm/yyyy)
    $row["Data_Entrada"] = date('d/m/Y', strtotime($row["Data_Entrada"]));
    // Adiciona cada linha ao array para o JSON
    $data[] = $row;
  }

  // Salva o JSON em um arquivo
  $jsonData = json_encode($data, JSON_PRETTY_PRINT);
  file_put_contents('temp_patrimonio.json', $jsonData);
} else {
  echo "Nenhum resultado encontrado";
}

mysqli_close($conn);
?>

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

          </tbody>
        </table>
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

  <script>
    // Inicializar variáveis para paginação
    let currentPage = 1;                // Página atual
    const recordsPerPage = 10;          // Número de registros por página
    let patrimonioData = [];            // Array para armazenar os dados buscados

    // Função assíncrona para buscar dados do arquivo JSON
    async function fetchData() {
        try {
            // Buscar dados do 'temp_patrimonio.json'
            const response = await fetch('temp_patrimonio.json');
            if (!response.ok) {
                throw new Error('Erro ao carregar o arquivo JSON');
            }
            // Analisar e armazenar os dados JSON
            patrimonioData = await response.json();
            // Renderizar a tabela e a paginação
            renderTabela(currentPage);
            renderPagination();
        } catch (error) {
            console.error('Erro:', error);
        }
    }

    // Função para renderizar a tabela na página atual
    function renderTabela(page) {
        const tableBody = document.querySelector('#table tbody');
        // Limpar o conteúdo atual da tabela
        tableBody.innerHTML = '';

        // Calcular índices de início e fim para a página atual
        const start = (page - 1) * recordsPerPage;
        const end = start + recordsPerPage;
        const pageData = patrimonioData.slice(start, end);

        // Iterar sobre os dados da página e criar linhas na tabela
        pageData.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
            <th scope='row'>${item.N_Patrimonio}</th>
            <td>${item.Descricao}</td>
            <td>${item.Data_Entrada}</td>
            <td>${item.Localizacao}</td>
            <td>${item.Descricao_Localizacao}</td>
            <td>${item.Status}</td>
            <td>${item.Memorando}</td>
            <td class='text-center'>
              <button class="btn" type='button' onclick="carregarDadosEditar('${item.N_Patrimonio}')"><i class='bi bi-pencil-fill'></i></button>
              <button class="btn btn-danger" type='button' onclick="carregarDadosExcluir('${item.N_Patrimonio}')"><i class='bi bi-trash-fill'></i></button>
            </td>
          `;
            // Adicionar a linha à tabela
            tableBody.appendChild(row);
        });
    }

    // Função para renderizar a paginação
    function renderPagination() {
        const pagination = document.querySelector('.pagination');
        // Limpar a paginação atual
        pagination.innerHTML = '';

        // Calcular o número total de páginas
        const totalPages = Math.ceil(patrimonioData.length / recordsPerPage);

        // Função auxiliar para criar um item de paginação
        const createPageItem = (page, text = page) => {
            const li = document.createElement('li');
            li.className = `page-item ${page === currentPage ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#">${text}</a>`;
            // Evento para mudar de página ao clicar
            li.addEventListener('click', () => {
                currentPage = page;
                renderTabela(currentPage);
                renderPagination();
            });
            return li;
        };

        // Adicionar botão "anterior" se não estiver na primeira página
        if (currentPage > 1) {
            pagination.appendChild(createPageItem(currentPage - 1, '<i class="bi bi-caret-left"></i>'));
        }

        // Sempre mostrar a primeira página
        pagination.appendChild(createPageItem(1));

        // Adicionar reticências se estiver além da terceira página
        if (currentPage > 3) {
            pagination.appendChild(createPageItem(null, '...'));
        }

        // Mostrar números de páginas próximos à página atual
        for (let i = Math.max(2, currentPage - 2); i <= Math.min(totalPages - 1, currentPage + 2); i++) {
            pagination.appendChild(createPageItem(i));
        }

        // Adicionar reticências se não estiver próximo ao final
        if (currentPage < totalPages - 2) {
            pagination.appendChild(createPageItem(null, '...'));
        }

        // Sempre mostrar a última página
        pagination.appendChild(createPageItem(totalPages));

        // Adicionar botão "próximo" se não estiver na última página
        if (currentPage < totalPages) {
            pagination.appendChild(createPageItem(currentPage + 1, '<i class="bi bi-caret-right"></i>'));
        }
    }

    // Carregar os dados quando o documento estiver pronto
    document.addEventListener('DOMContentLoaded', fetchData);

    // Função para pesquisar na tabela com base em um valor
    async function searchTabela(valor) {
        try {
            const tableBody = document.querySelector('#table tbody');

            // Buscar dados do arquivo JSON
            const response = await fetch('temp_patrimonio.json');
            if (!response.ok) {
                throw new Error('Erro ao carregar o arquivo JSON');
            }
            const data = await response.json();

            // Encontrar o item cujo N_Patrimonio inclui o valor
            const patrimonioData = data.find(item => item.N_Patrimonio.includes(valor));
            if (!patrimonioData) {
                console.error('Patrimônio não encontrado no JSON');
                tableBody.innerHTML = '';
                return;
            }

            // Limpar o conteúdo atual da tabela
            tableBody.innerHTML = '';

            // Criar uma nova linha com os dados encontrados
            const row = document.createElement('tr');
            row.innerHTML = `
              <th scope='row'>${patrimonioData.N_Patrimonio}</th>
              <td>${patrimonioData.Descricao}</td>
              <td>${patrimonioData.Data_Entrada}</td>
              <td>${patrimonioData.Localizacao}</td>
              <td>${patrimonioData.Descricao_Localizacao}</td>
              <td>${patrimonioData.Status}</td>
              <td>${patrimonioData.Memorando}</td>
              <td class='text-center'>
                <button class="btn" type='button' onclick="carregarDadosEditar('${patrimonioData.N_Patrimonio}')"><i class='bi bi-pencil-fill'></i></button>
                <button class="btn btn-danger" type='button' onclick="carregarDadosExcluir('${patrimonioData.N_Patrimonio}')"><i class='bi.bi-trash-fill'></i></button>
              </td>
            `;
            // Adicionar a linha à tabela
            tableBody.appendChild(row);

        } catch (error) {
            console.error('Erro:', error);
        }
    }

    // Função para carregar dados no modal de edição
    async function carregarDadosEditar(patrimonio) {
        try {
            // Carrega o arquivo JSON
            const response = await fetch('temp_patrimonio.json');
            if (!response.ok) {
                throw new Error('Erro ao carregar o arquivo JSON');
            }
            const data = await response.json();

            // Encontrar o item correspondente ao patrimônio
            const patrimonioData = data.find(item => item.N_Patrimonio == patrimonio);
            if (!patrimonioData) {
                console.error('Patrimônio não encontrado no JSON');
                return;
            }

            // Preencher os campos do modal com os dados do item
            document.getElementById("numeroPatrimonioEditar").value = patrimonioData.N_Patrimonio;
            document.getElementById("numeroPatrimonioEditar_backup").value = patrimonioData.N_Patrimonio;
            document.getElementById("descricaoEditar").value = patrimonioData.Descricao;
            document.getElementById("dataEntradaEditar").value = patrimonioData.Data_Entrada;
            document.getElementById("localizacaoEditar").value = patrimonioData.Localizacao;
            document.getElementById("DescricaoLocalizacaoEditar").value = patrimonioData.Descricao_Localizacao;
            document.getElementById("statusEditar").value = patrimonioData.Status;
            document.getElementById("memorandoEditar").value = patrimonioData.Memorando;

            // Exibir o modal de edição
            var modal = new bootstrap.Modal(document.getElementById('ModalEditarPatrimonio'));
            modal.show();

        } catch (error) {
            console.error('Erro:', error);
        }
    }

    // Função para carregar dados no modal de exclusão
    async function carregarDadosExcluir(patrimonio) {
        try {
            // Buscar dados do arquivo JSON
            const response = await fetch('temp_patrimonio.json');
            if (!response.ok) {
                throw new Error('Erro ao carregar o arquivo JSON');
            }
            const data = await response.json();

            // Encontrar o item correspondente ao patrimônio
            const patrimonioData = data.find(item => item.N_Patrimonio == patrimonio);
            if (!patrimonioData) {
                console.error('Patrimônio não encontrado no JSON');
                return;
            }

            // Preencher os campos do modal com os dados do item
            document.getElementById("numeroPatrimonioExcluir").value = patrimonioData.N_Patrimonio;
            document.getElementById("numeroPatrimonioExcluir_backup").value = patrimonioData.N_Patrimonio;
            document.getElementById("descricaoExcluir").value = patrimonioData.Descricao;
            document.getElementById("dataEntradaExcluir").value = patrimonioData.Data_Entrada;
            document.getElementById("localizacaoExcluir").value = patrimonioData.Localizacao;
            document.getElementById("statusExcluir").value = patrimonioData.Status;
            document.getElementById("memorandoExcluir").value = patrimonioData.Memorando;

            // Exibir o modal de exclusão
            var modal = new bootstrap.Modal(document.getElementById('ModalExcluirPatrimonio'));
            modal.show();

        } catch (error) {
            console.error('Erro:', error);
        }
    }

    // Função para carregar dados no modal de descarte
    async function carregarDadosDescarte(patrimonio) {
        try {
            // Buscar dados do arquivo JSON
            const response = await fetch('temp_patrimonio.json');
            if (!response.ok) {
                throw new Error('Erro ao carregar o arquivo JSON');
            }
            const data = await response.json();

            // Encontrar o item correspondente ao patrimônio
            const patrimonioData = data.find(item => item.N_Patrimonio == patrimonio);
            if (!patrimonioData) {
                alert('Patrimônio não encontrado');
                return;
            }
            // Verificar se o item já está descartado
            if (patrimonioData.Status == "Descarte") {
                alert('Patrimônio já descartado');
                return;
            }

            // Preencher os campos do modal com os dados do item
            document.getElementById("numeroPatrimonioDescarte2").value = patrimonioData.N_Patrimonio;
            document.getElementById("numeroPatrimonioDescarte_backup").value = patrimonioData.N_Patrimonio;
            document.getElementById("descricaoDescarte").value = patrimonioData.Descricao;
            document.getElementById("dataEntradaDescarte").value = patrimonioData.Data_Entrada;
            document.getElementById("localizacaoDescarte").value = patrimonioData.Localizacao;
            document.getElementById("DescricaoLocalizacaoDescarte").value = patrimonioData.Descricao_Localizacao;

            // Exibir o modal de descarte
            var modal = new bootstrap.Modal(document.getElementById('ModalDescartePatrimonioStep2'));
            modal.show();

        } catch (error) {
            console.error('Erro:', error);
        }
    }

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
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
</body>

</html>