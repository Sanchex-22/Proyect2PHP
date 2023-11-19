# Proyect1PHP


# Instrucciones para Configurar la Base de Datos

Para que la aplicación funcione correctamente, necesitas configurar una base de datos MySQL y crear las tablas necesarias. Sigue los siguientes pasos:

1. **El archivo db_connection contiene:**
    ```
        dbconncetion
        define('DB_HOST','localhost');
        define('DB_USER','root');
        define('DB_PASS','{TU CONTRASEÑA}');
        define('DB_NAME','checktask');
    ```

2. **Crear la Base de Datos:**

   ```sql
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

   ```

3. **ENDPOINTS**
    ## API Endpoints
    <div>

    | Methods |             Urls           |                Actions 
    |-------------|:--------------------------:|-----------------------------------:|
    |http://localhost/Proyect2_DVII/                                                |
    User ROUTES
    | **POST**    | /api/createUser.php        | login an  user and create
    {"User_Name":"carlo2"}
    |
    Task ROUTES
    | **POST**    | /api/create.php            | new task
    {"Titulo":"xd","Descripcion":"xd2","Estado":"estado", "Fecha_Compromiso":"2023-12-01","Responsable":"responsable","tipo_":"tipo","Etiqueta" :"(Editado)"}
    | **PUT**     | /api/edit.php              | edit task
    {"cod":"3","Titulo":"Titulo Editado","Descripcion":"Mi primera chamba","Estado":"estado","Fecha_Compromiso":"2023-12-01","Responsable":"Eladio","tipo_":"tipo","Etiqueta" :"(Editado)"}
    | **DELETE**  | /api/delete.php            | delete task
    {"cod":"2"}
    | **GETALL**     | /api/getAll.php         | get All task
    |
    | **GETONE**     | /api/getOne.php         | get One Task
    |


    </div>
