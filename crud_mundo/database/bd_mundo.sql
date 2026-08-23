create database if not exists bd_mundo character set utf8mb4 collate utf8mb4_general_ci;
use bd_mundo;

create table continentes (
    id int auto_increment primary key,
    nome varchar(50) not null,
    populacao bigint not null default 0,
    area decimal(15,2) not null default 0,
    total_paises int not null default 0
);

create table governantes (
    id  int auto_increment primary key,
    nome varchar(100) not null,
    partido_politico varchar(100),
    data_nascimento date,
    idade int,
    data_inicio_mandato date,
    data_fim_mandato date null
);

create table paises (
    id int auto_increment primary key,
    nome varchar(100) not null,
    continente_id int not null,
    populacao bigint not null default 0,
    area decimal(15,2) not null default 0,
    idioma varchar(100),
    governante_id int null,
    clima varchar(100),
    regime_politico varchar(100),
    moeda varchar(50),
    constraint fk_pais_continente foreign key (continente_id) references continentes(id) on delete restrict,
    constraint fk_pais_governante foreign key (governante_id) references governantes(id) on delete set null
);

create table cidades (
    id int auto_increment primary key,
    nome varchar(100) not null,
    pais_id int not null,
    populacao bigint not null default 0,
    area decimal(15,2) not null default 0,
    clima varchar(100),
    governante_id int null,
    data_fundacao date,
    constraint fk_cidade_pais foreign key (pais_id) references paises(id) on delete restrict,
    constraint fk_cidade_governante foreign key (governante_id) references governantes(id) on delete set null
);

insert into continentes
(nome, populacao, area, total_paises)
values
('América', 1050000000, 42549000.00, 35),
('Europa', 750000000, 10180000.00, 44);

insert into governantes
(nome, partido_politico, data_nascimento, idade, data_inicio_mandato, data_fim_mandato)
values
('Carlos Henrique Monteiro', 'Partido da União Mundial', '1975-04-12', 51, '2024-01-01', NULL),
('Eduardo Gabriel Almeida', 'Partido do Desenvolvimento Nacional', '1982-09-25', 43, '2023-03-15', NULL);

insert into paises
(nome, continente_id, populacao, area, idioma, governante_id, clima, regime_politico, moeda)
values
('Brasil', 1, 216000000, 8515767.05, 'Português', 1, 'Tropical', 'República Federativa', 'Real'),
('Argentina', 1, 46000000, 2780400.00, 'Espanhol', 2, 'Temperado', 'República Federal', 'Peso Argentino'),
('Alemanha', 2, 84000000, 357022.00, 'Alemão', 1, 'Temperado', 'República Parlamentar', 'Euro'),
('França', 2, 68000000, 551695.00, 'Francês', 2, 'Temperado Oceânico', 'República Semipresidencialista', 'Euro');

insert into cidades
(nome, pais_id, populacao, area, clima, governante_id, data_fundacao)
values
('São Paulo', 1, 12300000, 1521.11, 'Tropical de Altitude', 1, '1554-01-25'),
('Buenos Aires', 2, 3100000, 203.00, 'Temperado', 2, '1580-06-11'),
('Berlim', 3, 3700000, 891.68, 'Temperado', 1, '1237-01-01'),
('Paris', 4, 2100000, 105.40, 'Temperado Oceânico', 2, '0750-01-01');

