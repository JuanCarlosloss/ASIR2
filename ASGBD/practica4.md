## PostgreSQL: Gestión de Información de Equitación en la la DB EquitacionSuave 
### Finalidad: 
### Se va a trabajar con comandos SQL para instalar PostgreSQL, crear tablas, gestionar usuarios, insertar y modificar datos, y a utilizar pgAdmin para la administración visual. 
## 1. Instalación de PostgreSQL en Linux 
  ### 1. Actualiza los repositorios del sistema e instala PostgreSQL.
  ```bash
  sudo apt update
  sudo apt install postgresql postgresql-contrib
  ```
  ### 2. Inicia el servicio de PostgreSQL y configura el servicio para que se inicie automáticamente cada vez que se arranque el sistema. 
  ```bash
  sudo systemctl start postgresql
  sudo systemctl enable postgresql
  ```
  ### 3. Cambia al usuario postgres y abre la consola de PostgreSQL. 
  ```bash
  sudo -i -u postgres
  psql
  ```
## 2. Creación de la Base de Datos y Tablas 
### Paso 1: Crear la base de datos 
### 1. Conéctate a la consola de PostgreSQL como el usuario postgres. 
  ```bash
  sudo -i -u postgres
  psql
  ```
### 2. Crea una base de datos llamada EquitacionSuave y conectate a ella. 
```sql
CREATE DATABASE EquitacionSuave;
\c equitacionsuave;
```
## Paso 2: Crear las tablas principales 
### 1. Crea una tabla llamada jinetes que incluya los siguientes campos: id: un identificador único autoincrementado para cada jinete. nombre: el nombre del jinete. apellido: el apellido del jinete. categoria: una cadena que representa el nivel de habilidad (e.g., Avanzado, Intermedio, Principiante). experiencia_años: un número entero que indica los años de experiencia. 
```sql
CREATE TABLE jinetes (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    categoria VARCHAR(20),
    experiencia_años INT
);
```
- ![image](https://github.com/user-attachments/assets/dc231026-48ec-4358-a740-191947dd8705)

### 2. Crea una tabla llamada caballos que incluya los siguientes campos: id: un identificador único autoincrementado para cada caballo. nombre: el nombre del caballo. raza: la raza del caballo. edad: un número entero que representa la edad del caballo. o jinete_id: una referencia al id de la tabla jinetes, para indicar quién es el jinete actual del caballo. 
```sql
CREATE TABLE caballos (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50),
    raza VARCHAR(50),
    edad INT,
    jinete_id INT REFERENCES jinetes(id)
);
```
- ![image](https://github.com/user-attachments/assets/dc0d1bf7-7bd5-4cf6-8443-646c1b222039)
## 3. Gestión de Usuarios y Roles 
### Ejercicio 1: Crear usuarios con distintos niveles de permisos 
### 1. Crea un usuario admin_equitacion con permisos para iniciar sesión en PostgreSQL y con la capacidad de crear bases de datos. 
```sql
CREATE USER admin_equitacion WITH LOGIN CREATEDB PASSWORD '232425';
```
- ![image](https://github.com/user-attachments/assets/01cf14b8-e274-4017-a138-58b4497856e5)

### 2. Crea un usuario user_consultas que solo pueda realizar consultas en la base de datos.
```sql
CREATE USER user_consultas WITH LOGIN PASSWORD '232425';
```
- ![image](https://github.com/user-attachments/assets/d80b4b4e-4a6b-436e-9215-9502610a5770)
### 3. Crea un usuario user_lectura que pueda ver datos en la base de datos pero no modificarlos. 
```sql
CREATE USER user_lectura WITH LOGIN PASSWORD '232425';
```
- ![image](https://github.com/user-attachments/assets/f25604e7-bb41-4135-9a69-1a761001e297)
### Ejercicio 2: Asignar permisos 
### 1. Conéctate a la base de datos EquitacionSuave. 
### 2. Asigna permisos de consulta (SELECT) a user_consultas en las tablas jinetes y  caballos. 
```sql
GRANT SELECT ON jinetes, caballos TO user_consultas;
```
- ![image](https://github.com/user-attachments/assets/0d5860cc-5831-4757-9d20-1435ee5c0a70)
### 3. Configura permisos para user_lectura para que solo pueda ver datos y no modificarlos en ambas tablas. 
```
GRANT SELECT ON jinetes, caballos TO user_lectura;
```
- ![image](https://github.com/user-attachments/assets/cbb2682a-2a29-4e82-9252-6d61c603dc29)

### 4. Da permisos completos (SELECT, INSERT, UPDATE, DELETE) al usuario  admin_equitacion en las tablas jinetes y caballos. 
```sql
GRANT ALL PRIVILEGES ON jinetes, caballos TO admin_equitacion;
```
- ![image](https://github.com/user-attachments/assets/74da6f28-dd30-4e73-a697-4c5da65d4855)
## 4. Inserción de Datos en las Tablas 
### 1. Inserta varios registros en la tabla jinetes con diferentes valores de nombres, apellidos, categorías y años de experiencia. 
```sql
INSERT INTO jinetes (nombre, apellido, categoria, experiencia_años)
VALUES ('Juan', 'Pérez', 'Avanzado', 5),
       ('María', 'López', 'Intermedio', 3);
```
- ![image](https://github.com/user-attachments/assets/3c927374-822e-4039-b6ae-4bdd988a878b)
### 2. Inserta varios registros en la tabla caballos, especificando el nombre, raza, edad, y el jinete_id correspondiente. 
```sql
INSERT INTO caballos (nombre, raza, edad, jinete_id)
VALUES ('Relámpago', 'Pura Sangre', 7, 1),
       ('Tormenta', 'Árabe', 5, 2);
```
-![image](https://github.com/user-attachments/assets/5f44d96d-4160-420d-b937-ff70974e73ed)
## 5. Consultas de Datos 
### 1. Realiza una consulta para obtener todos los registros de la tabla jinetes. 
```sql
SELECT * FROM jinetes;
```
- ![image](https://github.com/user-attachments/assets/996ec771-4da3-469f-902d-880498309aa8)

### 2. Realiza una consulta que muestre solo los jinetes con más de dos años de experiencia. 
```sql
SELECT * FROM jinetes WHERE experiencia_años > 2;
```
- ![image](https://github.com/user-attachments/assets/7cb00a13-c71f-4816-8811-c3ede20d47f8)

### 3. Realiza una consulta para obtener los nombres de los caballos junto con los nombres de sus respectivos jinetes. 
```sql
SELECT caballos.nombre AS caballo, jinetes.nombre AS jinete
FROM caballos
JOIN jinetes ON caballos.jinete_id = jinetes.id;
```
- ![image](https://github.com/user-attachments/assets/0b6b2e89-9b6d-42e5-9f94-98c5996407b5)
## 6. Actualización y Eliminación de Datos 
### 1. Realiza una actualización en la tabla jinetes para cambiar la categoría de un jinete. 
```sql
UPDATE jinetes SET categoria = 'Avanzado' WHERE nombre = 'María';
```
- ![image](https://github.com/user-attachments/assets/57c59521-feb7-496a-9247-8468e544fa38)
### 2. Realiza una eliminación en la tabla jinetes para borrar un registro específico. 

## 7. Uso de pgAdmin para Administración Visual 
### Paso 1: Acceso a pgAdmin y conexión al servidor PostgreSQL 
### 1. Abre pgAdmin y conéctate al servidor PostgreSQL usando las credenciales de postgres. 
### 2. Verifica la conexión y accede a la lista de bases de datos. 
### Paso 2: Crear la base de datos EquitacionSuave 
### 1. En pgAdmin, crea la base de datos EquitacionSuave con postgres como propietario. 
### Paso 3: Crear las tablas jinetes y caballos 
### 1. En la sección Schemas > public > Tables de pgAdmin, crea la tabla jinetes con los campos mencionados en el paso 2. 
### 2. Crea también la tabla caballos con los campos requeridos y la referencia a la tabla jinetes. 
### Paso 4: Insertar y consultar datos 
### 1. Utiliza la herramienta de consulta (Query Tool) de pgAdmin para insertar y consultar datos en ambas tablas. 
### Paso 5: Crear y administrar usuarios y roles en pgAdmin 
### 1. En Login/Group Roles de pgAdmin, crea los usuarios admin_equitacion, user_consultas y user_lectura. 
### 2. Asigna los permisos correspondientes a cada usuario en las tablas jinetes y caballos usando la interfaz gráfica de pgAdmin. 
### 8. Características Avanzadas de PostgreSQL 
### Ejercicio 1: Uso de JSON en la tabla jinetes 
### 1. Añade una columna llamada detalles_competencias de tipo JSON en la tabla jinetes. 
### 2. Inserta un nuevo registro en la tabla jinetes y jinetes y utiliza la columna detalles_competencias para almacenar datos en formato JSON que incluyan las competencias y el número de victorias del jinete. 
### Ejercicio 2: Uso de arreglos (ARRAYS) para certificaciones 
### 1. Añade una columna certificaciones de tipo ARRAY en la tabla jinetes. 
### 2. Actualiza uno de los registros en jinetes para almacenar múltiples certificaciones en la columna certificaciones. 
## Ejercicio 3: Creación de Vistas Materializadas 
### 1. Crea una vista materializada llamada vista_jinetes_avanzados que contenga los registros de jinetes cuya categoría sea Avanzado. 
### 2. Realiza una operación para actualizar los datos de la vista materializada. 
## Ejercicio 4: Herencia en Tablas para gestionar equipos de equitación 
### 1. Crea una tabla base llamada equipo_base con los campos id, nombre y tipo. 
### 2. Crea una tabla heredada llamada equipo_de_salto que extienda equipo_base y añada un campo altura_maxima para especificar la altura máxima permitida del equipo. 
### 3. Inserta un registro en la tabla equipo_de_salto. 

