<?php
require_once "conexao.php";

function listarEstados(){
    $conn = conectar();

    $stmt = $conn->prepare("select id, sigla ,descricao from estados");
    $stmt->execute();    
    return  $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function salvarCliente($cliente){  
    $ativo = true;
    $acesso = 1;
    $conn = conectar();    
    $stmt = $conn->prepare('INSERT INTO cliente (nome, dtNascimento, cpf, telefone, cep, rua, numero, bairro, id_estado, email, senha, ativo, acesso)
    VALUES(:nome, :dtNascimento, :cpf, :telefone, :cep, :rua, :numero, :bairro, :id_estado, :email, :senha, :ativo, :acesso)');
    
    $stmt->bindParam(':nome',$cliente['nome']);
    $stmt->bindParam(':dtNascimento',$cliente['dtNascimento']);
    $stmt->bindParam(':cpf',$cliente['cpf']);
    $stmt->bindParam(':telefone',$cliente['telefone']);
    $stmt->bindParam(':cep',$cliente['cep']);
    $stmt->bindParam(':rua',$cliente['rua']);
    $stmt->bindParam(':numero',$cliente['numero']);
    $stmt->bindParam(':bairro',$cliente['bairro']);
    $stmt->bindParam(':id_estado',$cliente['id_estado']);
    $stmt->bindParam(':email',$cliente['email']);
    $stmt->bindParam(':senha',$cliente['senha']);
    $stmt->bindParam(':ativo',$ativo);
    $stmt->bindParam(':acesso',$acesso);

    if ($stmt->execute()) {
        return "Cliente inserido com sucesso!";
    } else {
        print_r($stmt->errorInfo());
        return "erro! ";
    }  
}

function listarCliente() {
    $conn = conectar();

    $stmt = $conn->prepare("SELECT id, nome, email, telefone, ativo  from cliente ");
    $stmt->execute();
    $retorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $retorno;
}
function editarCliente($cliente){
    $conn = conectar();    

    $stmt = $conn->prepare('UPDATE cliente SET nome = :nome, dtNascimento = :dtNascimento, cpf = :cpf, 
    telefone = :telefone, cep = :cep , rua = :rua, numero = :numero, bairro = :bairro, 
    id_estado = :id_estado, email = :email, senha = :senha, ativo = :ativo  WHERE id = :id');

    $stmt->bindParam(':nome',$cliente['nome']);
    $stmt->bindParam(':dtNascimento',$cliente['dtNascimento']);
    $stmt->bindParam(':cpf',$cliente['cpf']);
    $stmt->bindParam(':telefone',$cliente['telefone']);
    $stmt->bindParam(':cep',$cliente['cep']);
    $stmt->bindParam(':rua',$cliente['rua']);
    $stmt->bindParam(':numero',$cliente['numero']);
    $stmt->bindParam(':bairro',$cliente['bairro']);
    $stmt->bindParam(':id_estado',$cliente['id_estado']);
    $stmt->bindParam(':email',$cliente['email']);
    $stmt->bindParam(':senha',$cliente['senha']);
    $stmt->bindParam(':ativo',$cliente['ativo']);
    $stmt->bindParam(':id',$cliente['id']);

    if ($stmt->execute()) {
        return "Cliente alterado com sucesso!";
    } else {
        print_r($stmt->errorInfo());
        return "erro! ";
    }  
}

function excluirCliente($id){
    $ativo = false;
    $conn = conectar();
    $stmt = $conn->prepare('UPDATE cliente SET ativo = :ativo where id = :id');
    $stmt->bindParam(':ativo',$ativo);
    $stmt->bindParam(':id',$cliente['id']);
    if ($stmt->execute()) {
        return "Cliente removido com sucesso!";
    } else {
        print_r($stmt->errorInfo());
        return "erro! ";
    }  
}

function buscarCliente($id){
    $conn = conectar();    
    $stmt = $conn->prepare('SELECT id, nome, dtNascimento, cpf, telefone, cep, rua, numero, bairro, id_estado, email, senha, ativo, acesso from cliente where id = :id');
    $stmt->bindParam(':id',$id);
    $stmt->execute();    
    return $stmt->fetch(PDO::FETCH_ASSOC); 
}

function validarLogin($email,$senha) {
    $conn = conectar();
    $ativo = true;

    $stmt = $conn->prepare("select id from cliente where email = :email and senha = :senha and ativo = :ativo");

    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':senha',$senha);
    $stmt->bindParam(':ativo',$ativo);
    $stmt->execute();    
    return $stmt->fetch(PDO::FETCH_ASSOC);    
}
?>