<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>


    <script src="assets/js/bootstrap.min.js"></script>

    <title>Página Inicial</title>
</head>

<body class="bg-light">
    <header style="padding: 78px 0 50px;" class="bg-primary text-white">
        <div class="container  text-center">
            <h1>AV1 - CRUD básico</h1>
        </div>
    </header>
    <div class="container text-center align-content-between" style="padding: 78px 0 0px;">
        <div class="row py-2 justify-content-between">
            <div class="h3">
                Lista de compras
            </div>
            <div class="offset-8">
                <button type="button" data-toggle="modal" data-target="#modalAdicionar" class="btn btn-primary">
                    <div class="fas fa-plus"></div>
                    Add item
                </button>
            </div>
        </div>

        <div class="row">
            <!-- <p>
                    <a href="create.php" class="btn btn-success">Adicionar</a>
                </p> -->
            <table class="table table-hover border">
                <thead>
                    <tr>
                        <!-- <th scope="col">Id</th> -->
                        <th scope="col">Nome</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Unidade</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Categoria</th>
                        <th scope="col" class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'banco.php';
                    $pdo = Banco::conectar();

                    $sql = 'SELECT A.id, A.nome, A.quantidade, U.nome as unidade, A.preco, C.nome as categoria 
                                    FROM `produtos` A 
                                    JOIN categorias C ON A.id_categoria = C.id 
                                    JOIN unidades U ON A.id_unidade = U.id;';

                    foreach ($pdo->query($sql) as $row) {
                        echo '<tr>';
                        // echo '<th scope="row">' . $row['id'] . '</th>';
                        echo '<td>' . $row['nome'] . '</td>';
                        echo '<td>' . $row['quantidade'] . '</td>';
                        echo '<td>' . $row['unidade'] . '</td>';
                        echo '<td>R$ <a class="dinheiro">' . $row['preco'] . '</a> </td>';
                        echo '<td>' . $row['categoria'] . '</td>';
                        echo '<td class="text-center">';
                        echo '<div class="text-nowrap">';
                        echo '<a data-toggle="modal" data-target="#modalInformacao" class="btn far fa-file-alt" data-tt="tooltip" data-placement="top" title="Informação" onclick="getIdView(' . $row['id'] . ')" id="btnInfo""></a>';
                        echo ' ';
                        echo '<a data-toggle="modal" data-target="#modalEditar" class="btn fas fa-edit" data-tt="tooltip" data-placement="top" title="Atualizar" id="btnInfo" onclick="salvarItem(' . $row['id'] . ')"></a>';
                        echo ' ';
                        echo '<a data-toggle="modal" data-target="#exampleModalScrollable" class="btn far fa-trash-alt" data-tt="tooltip" data-placement="top" title="Excluir" id="btnInfo" onclick="deleteItem(' . $row['id'] . ')"></a>';
                        echo '<div>';
                        echo '</td>';
                        echo '</tr>';
                    }

                    Banco::desconectar();
                    ?>
                </tbody>
            </table>

            <div class="modal fade show" id="modalAdicionar" tabindex="-1" role="dialog" aria-labelledby="modalAdicionarTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalAdicionarTitle">Adicionar Item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body container">
                            <div class="form-group row">
                                <label for="staticName" class="col-sm-2 col-form-label">Nome:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Nome" id="staticName">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticQtd" class="col-sm-2 col-form-label">Quantidade:</label>
                                <div class="input-group-prepend col-sm-2">
                                    <input type="number" class="form-control input-group-text bg-white" id="staticQtd" />
                                </div>
                                <select id="staticUnidade" class="form-control col-1">
                                </select>

                                <label for="staticCategoria" class="col-2 col-form-label">Categoria:</label>
                                <div class="col-5">
                                    <select id="staticCategoria" class="form-control">

                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="staticPreco" class="col-sm-2 col-form-label">Preço:</label>
                                <div class="input-group col-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                    <input type="text" id="staticPreco" class="form-control dinheiro" aria-label="Quantia">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button type="button" class="btn btn-primary" onclick="createItem()">Adicionar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade show" id="modalInformacao" tabindex="-1" role="dialog" aria-labelledby="modalInformacaoTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                    <div class="modal-content">

                        <div class="modal-body">
                            <ul class="list-group">
                                <li id="itemName" class="list-group-item active "></li>
                                <li id="itemQuantidade" class="list-group-item "></li>
                                <li id="itemPreco" class="list-group-item "></li>
                                <li id="itemCategoria" class="list-group-item "></li>
                            </ul>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade show" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditarTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalAdicionarTitle">Editar Item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body container">
                            <div class="form-group row">
                                <label for="staticName" class="col-sm-2 col-form-label">Nome:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Nome" id="staticNameEdit">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticQtd" class="col-sm-2 col-form-label">Quantidade:</label>
                                <div class="input-group-prepend col-sm-2">
                                    <input type="number" class="form-control input-group-text bg-white" id="staticQtdEdit" />
                                </div>
                                <select id="staticUnidadeEdit" class="form-control col-1">
                                </select>

                                <label for="staticCategoria" class="col-2 col-form-label">Categoria:</label>
                                <div class="col-5">
                                    <select id="staticCategoriaEdit" class="form-control">

                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="staticPreco" class="col-sm-2 col-form-label">Preço:</label>
                                <div class="input-group col-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                    <input type="text" id="staticPrecoEdit" class="form-control dinheiro" aria-label="Quantia">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button type="button" class="btn btn-primary" onclick="createItem(identificadorItem)">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</body>

<script>
    var identificadorItem = 0;
    // Tooltip jQuery
    $(document).ready(function() {
        $('[data-tt="tooltip"]').tooltip();
        $('.dinheiro').mask("#.##0,00", {
            reverse: true
        });
        getUnidades();
        getCategorias();
    });

    function getIdView(id) {
        var dadosModal = document.getElementById('informacoes');

        $.ajax({
            type: "post",
            url: "produtos.php",
            dataType: "json",
            data: {
                id
            },
        }).done(function(data) {
            var {
                erro,
                msg,
                id,
                nome,
                quantidade,
                unidade,
                preco,
                categoria
            } = data;

            if (erro == 0) {

                document.getElementById('itemName').textContent = ` ${nome} (${quantidade} ${unidade})`;
                document.getElementById('itemPreco').textContent = `R$ ${preco}`;
                document.getElementById('itemCategoria').textContent = categoria;


                var th = "";


            } else {
                alert(msg);
            }
        });
    }

    function createItem(id = 0) {
        if (!id) {

            var {
                value: nome
            } = document.getElementById('staticName');
            var {
                value: quantidade
            } = document.getElementById('staticQtd');
            var {
                value: unidade
            } = document.getElementById('staticUnidade');
            var {
                value: categoria
            } = document.getElementById('staticCategoria');
            var {
                value: preco
            } = document.getElementById('staticPreco');

            $.ajax({
                    type: "post",
                    url: "create.php",
                    dataType: "html",
                    data: {
                        nome,
                        quantidade,
                        unidade,
                        categoria,
                        preco
                    },
                })
                .done(function(data) {
                    alert(data);
                    location.reload(true);
                });
        } else {
            var {
                value: nome
            } = document.getElementById('staticNameEdit');
            var {
                value: quantidade
            } = document.getElementById('staticQtdEdit');
            var {
                value: unidade
            } = document.getElementById('staticUnidadeEdit');
            var {
                value: categoria
            } = document.getElementById('staticCategoriaEdit');
            var {
                value: preco
            } = document.getElementById('staticPrecoEdit');

            $.ajax({
                    type: "post",
                    url: "update.php",
                    dataType: "html",
                    data: {
                        id,
                        nome,
                        quantidade,
                        unidade,
                        categoria,
                        preco
                    },
                })
                .done(function(data) {
                    alert(data);
                    location.reload(true);
                });
        }
    }

    function deleteItem(id) {
        if (confirm("Deseja apagar o item?")) {
            $.ajax({
                    type: "post",
                    url: "delete.php",
                    dataType: "json",
                    data: {
                        id
                    },
                })
                .done(function(data) {
                    var {
                        erro,
                        msg
                    } = data;

                    alert(msg);

                    if (erro == 0) {
                        location.reload(true);
                    }

                });
        }
    }

    function salvarItem(id) {
        identificadorItem = id;

        $.ajax({
            type: "post",
            url: "produtos.php",
            dataType: "json",
            data: {
                id
            },
        }).done(function(data) {
            var {
                erro,
                msg,
                id,
                nome,
                quantidade,
                unidade,
                preco,
                categoria
            } = data;
            if (erro == 0) {
                document.getElementById('staticNameEdit').value = nome;
                document.getElementById('staticQtdEdit').value = quantidade;
                document.getElementById('staticUnidadeEdit').value = unidade;
                document.getElementById('staticPrecoEdit').value = preco;
                document.getElementById('staticCategoriaEdit').value = categoria;
            } else {
                alert(msg);
            }
        });
    }

    function getUnidades(id = 0) {
        var elUnidade = document.getElementById('staticUnidade');
        var elUnidadeEdit = document.getElementById('staticUnidadeEdit');

        $.ajax({
            type: "post",
            url: "unidades.php",
            dataType: "json",
            data: {
                id,
            },
        }).done(function(data) {
            data[0].forEach(element => {
                var {
                    id,
                    nome
                } = element;

                var newEl = document.createElement("option");
                var newElEdit = document.createElement("option");

                newEl.textContent = nome;
                newElEdit.textContent = nome;

                elUnidade.insertBefore(newEl, elUnidade.children[elUnidade.length]);

                elUnidadeEdit.insertBefore(newElEdit, elUnidadeEdit.children[elUnidadeEdit.length]);
            });
        });
    }

    function getCategorias(id = 0) {
        var elCategoria = document.getElementById('staticCategoria');
        var elCategoriaEdit = document.getElementById('staticCategoriaEdit');

        $.ajax({
            type: "post",
            url: "categorias.php",
            dataType: "json",
            data: {
                id,
            },
        }).done(function(data) {
            data[0].forEach(element => {
                var {
                    id,
                    nome
                } = element;

                var newEl = document.createElement("option");
                var newElEdit = document.createElement("option");

                newEl.textContent = nome;
                newElEdit.textContent = nome;

                elCategoria.insertBefore(newEl, elCategoria.children[elCategoria.length]);
                elCategoriaEdit.insertBefore(newElEdit, elCategoriaEdit.children[elCategoriaEdit.length]);
            });
        });
    }
</script>

</html>