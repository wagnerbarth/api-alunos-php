<?php

// cabeçalhos da API
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// obtém a conexão com o banco de dados
include_once '../config/database.php';

// inclui a classe Aluno
include_once '../objects/aluno.php';

$database = new Database();
$db = $database->getConnection();

// instancia o objeto Aluno
$aluno = new Aluno($db);

// recebe os dados enviados no corpo da requisição
$data = json_decode(file_get_contents("php://input"));

// verifica se todos os dados obrigatórios foram informados
if(
    !empty($data->ra) &&
    !empty($data->nome) &&
    !empty($data->turma) &&
    !empty($data->sala) &&
    !empty($data->periodo)
){

    // define as propriedades do aluno
    $aluno->ra = $data->ra;
    $aluno->nome = $data->nome;
    $aluno->turma = $data->turma;
    $aluno->sala = $data->sala;
    $aluno->periodo = $data->periodo;

    // Armazena retorno do objeto criar aluno
    $retorno = $aluno->criarAluno();


    // cria o aluno
    if($retorno === true){

        // código de resposta - 201 Created
        http_response_code(201);

        // mensagem de sucesso
        echo json_encode(array("message" => "Aluno criado com sucesso.", "status" => 1));
    }
    else if($retorno === 23000) {
        
        // código de resposta - 503 Service Unavailable
        http_response_code(503);

        echo json_encode(array("message" => "Aluno não pode ser criado, RA duplicado.", "status" => 0));
    }
    else{

        // código de resposta - 503 Service Unavailable
        http_response_code(503);
 
         echo json_encode(array("message" => "Aluno não pode ser criado.", "status" => 3));
    }   
}
else{

    // código de resposta - 400 Bad Request
    http_response_code(400);

    // mensagem de dados incompletos
    // echo json_encode(array("message" => "Aluno não criado. Dados incompletos."));
    echo json_encode(array("status" => 4));
}