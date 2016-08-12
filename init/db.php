<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/classes/BancoDeDados.php');

$data = "
insert into user(email,nome,senha) values('prima@primeiro.com','prima','123');
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
";

$data = htmlspecialchars($data);
echo "$data";
$bd = new BancoDeDados();

$data = explode(';',$data);
for ($i=0; $i < sizeof($data); $i++) {
	$bd->insertText($data[$i]);
}
?>
