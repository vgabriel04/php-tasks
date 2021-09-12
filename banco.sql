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

CREATE TABLE situacao (
   id serial NOT NULL,
   situacao varchar(255),
   ordem bigint,
	CONSTRAINT PK_situacao PRIMARY KEY (id)
);

alter table tasks add column texto text;
alter table tasks add column situacao bigint;
alter table tasks add CONSTRAINT FK_task_situacao FOREIGN key (situacao) references situacao(id);
alter table situacao add column ordem bigint;

-- alterando tipo do campo descricao usando campo auxiliar text
update tasks set texto = descricao where 1 = 1;
alter table tasks drop column descricao;
alter table tasks add column descricao text;
update tasks set descricao = texto where 1 = 1;
alter table tasks drop column texto;





1-tarefa ter situação :
2-descricao ser um textarea :
3- fazer estilo kanban :
4- fazer um noticebox ao inves de alert :