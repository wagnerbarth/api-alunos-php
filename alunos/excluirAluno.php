<?php

// // cabeçalhos da API
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: DELETE");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// inclui a conexão com o banco de dados e a classe Aluno
include_once '../config/database.php';
include_once '../objects/aluno.php';

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