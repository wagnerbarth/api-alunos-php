<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../config/database.php';
include_once '../objects/aluno.php';

$database = new Database();
$db = $database->getConnection();

$aluno = new Aluno($db);

// consulta os alunos
$stmt = $aluno->listarAlunos();

if ($stmt->rowCount() > 0) {

    $alunos_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $alunos_arr[] = array(
            "id" => $row['id'],
            "ra" => $row['ra'],
            "nome" => $row['nome'],
            "turma" => $row['turma'],
            "sala" => $row['sala'],
            "periodo" => $row['periodo']
        );
    }

    // código de resposta - 200 OK
    http_response_code(200);

    // retorna a lista de alunos em formato JSON
    echo json_encode($alunos_arr);

} else {

    // informa que não há alunos cadastrados
    echo json_encode(array(
        "message" => "Nenhum aluno cadastrado.",
        "status" => 0
    ));

    // código de resposta - 404 Not Found
    // http_response_code(404);
}