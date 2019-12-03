<?php
require 'banco.php';

function getCategoriaID($name)
{
   $pdo = Banco::conectar();
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $sql = "SELECT id FROM categorias WHERE nome LIKE CONCAT('%',?,'%') ;";
   $q = $pdo->prepare($sql);
   $q->execute(array($name));
   $data = $q->fetch(PDO::FETCH_ASSOC);
   Banco::desconectar();

   return $data['id'];
}

function getUnidadeID($name)
{
   $pdo = Banco::conectar();
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $sql = "SELECT id FROM unidades WHERE nome LIKE CONCAT('%',?,'%') ;";
   $q = $pdo->prepare($sql);
   $q->execute(array($name));
   $data = $q->fetch(PDO::FETCH_ASSOC);
   Banco::desconectar();

   return $data['id'];
}

if (!empty($_POST)) {
   //Acompanha os erros de validação
   $nomeErro = null;

   $nome = $_POST['nome'];
   $quantidade = $_POST['quantidade'];
   $unidade = $_POST['unidade'];
   $categoria = $_POST['categoria'];
   $preco = $_POST['preco'];

   //Validaçao dos campos:
   $validacao = true;

   if (empty($nome)) {
      $nomeErro .= 'Por favor digite o seu nome!';
      $nomeErro .= "\n";
      $validacao = false;
   }

   if (empty($quantidade)) {
      $nomeErro .= 'Por favor digite a quantidade!';
      $nomeErro .= "\n";
      $validacao = false;
   }

   if (empty($unidade)) {
      $nomeErro .= 'Selecione a unidade!';
      $nomeErro .= "\n";
      $validacao = false;
   }

   if (empty($categoria)) {
      $nomeErro .= 'Selecione a categoria!';
      $nomeErro .= "\n";
      $validacao = false;
   }

   if (empty($preco)) {
      $nomeErro .= 'Por favor digite o preco!';
      $nomeErro .= "\n";
      $validacao = false;
   }

   //Inserindo no Banco:
   if ($validacao) {
      $unidade = getUnidadeID($unidade);
      $categoria = getCategoriaID($categoria);
      $preco = preg_replace('/[.]/', '', $preco);
      $preco = preg_replace('/[,]/', '.', $preco);

      try {
         $pdo = Banco::conectar();
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $sql = "INSERT INTO produtos(nome, quantidade, id_unidade, preco, id_categoria) VALUES (?,?,?,?,?)";
         $q = $pdo->prepare($sql);
         $q->execute(array($nome, $quantidade, $unidade, $preco, $categoria));

         Banco::desconectar();
      } catch (PDOException $e) {
         echo 'Error ao adicionar o item: ' . $e->getMessage();
      }
      
      if ($q) {
         echo 'Item adicionado com sucesso!';
      }
   } else {
      echo $nomeErro;
   }
}
