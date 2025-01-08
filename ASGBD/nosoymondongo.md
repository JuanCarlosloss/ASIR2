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
![image](https://github.com/user-attachments/assets/5ed3df3d-d30d-44ae-8f20-960e7bc649dc)

2. Tabla orders:
```sql
order_id: (PRIMARY KEY)
user_id: (FOREIGN KEY)
total: (REAL)
```
![image](https://github.com/user-attachments/assets/1ec4e4e1-e185-4e2d-a1df-72401d41fea6)

3. Tabla products:
```sql
product_id: (PRIMARY KEY)
name: (TEXT)
price: (REAL)
```
- ![image](https://github.com/user-attachments/assets/eac7b8dd-0e7e-4f87-844b-318c4ddece20)

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

### Consulta 0: Lista todas las colecciones
- ![image](https://github.com/user-attachments/assets/e4e5f790-2dcf-4d89-a470-6688ac8c7f57)
### Consulta 1: Listar todos los usuarios
- ![image](https://github.com/user-attachments/assets/3c017657-0b6e-4469-bba6-653cee086789)
### Consulta 2: Buscar pedidos de un usuario cuyo id sea 1
- ![image](https://github.com/user-attachments/assets/0a58923f-28d0-4c02-bc7f-1d27b5368532)
### Consulta 3: Listar productos con precio mayor a 30
- ![image](https://github.com/user-attachments/assets/de8d3251-3787-403c-b9a2-52ecdd095525)
### Consulta 4: Buscar pedidos que contengan un producto con id = 2
- ![image](https://github.com/user-attachments/assets/4ed4cf69-2b6c-4577-8ca4-1cddd430b226)
### Consulta 5: Obtener usuarios que hayan realizado pedidos con un total mayor a 40
- ![image](https://github.com/user-attachments/assets/3e049f50-37a4-479f-9e8b-6cfd10a2e86c)
### Consulta 6: Mostrar solo los nombres y correos de los usuarios
- ![image](https://github.com/user-attachments/assets/d77a4c5a-d7d4-49d7-8687-2baf0ee4aed6)
### Consulta 7: Contar cuántos productos tienen un precio menor o igual a 50
- ![image](https://github.com/user-attachments/assets/7a70b8c8-3e0d-4f2f-a00d-cd44a92cc698)
### Consulta 8: Encontrar usuarios que hayan pedido un producto llamado "Mouse"
- ![image](https://github.com/user-attachments/assets/556e42ae-a698-41af-95ae-463fbe88c3c2)
### Consulta 9: Agrupar los pedidos por usuario y calcular el total gastado por cada uno
- ![image](https://github.com/user-attachments/assets/2962073f-b560-4cbf-a514-7e78228c3d6a)
### Consulta 10: Listar productos únicos comprados en todos los pedidos
- ![image](https://github.com/user-attachments/assets/e25680da-c6b1-440b-875f-c20bcf1b2274)
