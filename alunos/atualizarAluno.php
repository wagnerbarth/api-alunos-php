<?php

require_once '../config/cors.php';
// inclui a conexão com o banco de dados e a classe Aluno
require_once '../config/database.php';
require_once '../objects/aluno.php';

// conecta ao banco de dados
$database = new Database();
$db = $database->getConnection();

// cria o objeto Aluno
$aluno = new Aluno($db);

// recebe os dados enviados na requisição
$data = json_decode(file_get_contents("php://input"));

// define os dados do aluno
$aluno->nome = $data->nome;
$aluno->turma = $data->turma;
$aluno->sala = $data->sala;
$aluno->periodo = $data->periodo;

// define o id do aluno a ser atualizado
$aluno->id = $data->id;

// atualiza os dados do aluno
if($aluno->update()){

    // código de resposta - 200 OK
    http_response_code(200);

    // mensagem de sucesso
    echo json_encode(array("message" => "Aluno atualizado com sucesso.", "status" => 1));
}

// se não for possível atualizar o aluno
else{

    // código de resposta - 503 Service Unavailable
    http_response_code(503);

    // mensagem de erro
    echo json_encode(array("message" => "Não foi possível atualizar o aluno.", "status" => 0));
}
