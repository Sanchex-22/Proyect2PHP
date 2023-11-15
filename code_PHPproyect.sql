    CREATE DATABASE IF NOT EXISTS checktask;
    use checktask;

    create table IF NOT EXISTS Tareas(

    cod INT not null AUTO_INCREMENT,
    Titulo CHAR(20) not null,
    Descripcion VARCHAR (100) not null,
    Estado CHAR (11) not null,
    Tipo_ CHAR (12) NOT NULL,
    Fecha_Compromiso DATETIME not null,
    Responsable CHAR (15) not null,
    Etiqueta char(9),
    primary key (cod)
    );

    create table IF NOT EXISTS Usuarios(
    cod_user INT NOT NULL AUTO_INCREMENT,
    User_Name VARCHAR (15) NOT NULL,
    primary key (cod_user, User_Name)
    );


    insert into Usuarios (User_Name, password) values ("carlos");
    insert into Usuarios (User_Name, password) values ("jose123");