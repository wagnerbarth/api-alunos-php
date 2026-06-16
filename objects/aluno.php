<?php

class Aluno{
 
    // conexão com banco de dados e definição de tabelas
    private $conn;
    private $table_name = "alunos";
 
    // propriedades do objeto
    public $id;
    public $ra;
    public $nome;
    public $turma;
    public $sala;
    public $periodo;
 
    // construtor com $db como conexão
    public function __construct($db){
        $this->conn = $db;
    }
    
// consulta aluno
function verificarAluno(){

    // query que carrega um único aluno
    $query = "SELECT
                    u.id,
                    u.ra,
                    u.nome,
                    u.turma,
                    u.sala,
                    u.periodo
              FROM
                    " . $this->table_name . " u
              WHERE
                    u.ra = ?
              LIMIT
                    0,1";

    // prepara a query
    $stmt = $this->conn->prepare($query);

    // define o RA do aluno a ser consultado
    $stmt->bindParam(1, $this->ra);

    // executa a query
    $stmt->execute();

    // obtém o registro encontrado
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $this->id = $row['id'];
        $this->ra = $row['ra'];
        $this->nome = $row['nome'];
        $this->turma = $row['turma'];
        $this->sala = $row['sala'];
        $this->periodo = $row['periodo'];
    }
}
    
    // cadastrar aluno
/*
{
    "ra" : "1001",
    "nome" : "wagner antonio barth",
    "turma" : "LPW",
    "sala" : "43",
    "periodo" : "noturno"
}
*/
function criarAluno(){

    // query para inserir um novo aluno
    $query = "INSERT INTO
                    " . $this->table_name . "
              SET
                    ra = :ra,
                    nome = :nome,
                    turma = :turma,
                    sala = :sala,
                    periodo = :periodo";

    // prepara a query
    $stmt = $this->conn->prepare($query);

    // limpa caracteres especiais
    $this->ra = htmlspecialchars(strip_tags($this->ra));
    $this->nome = htmlspecialchars(strip_tags($this->nome));
    $this->turma = htmlspecialchars(strip_tags($this->turma));
    $this->sala = htmlspecialchars(strip_tags($this->sala));
    $this->periodo = htmlspecialchars(strip_tags($this->periodo));

    // define os valores dos parâmetros
    $stmt->bindParam(":ra", $this->ra);
    $stmt->bindParam(":nome", $this->nome);
    $stmt->bindParam(":turma", $this->turma);
    $stmt->bindParam(":sala", $this->sala);
    $stmt->bindParam(":periodo", $this->periodo);

    // executa a query
    try {

        if($stmt->execute()){
            return true;
        }

        return false;

    } catch (PDOException $e) {

        if ($e->getCode() == 23000) {
            // RA duplicado
            return 23000;
        }

        return false;
    }
}
    
    // atualiza 
    /*
     {
    "id" : "54",
	"nome" : "Wagner Barth",
    "turma" : "DDM",
    "sala" : "23",
    "periodo" : "vespertino",
     } 
     */
    function update(){

    

        // update query
        $query = "UPDATE " . $this->table_name . "
              SET
                  nome = :nome,
                  turma = :turma,
                  sala = :sala,
                  periodo = :periodo
              WHERE id = :id";

        // prepara a query
        $stmt = $this->conn->prepare($query);

        // limpa
        $this->nome=htmlspecialchars(strip_tags($this->nome)); 
        $this->turma=htmlspecialchars(strip_tags($this->turma));
        $this->sala=htmlspecialchars(strip_tags($this->sala));
        $this->periodo=htmlspecialchars(strip_tags($this->periodo)); 

       
        // atualiza valores
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":turma", $this->turma);
        $stmt->bindParam(":sala", $this->sala);
        $stmt->bindParam(":periodo", $this->periodo);

        // executa a query
        if($stmt->execute()){
            // verifica se registros foram modificados
            if ($stmt->rowCount() == 1)
                return true;
            else {
                return false;
            }
        }

        return false;
    }
    
    // remove aluno
    /*
    {
        "id" : "1001"
    }
    */
    function delete(){

        // query para remover o aluno
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // prepara a query
        $stmt = $this->conn->prepare($query);

        // limpa caracteres especiais
        $this->id = htmlspecialchars(strip_tags($this->id));

        // define o registro a ser removido
        $stmt->bindParam(1, $this->id);

        // executa a query
        if($stmt->execute()){
            if ($stmt->rowCount() == 1)
                return true;
            else {
                return false;
            }
        }

        return false;
    }

    // listar alunos
    public function listarAlunos()
    {
        $query = "SELECT
                        u.id,
                        u.ra,
                        u.nome,
                        u.turma,
                        u.sala,
                        u.periodo
                FROM
                        " . $this->table_name . " u";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
           
    }

}