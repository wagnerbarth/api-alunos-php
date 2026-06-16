<?php

/* database script

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE `alunos` (
  `id` int(11) NOT NULL,
  `ra` varchar(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `turma` varchar(50) NOT NULL,
  `sala` varchar(20) NOT NULL,
  `periodo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices da tabela `alunos`
--

ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ra` (`ra`);

--
-- AUTO_INCREMENT da tabela `alunos`
--

ALTER TABLE `alunos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- Inserindo dados da tabela `alunos`
--

INSERT INTO `alunos`
(`ra`, `nome`, `turma`, `sala`, `periodo`)
VALUES
('1001', 'Wagner Barth', 'DDM', '23', 'vespertino'),
('1002', 'João Carlos', 'LPW', '43', 'noturno');
*/

class Database{

    // especifica as credenciais de conexão
    private $host = "localhost";
    private $db_name = "escola";
    private $username = "wagner";
    private $password = "Wagner@123456";
    private ?PDO $conn;

    // estabelece a conexão com o banco de dados
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );

            $this->conn->exec("set names utf8");

        }catch(PDOException $exception){

            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}