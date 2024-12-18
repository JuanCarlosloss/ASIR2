## 0) Esquema de la Base de Datos Relacional de mandarinas
- Mandarinas:
```sql
id_mandarina: (INTEGER, PK, AUTOINCREMENT): Identificador único para cada mandarina.
color: (TEXT, NOT NULL): Color de la mandarina.
tipo: (TEXT, NOT NULL): Tipo de mandarina.
size: (TEXT, NOT NULL): Tamaño de la mandarina.
fecha_recogida: (DATE, NOT NULL): Fecha en la que se recogió la mandarina.
```
![image](https://github.com/user-attachments/assets/51ef4e67-e4b2-4489-bdea-3893deddb6ac)

- Melocotones:
```sql
id_melocoton: (INTEGER, PK, AUTOINCREMENT): Identificador único para cada melocotón.
tipo: (TEXT, NOT NULL): Tipo de melocotón.
rayada: (BOOLEAN, NOT NULL): Indica si el melocotón es suave (1) o no (0).
```
![image](https://github.com/user-attachments/assets/16ed9522-3ac8-4c58-b6e6-8179eefa8901)

- Caquis:
```sql
id_caqui: (INTEGER, PK, AUTOINCREMENT): Identificador único para cada caqui.
id_mandarina: (INTEGER, FK, NOT NULL): Relacionado con id_mandarina en la tabla mandarinas.
id_melocoton: (INTEGER, FK, NOT NULL): Relacionado con id_melocoton en la tabla melocotones.
color: (TEXT, NOT NULL): Color del caqui.
pequeño: (BOOLEAN, NOT NULL): Indica si el caqui tiene pequeño (1) o no (0).
tiempo_maduración: (INTEGER, NOT NULL): Tiempo de maduración en días.
```
-![image](https://github.com/user-attachments/assets/e9a2e3bc-ebd3-4b0b-b702-869929591251)

## 1) Esquema de la Base de Datos Relacional de un comercio
### La base de datos relacional consta de las siguientes tablas:

1. Tabla users:
```sql
user_id: (PRIMARY KEY)
name: (TEXT)
email: (TEXT)
```
![image](https://github.com/user-attachments/assets/7f031936-40c2-4b0c-8a69-972631e6a5d0)
2. Tabla orders:
```sql
order_id: (PRIMARY KEY)
user_id: (FOREIGN KEY)
total: (REAL)
```
3. Tabla products:
```sql
product_id: (PRIMARY KEY)
name: (TEXT)
price: (REAL)
```
4. Tabla intermedia order_products:
```sql
order_id: (FOREIGN KEY)
product_id: (FOREIGN KEY)
```
## 2) Creación de la Base de Datos e Inserción de Datos
A. Utilizando la Terminal de mongo:
Crea una base de datos llamada mi_comercio
Crea las colecciones anteriores
Inserta los documentos anteriores en las colecciones correspondientes
Realiza las siguientes consultas:

- Consulta 0: Lista todas las colecciones
- Consulta 1: Listar todos los usuarios
- Consulta 2: Buscar pedidos de un usuario cuyo id sea 1
- Consulta 3: Listar productos con precio mayor a 30
- Consulta 4: Buscar pedidos que contengan un producto con id = 2
- Consulta 5: Obtener usuarios que hayan realizado pedidos con un total mayor a 40
- Consulta 6: Mostrar solo los nombres y correos de los usuarios
- Consulta 7: Contar cuántos productos tienen un precio menor o igual a 50
- Consulta 8: Encontrar usuarios que hayan pedido un producto llamado "Mouse"
- Consulta 9: Agrupar los pedidos por usuario y calcular el total gastado por cada uno
- Consulta 10: Listar productos únicos comprados en todos los pedidos
