CREATE TABLE tasks (
	id BIGINT UNIQUE AUTO_INCREMENT NOT NULL,
	titulo VARCHAR(255) NOT NULL,
   descricao VARCHAR(255) NULL,
   dataCriacao DATETIME NOT NULL,
   dataAtualizacao DATETIME NOT NULL,
   concluido BOOLEAN default FALSE,
	CONSTRAINT PK_Task PRIMARY KEY (id)
)


-- versão postgresql
CREATE TABLE tasks (
	id serial NOT NULL,
	titulo VARCHAR(255) NOT NULL,
   descricao VARCHAR(255) NULL,
   dataCriacao timestamp  NOT NULL,
   dataAtualizacao timestamp  NOT NULL,
   concluido BOOLEAN default FALSE,
	CONSTRAINT PK_Task PRIMARY KEY (id)
)

INSERT INTO tasks (titulo,descricao,dataCriacao,dataAtualizacao)
VALUES ('minha tarefa',NULL,'2021-07-01 17:48:00','2021-07-01 17:48:00')

SELECT * FROM tasks
