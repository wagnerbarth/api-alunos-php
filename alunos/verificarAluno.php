<?php

// Exemplo:
// http://localhost:3000/alunos/verificarAluno.php?ra=1001

// // cabeçalhos da API
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: access");
// header("Access-Control-Allow-Methods: GET");
// header("Access-Control-Allow-Credentials: true");
// header('Content-Type: application/json');
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

// obtém a conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

// cria o objeto Aluno
$aluno = new Aluno($db);

// define o RA do aluno a ser consultado
$aluno->ra = isset($_GET['ra']) ? $_GET['ra'] : die();

// consulta o aluno
$aluno->verificarAluno();

if($aluno->id != null){

    // monta o array de retorno
    $aluno_arr = array(
        "id" => $aluno->id,
        "ra" => $aluno->ra,
        "nome" => $aluno->nome,
        "turma" => $aluno->turma,
        "sala" => $aluno->sala
        //"status" => 1
    );

    // código de resposta - 200 OK
    http_response_code(200);

    // retorna os dados do aluno em formato JSON
    echo json_encode($aluno_arr);

}else{

    // informa que o aluno não está cadastrado
    echo json_encode(array("message" => "Aluno não cadastrado.", "status" => 0));

    // código de resposta - 404 Not Found
    // http_response_code(404);
}