<?php
require 'banco.php';
$id = 0;

header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json; charset=utf-8');

if (!empty($_POST)) {
    $id = $_POST['id'];

    try {
        $pdo = Banco::conectar();

        if ($id != 0) {
            $sql = 'SELECT * FROM unidades WHERE id = ?';
            $q = $pdo->prepare($sql);
            $q->execute(array($id));
            $data = $q->fetch(PDO::FETCH_ASSOC);
        } else {
            $sql = 'SELECT * FROM unidades;';
            $q = $pdo->query($sql);
            $data = $q->fetchAll();
        }

        

        Banco::desconectar();
    } catch (PDOException $e) {
        echo json_encode(array('erro' => '1', 'msg' => 'Error ao adicionar o item:' . $e->getMessage()));
    }

    echo json_encode(array($data));
}
