<?php
require 'banco.php';
$id = 0;

header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json; charset=utf-8');



if (!empty($_POST)) {
    $id = $_POST['id'];

    try {

        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM produtos where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Banco::desconectar();
    } catch (PDOException $e) {
        echo json_encode(array('erro' => '1', 'msg' => 'Error ao adicionar o item:' . $e->getMessage()));
    }

    echo json_encode(array('erro' => '0', 'msg' => 'Executado com sucesso!'));
}
