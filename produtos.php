<?php
require 'banco.php';
$id = 0;

header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json; charset=utf-8');

if (!empty($_POST)) {
    $id = $_POST['id'];

    try {
        $pdo = Banco::conectar();

        $sql = 'SELECT A.id, A.nome, A.quantidade, U.nome as unidade, A.preco, C.nome as categoria 
                        FROM `produtos` A 
                        JOIN categorias C ON A.id_categoria = C.id 
                        JOIN unidades U ON A.id_unidade = U.id WHERE A.id = ?;';

        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $row = $q->fetch();

        Banco::desconectar();
    } catch (PDOException $e) {
        echo json_encode(array('erro' => '1', 'msg' => 'Error ao adicionar o item:' . $e->getMessage()));
    }

    echo json_encode(array('erro' => '0', 'msg' => 'Executado com sucesso!', 'id' => $row['id'], 'nome' => $row['nome'], 'quantidade' => $row['quantidade'], 'unidade' => $row['unidade'], 'preco' => $row['preco'], 'categoria' => $row['categoria']));
}
