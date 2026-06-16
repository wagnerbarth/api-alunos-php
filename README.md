**Documentação**

1 - Criar um Aluno (POST)

url: http://localhost:3000/alunos/criarAluno.php

JSON de envio cadastro

{
    "ra" : "1004",    
    "nome" : "Gabriela",
    "turma" : "LPW",
    "sala" : "43",
    "periodo" : "noturno"
}

*Respostas*
- Cadastro OK (200 OK)
{
	"message": "Aluno criado com sucesso.",
	"status": 1
}

- Cadastro Duplicado (503 - Service Unavailable)
{
	"message": "Aluno não pode ser criado, RA duplicado.",
	"status": 0
}

- Não Cadastrou - genérico (503 - Service Unavailable)
{
	"message": "Aluno não pode ser criado.",
	"status": 3
}

- Dados Incompletos (400 - Bad Request)
{
	"status": 4
}

2 - Atualizar Aluno (POST)

url: http://localhost:3000/alunos/atualizarAluno.php

*Respostas*

- Atualizado OK (200 OK)
{
	"message": "Aluno atualizado com sucesso.",
    "status": 1
}

- Não Atualizado (503 Service Unavailable)
{
	"message": "Não foi possível atualizar o aluno.",
	"status": 0
}

3 - Excluir Aluno (POST)

url: http://localhost:3000/alunos/excluirAluno.php?

- Removido OK (200 OK)
{
	"message": "Aluno removido.",
	"status": 1
}

- Não Removido (503 Service Unavailable)
{
	"message": "Não foi possível remover o aluno. ",
	"status": 0
}

4 - Visualizar um Aluno (GET)

Passar o valor de RA para pesquisar o aluno 
url: http://localhost:3000/alunos/verificarAluno.php?ra=1003


*Respostas*

- Retorno OK (200 OK)
{
	"id": 80,
	"ra": "1003",
	"nome": "Matheus",
	"turma": "LPW",
	"sala": "43"
}

- Não encontrou Aluno ()
{
	"message": "Aluno não cadastrado.",
	"status": 0
}

OBS:. Lembrar que a url pode ser diferente dependendo da forma como foi hospedada, ex: 
http://barth.com.br/alunos/verificarAluno.php?ra=1003

5 - Listar todos alunos (GET)

url: http://localhost:3000/alunos/verificarAluno.php


*Respostas*

- Array de alunos, Retorno OK (200 OK)
[
  {
    "id": 76,
    "ra": "1002",
    "nome": "Sueli Lopes Antunes",
    "turma": "LPW",
    "sala": "43"
  },
  {
    "id": 77,
    "ra": "1001",
    "nome": "Wagner Barth",
    "turma": "LPW",
    "sala": "43"
  },
  {
    "id": 80,
    "ra": "1003",
    "nome": "Matheus",
    "turma": "LPW",
    "sala": "43"
  }
]

- Não encontrou Aluno ()
{
	"message": "Aluno não cadastrado.",
	"status": 0
}

OBS:. Lembrar que a url pode ser diferente dependendo da forma como foi hospedada, ex: 
http://barth.com.br/alunos/verificarAluno.php