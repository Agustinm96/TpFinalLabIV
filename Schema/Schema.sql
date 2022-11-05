-- Active: 1667602921374@@127.0.0.1@3306@pethero
create database pethero;
use pethero;

create table if not exists UserType(
	id_userType int not null auto_increment primary key,
    typeName varchar(50)
);


create table if not exists User(
	id_user int not null auto_increment primary key,
    firstName varchar(50),
    lastName varchar(50),
    dni varchar(50) not null unique key,
    email varchar(50) not null unique key,
    phoneNumber varchar(50),
    id_userType int not null,
    userName varchar(50) not null unique key,
    pass varchar(75) not null,
    constraint fk_userType
	foreign key(id_userType)
	references UserType(id_userType)
);


create table if not exists Owner(
	id_owner int not null auto_increment primary key,
    address varchar(50),
    id_user int,
    constraint fk_user
	foreign key(id_user)
	references User(id_user)
);

INSERT INTO UserType VALUES(0,'Owner');
INSERT INTO UserType VALUES(0,'Keeper');
INSERT INTO UserType VALUES(0,'Admin');
INSERT INTO User VALUES(0,'Matias','de Andrade','5234213','matute@gmail.com','352356233',1,'matute','12345');
insert into Owner Values(0,'owner street 1',1);

select * from UserType;
select * from User;
select * from Owner;
select o.id_owner,u.id_user,u.userName from User u join Owner o on u.id_user = o.id_user; 
