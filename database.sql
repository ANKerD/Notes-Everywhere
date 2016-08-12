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

insert into user(email,nome,senha) values('prima@primeiro.com','prima','123');

create table Disciplina(
	id int auto_increment not null,
	nome varchar(30) not null,
    primary key(id)
);


create table Tarefa(
	id int not null,
	nome varchar(30) not null,
    disciplina int not null,
    horario datetime not null,
    anotação varchar(255),
    primary key(id),
    foreign key(disciplina) references Disciplina(id)
);