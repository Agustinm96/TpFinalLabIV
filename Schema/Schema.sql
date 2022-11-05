-- Active: 1667602921374@@127.0.0.1@3306@pethero

create database pethero;
use pethero;

create table
    if not exists UserType(
        id_userType int not null auto_increment primary key,
        typeName varchar(50)
    );

create table
    if not exists User(
        id_user int not null auto_increment primary key,
        firstName varchar(50),
        lastName varchar(50),
        dni varchar(50) not null unique key,
        email varchar(50) not null unique key,
        phoneNumber varchar(50),
        id_userType int not null,
        userName varchar(50) not null unique key,
        pass varchar(75) not null,
        constraint fk_userType foreign key(id_userType) references UserType(id_userType)
    );

create table
    if not exists Owner(
        id_owner int not null auto_increment primary key,
        address varchar(50),
        id_user int,
        constraint fk_user foreign key(id_user) references User(id_user)
    );

CREATE TABLE
    IF NOT EXISTS petType (
        id_PetType int NOT NULL auto_increment PRIMARY KEY,
        petTypeName varchar(50)
    );

CREATE TABLE
    IF NOT EXISTS pet (
        id_Pet int NOT NULL auto_increment primary key,
        id_PetType int,
        namePet varchar(50),
        birthDate date,
        picture varchar(500) default null,
        observation varchar(100),
        videoPet varchar(500) default null,
        id_user int,
        isActive boolean default 1,
        CONSTRAINT fk_petType Foreign Key (id_PetType) REFERENCES petType(id_PetType),
        CONSTRAINT fk_id_user Foreign Key (id_user) REFERENCES User(id_user)
    );

CREATE TABLE
    IF NOT EXISTS dog (
        id_Dog int NOT NULL auto_increment PRIMARY KEY,
        id_Pet int,
        size varchar(50),
        vaccinationPlan varchar(500) default null,
        race varchar(50),
        CONSTRAINT fk_petxdog Foreign Key (id_Pet) REFERENCES pet(id_Pet)
    );

CREATE TABLE
    IF NOT EXISTS cat (
        id_Cat int NOT NULL auto_increment PRIMARY KEY,
        id_Pet int,
        vaccinationPlan varchar(500) default null,
        race varchar(50),
        CONSTRAINT fk_petxcat Foreign Key (id_Pet) REFERENCES pet(id_Pet)
    );

INSERT INTO UserType VALUES(0,'Owner');

INSERT INTO UserType VALUES(0,'Keeper');

INSERT INTO UserType VALUES(0,'Admin');

INSERT INTO User
VALUES (
        0,
        'Matias',
        'de Andrade',
        '5234213',
        'matute@gmail.com',
        '352356233',
        1,
        'matute',
        '12345'
    );

insert into Owner Values(0,'owner street 1',1);

select * from UserType;

select * from User;

select * from Owner;

select
    o.id_owner,
    u.id_user,
    u.userName
from User u
    join Owner o on u.id_user = o.id_user;

INSERT INTO petType (petTypeName) VALUES('Dog');

INSERT INTO petType (petTypeName) VALUES('Cat');

INSERT INTO petType (petTypeName) VALUES('GuineaPig');

SELECT * FROM pet;

SELECT * from pettype;