<?php
// Arquivo usado para inicializar o banco pois quando iserio caracteres especiais
// pelo mysql diretamente são causados problemas para e recuperação dos dados.
require_once('../classes/Connect.php');
$db = "
	drop database TaskEnem2;
	create database TaskEnem2;
	use TaskEnem2;

	create table User(
		id int auto_increment null,
	    email varchar(80) not null,
	    senha varchar(64) not null,
		nome varchar(30) not null,
	    primary key(id)
	);

	create table Disciplina(
		id int auto_increment not null,
		nome varchar(30) not null,
	    primary key(id)
	);

	create table Tarefa(
		id int auto_increment null,
	    dono int not null,
		nome varchar(30) not null,
	    disciplina int not null,
	    horario bigint not null,
	    anotacao varchar(255),
	    primary key(id),
	    foreign key(disciplina) references Disciplina(id),
	    foreign key(dono) references user(id)
)";
$data = "

	insert into user(email,nome,senha) values('p@p.com','prima','123');
	insert into Disciplina(nome) values('Artes');
	insert into Disciplina(nome) values('Biologia');
	insert into Disciplina(nome) values('Ed. Física');
	insert into Disciplina(nome) values('Espanhol');
	insert into Disciplina(nome) values('Filosofia');
	insert into Disciplina(nome) values('Física');
	insert into Disciplina(nome) values('Geografia');
	insert into Disciplina(nome) values('História');
	insert into Disciplina(nome) values('Inglês');
	insert into Disciplina(nome) values('Literatura');
	insert into Disciplina(nome) values('Matemática');
	insert into Disciplina(nome) values('Química');
	insert into Disciplina(nome) values('Sociologia');
".
	// insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','MUV','6','2016-08-10 09:32:19','Lorem ipsum dolor sit amet, consectetur.');
	// insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','embriologia','2','2016-08-10 09:32:20','Lorem ipsum dolor sit amet, consectetur.');
	// insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','cerebro','2','2016-08-10 09:32:21','Lorem ipsum dolor sit amet, consectetur.');
	// insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','sistema nervoso','2','2016-08-10 09:32:22','Lorem ipsum dolor sit amet, consectetur.');
	// insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','glicídios','2','2016-08-10 09:32:24','Lorem ipsum dolor sit amet, consectetur.');
	// insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','soy','4','2016-08-10 09:32:30','Lorem ipsum dolor sit amet, consectetur.');
	// insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','dialetica','5','2016-08-10 09:32:34','Lorem ipsum dolor sit amet, consectetur.');
	// insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','Roma','8','2016-08-10 09:32:36','Lorem ipsum dolor sit amet, consectetur.');
	// insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','Martin','10','2016-08-10 09:32:39','Lorem ipsum dolor sit amet, consectetur.');
	// insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','cinética','12','2016-08-10 09:32:50','Lorem ipsum dolor sit amet, consectetur.');
	// insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','Fato Social','13','2016-08-10 09:32:58','Lorem ipsum dolor sit amet, consectetur.');
"	insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','MUV','6','1470821539000','Lorem ipsum dolor sit amet, consectetur.');
	insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','embriologia','2','1470821540000','Lorem ipsum dolor sit amet, consectetur.');
	insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','cerebro','2','1470821540001','Lorem ipsum dolor sit amet, consectetur.');
	insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','sistema nervoso','2','1470821540002','Lorem ipsum dolor sit amet, consectetur.');
	insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','glicídios','2','1470821540003','Lorem ipsum dolor sit amet, consectetur.');
	insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','soy','4','1470821540004','Lorem ipsum dolor sit amet, consectetur.');
	insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','dialetica','5','1470821540005','Lorem ipsum dolor sit amet, consectetur.');
	insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','Roma','8','14708215400006','Lorem ipsum dolor sit amet, consectetur.');
	insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','Martin','10','1470821540007','Lorem ipsum dolor sit amet, consectetur.');
	insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','cinética','12','1470821540008','Lorem ipsum dolor sit amet, consectetur.');
	insert into Tarefa(dono,nome,disciplina,horario,anotacao) values('1','Fato Social','13','1470821540009','Lorem ipsum dolor sit amet, consectetur.');
";

$bets = "
SELECT
	d.nome as nome,
	d.id as id,
    t.nome as tnome,
    t.id as tid,
    t.horario as hora,
    t.anotacao as content

    FROM disciplina d, tarefa t

    WHERE d.id = t.disciplina
	order by nome asc, hora desc";

// Converte os caracteres especiais para caracteres que podem ser recuperados
$db	  = htmlspecialchars($db);
$data = htmlspecialchars($data);

echo "$data";
$bd = new Connect();

$db = explode(';',$db);
for ($i=0; $i < sizeof($db); $i++) {
	$bd->query($db[$i]);
}

$data = explode(';',$data);
for ($i=0; $i < sizeof($data); $i++) {
	$bd->query($data[$i]);
}
?>
