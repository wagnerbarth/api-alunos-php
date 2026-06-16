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

// recebe os dados enviados no corpo da requisição
$data = json_decode(file_get_contents("php://input"));

// define o aluno a ser removido
$aluno->id = $data->id;

// remove o aluno
if($aluno->delete()){

    // código de resposta - 200 OK
    http_response_code(200);

    // mensagem de sucesso
    echo json_encode(array("message" => "Aluno removido.", "status" => 1));
}

// se não for possível remover o aluno
else{

    // código de resposta - 503 Service Unavailable
    http_response_code(503);

    // mensagem de erro
    // echo json_encode(array("message" => "Não foi possível remover o aluno."));
    echo json_encode(array("message" => "Não foi possível remover o aluno. $aluno->nome", "status" => 0));
}