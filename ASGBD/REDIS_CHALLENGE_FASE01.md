![image](https://github.com/user-attachments/assets/afb39a8a-5a40-4e15-84a8-24d7a2c27227)
# Instalación y Comandos Básicos de Redis

## Parte 1: Instalación de Redis

### Actualizar el sistema y los repositorios
```bash
sudo apt update && sudo apt upgrade -y
```
- ![image](https://github.com/user-attachments/assets/68993e44-2e42-4688-8501-e62ef278e8dc)

### Instalar Redis
```bash
sudo apt install redis-server -y
```
- ![image](https://github.com/user-attachments/assets/7c47e126-ea39-4031-ae72-e4c939bedf51)

### Verificar la instalación

#### Iniciar el servicio de Redis
```bash
sudo systemctl start redis
```

#### Habilitar Redis para que inicie automáticamente al arrancar
```bash
sudo systemctl enable redis
```

#### Comprobar que el servicio está corriendo
```bash
systemctl status redis
```
- ![image](https://github.com/user-attachments/assets/996bc66a-75dc-45c9-aa66-ec74d371a2cd)

### Parar y reiniciar

#### Para detener Redis
```bash
sudo systemctl stop redis
```

#### Para reiniciar Redis
```bash
sudo systemctl restart redis
```

### Probar Redis desde la terminal

#### Acceder al cliente de Redis
```bash
redis-cli
```
- ![image](https://github.com/user-attachments/assets/9b9814bf-d839-4c0b-a302-648f3af8b897)

#### Probar un comando básico
```bash
PING
```
_Debería responder con PONG._
- ![image](https://github.com/user-attachments/assets/e0b77ea8-7af1-45eb-bcf9-d350a7393c65)

#### Especificar una base de datos (por defecto usa la 0)
```bash
redis-cli -n 1
```
![image](https://github.com/user-attachments/assets/03d1afb6-776c-4754-a5c5-4ac9bc7e00d1)

---

## Parte 2: Comandos básicos en Redis

### Comprueba cada uno de los siguientes comandos en tu instalación

#### Comandos básicos para claves

## Claves

- **Establecer y obtener el valor de una clave**
  ```redis
  SET clave valor
  GET clave
  ```
- ![image](https://github.com/user-attachments/assets/e81bc20b-ddc7-4f87-b7aa-ffecf7bf4a32)

- **Eliminar una clave**  
  ```redis
  DEL clave
  ```
- ![image](https://github.com/user-attachments/assets/53886d14-487c-44a4-aa6d-22c0faa8dd71)

- **Verificar si una clave existe**  
  ```redis
  EXISTS clave
  ```
- ![image](https://github.com/user-attachments/assets/b30cd2de-8926-480b-8653-0bc034622a52)

- **Establecer una clave con tiempo de expiración (en segundos)**  
  ```redis
  SETEX clave tiempo valor
  ```
- ![image](https://github.com/user-attachments/assets/a481f615-ddea-4988-903b-bc1931862534)

- **Obtener el tiempo restante de una clave**  
  ```redis
  TTL clave
  ```
- ![image](https://github.com/user-attachments/assets/5de9f62d-ea26-456c-aa45-269d93c65b3e)


- **Renombrar una clave**  
  ```redis
  RENAME clave nueva_clave
  ```
- ![image](https://github.com/user-attachments/assets/04e580e4-bb21-43dc-9cc6-6f1577edfa7f)

## Listas

- **Agregar elementos al principio y al final de una lista**  
  ```redis
  LPUSH mi_lista valor1
  RPUSH mi_lista valor2
  ```
- ![image](https://github.com/user-attachments/assets/c6943760-6d4f-45d6-bd1a-eaa5240b7087)

- **Obtener todos los elementos de una lista**  
  ```redis
  LRANGE mi_lista 0 -1
  ```
- ![image](https://github.com/user-attachments/assets/7a32c242-2fe2-4942-ae07-5a664da7352b)

- **Obtener y eliminar el primer o último elemento de una lista**  
  ```redis
  LPOP mi_lista
  RPOP mi_lista
  ```
- ![image](https://github.com/user-attachments/assets/5ba31e14-1a41-4bb6-a1b0-ff5171eb6495)

- **Longitud de la lista**  
  ```redis
  LLEN mi_lista
  ```
- ![image](https://github.com/user-attachments/assets/8f67c211-08ea-4ec7-8ab1-795b7ad25163)

## Conjuntos (Sets)

- **Agregar elementos a un conjunto**  
  ```redis
  SADD mi_conjunto valor1 valor2
  ```
- ![image](https://github.com/user-attachments/assets/50e7a377-f11c-408b-abbb-e8b7a3ed8a34)

- **Obtener todos los elementos de un conjunto**  
  ```redis
  SMEMBERS mi_conjunto
  ```
- ![image](https://github.com/user-attachments/assets/016918cf-16ae-4361-94db-784bd89e673f)

- **Verificar si un elemento pertenece a un conjunto**  
  ```redis
  SISMEMBER mi_conjunto valor1
  ``` 
- ![image](https://github.com/user-attachments/assets/cbe71105-c06e-4539-9ee0-1df99aa7a4e9)

- **Eliminar un elemento de un conjunto**  
  ```redis
  SREM mi_conjunto valor1
  ```
- ![image](https://github.com/user-attachments/assets/98e63d7d-3b04-4dd7-baee-b31d221add1b)

- **Operaciones entre conjuntos (intersección, unión, diferencia)**  
  ```redis
  SINTER conjunto1 conjunto2
  SUNION conjunto1 conjunto2
  SDIFF conjunto1 conjunto2
  ```
- ![image](https://github.com/user-attachments/assets/6ebc0869-5d61-4b6d-9b77-38186cfc8f86)

## Hashes

- **Agregar un campo a un hash**  
  ```redis
  HSET mi_hash campo1 valor1
  ```
- ![image](https://github.com/user-attachments/assets/1648cd2f-afff-4218-bc80-822733546bf8)

- **Obtener el valor de un campo**  
  ```redis
  HGET mi_hash campo1
  ```
- ![image](https://github.com/user-attachments/assets/f96d5ea8-9992-43df-9d1b-9a6774653328)

- **Obtener todos los campos y valores**  
  ```redis
  HGETALL mi_hash
  ```
- ![image](https://github.com/user-attachments/assets/f855f0b2-27da-40b7-a8ca-0540cc7a303c)

- **Verificar si un campo existe**  
  ```redis
  HEXISTS mi_hash campo1
  ```
- ![image](https://github.com/user-attachments/assets/2ac26478-5406-4903-ba11-b3404358b605)

- **Eliminar un campo**  
  ```redis
  HDEL mi_hash campo1
  ```
- ![image](https://github.com/user-attachments/assets/ab03e719-5f28-450d-b8c5-c1268a9d6041)

## Administración de bases de datos

- **Cambiar de base de datos**  
  ```redis
  SELECT número_base_datos
  ```
- ![image](https://github.com/user-attachments/assets/97e8f0cc-9827-4312-b8e5-1d41264f35e6)

- **Ver claves en la base de datos actual**  
  ```redis
  KEYS *
  ```
- ![image](https://github.com/user-attachments/assets/270c9a5f-d8a2-435b-ac8c-3d92a98634bc)

- **Limpiar todas las claves de la base de datos actual**  
  ```redis
  FLUSHDB
  ```
- ![image](https://github.com/user-attachments/assets/8efd7ea6-c0f9-406b-8343-dd2d5ffb5d9a)

## Información y monitoreo

**Obtener información del servidor**
```redis
INFO  
```
**Ver estadísticas en tiempo real**
```redis
MONITOR  
```
**Ver configuración actual**
```redis
CONFIG GET
``` 

**Cambiar configuración (temporalmente, mientras Redis esté en ejecución)**
```redis
CONFIG SET parametro valor
```

## Copias de seguridad y restauración
### Forzar la creación de un snapshot
```redis
SAVE
```  

### Realizar una copia asincrónica
```redis
BGSAVE
```  
---

# Parte 3: Uso de un cliente visual

## 1. Instalar RedisInsight (cliente visual oficial)
- Descargar la última versión desde la web oficial:  
  [RedisInsight - Página oficial](https://redis.com/redis-enterprise/redis-insight/)  

### Instalar RedisInsight:
```bash
sudo dpkg -i <archivo_descargado>.deb
```  

### Abrir RedisInsight:
```bash
redisinsight
```  

Conectar al servidor Redis (por defecto, host: **127.0.0.1**, puerto: **6379**).  

---

# Parte 4: Otro ejercicio

## 1. Operaciones  
Crear un sistema de gestión de inventario:  

- Añade 5 productos (usando hashes con **HSET**).
```redis
HSET inventario "producto1" 10 "producto2" 15 "producto3" 5 "producto4" 20 "producto5" 8 "producto6" 0
```
- ![image](https://github.com/user-attachments/assets/51ef4e12-1133-428d-a66e-b5180b4050e9)
- ![image](https://github.com/user-attachments/assets/7e4a7cdc-d7b3-4cc2-a76b-d419f28061fa)

- Incrementa el stock de uno de los productos (**HINCRBY**).

```redis
HINCRBY inventario "producto3" 5
```
- ![image](https://github.com/user-attachments/assets/d53a1842-92d6-4aca-9b6f-72208e85344f)
- ![image](https://github.com/user-attachments/assets/25f4b3e3-dd50-4b71-a15b-dbaef1bb14e9)
  
- Elimina un producto cuando el stock llegue a 0.  

```redis
HDEL inventario "producto6" = 0
```
- ![image](https://github.com/user-attachments/assets/86ee8f1b-3f9a-40ec-b738-461cce9cf3f7)
- ![image](https://github.com/user-attachments/assets/120da7bc-27aa-499a-a46f-dc40ee67188c)


## 2. Simular un carrito de compras  
Crear un carrito con la estructura de listas:  
```redis
LPUSH carrito "Producto1" "Producto2"  
LRANGE carrito 0 -1  
```
- ![image](https://github.com/user-attachments/assets/3e7a4d2f-3646-4436-9c39-132d8d21e54a)
- ![image](https://github.com/user-attachments/assets/468fb30c-8122-44ea-8641-7cc17c033fdd)

## 3. Ranking de usuarios  
Usar un conjunto ordenado para guardar puntuaciones:  
```redis
ZADD ranking 100 "usuario1" 200 "usuario2" 150 "usuario3"  
ZRANGE ranking 0 -1 WITHSCORES  
ZREVRANK ranking "usuario2"  
```
- ![image](https://github.com/user-attachments/assets/e99b972c-8818-4518-83b8-23f2f44e9be1)
- ![image](https://github.com/user-attachments/assets/c805e85a-1a20-4b3f-acff-d50d534178b7)

## 4. Simulación de notificaciones  
Usar listas para simular una cola de notificaciones:  
```redis
LPUSH notificaciones "Notificación 1" "Notificación 2"  
RPOP notificaciones  
```
- ![image](https://github.com/user-attachments/assets/c3722bd2-b126-4c4b-a622-9f2706df0ffb)
- ![image](https://github.com/user-attachments/assets/d2dc4b7b-c5b4-4ec6-9710-dd4b6ff0f4a7)
---

# Parte 5: Otro Ejercicio Más  

## Diseña un sistema de control de tareas con Redis. Debe permitir:  

1. Añadir tareas con nombre y prioridad.

```redis
ZADD tareas 1 "Tarea: Pagar facturas"  
ZADD tareas 2 "Tarea: Terminar informe"  
ZADD tareas 3 "Tarea: Hacer ejercicio"  
ZADD tareas 4 "Tarea: Leer 30 min"  
ZADD tareas 5 "Tarea: Comprar víveres"
```
- ![image](https://github.com/user-attachments/assets/a305eafd-9e46-4a36-ae2c-96d4ab936aa1)
- ![image](https://github.com/user-attachments/assets/213fdc07-1b59-48e4-bfba-9f2e8c8c7eaf)


2. Consultar todas las tareas en orden de prioridad.

- ![image](https://github.com/user-attachments/assets/6f7957ba-b543-44ba-b734-c88d7f5daa3c)

3. Marcar tareas como completadas (eliminarlas de la lista).

- ![image](https://github.com/user-attachments/assets/a31df4b0-4550-4c22-af01-37dde1f4d643)
- ![image](https://github.com/user-attachments/assets/eb1b8ff0-2f58-4791-9633-49ef11fbc49f)

### 📝 Pistas  
Usa listas (**LPUSH** y **LPOP**) o conjuntos ordenados (**ZADD** y **ZRANGE**).


---

## Explorar Redis desde RedisInsight
Crear claves, insertar datos en listas o hashes, y observar las estructuras visualmente.
