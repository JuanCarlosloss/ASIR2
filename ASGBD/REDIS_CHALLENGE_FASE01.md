
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

#### Probar un comando básico
```bash
PING
```
_Debería responder con PONG._

#### Especificar una base de datos (por defecto usa la 0)
```bash
redis-cli -n 1
```

## Parte 2: Comandos básicos en Redis

### Comprueba cada uno de los siguientes comandos en tu instalación

#### Comandos básicos para claves

- Establecer y obtener el valor de una clave
  ```bash
  SET clave valor
  GET clave
  ```

## Claves

- **Eliminar una clave**  
  ```redis
  DEL clave
  ```

- **Verificar si una clave existe**  
  ```redis
  EXISTS clave
  ```

- **Establecer una clave con tiempo de expiración (en segundos)**  
  ```redis
  SETEX clave tiempo valor
  ```

- **Obtener el tiempo restante de una clave**  
  ```redis
  TTL clave
  ```

- **Renombrar una clave**  
  ```redis
  RENAME clave nueva_clave
  ```

## Listas

- **Agregar elementos al principio y al final de una lista**  
  ```redis
  LPUSH mi_lista valor1
  RPUSH mi_lista valor2
  ```

- **Obtener todos los elementos de una lista**  
  ```redis
  LRANGE mi_lista 0 -1
  ```

- **Obtener y eliminar el primer o último elemento de una lista**  
  ```redis
  LPOP mi_lista
  RPOP mi_lista
  ```

- **Longitud de la lista**  
  ```redis
  LLEN mi_lista
  ```

## Conjuntos (Sets)

- **Agregar elementos a un conjunto**  
  ```redis
  SADD mi_conjunto valor1 valor2
  ```

- **Obtener todos los elementos de un conjunto**  
  ```redis
  SMEMBERS mi_conjunto
  ```

- **Verificar si un elemento pertenece a un conjunto**  
  ```redis
  SISMEMBER mi_conjunto valor1

- **Eliminar un elemento de un conjunto**  
  ```redis
  SREM mi_conjunto valor1
  ```

- **Operaciones entre conjuntos (intersección, unión, diferencia)**  
  ```redis
  SINTER conjunto1 conjunto2
  SUNION conjunto1 conjunto2
  SDIFF conjunto1 conjunto2
  ```

## Hashes

- **Agregar un campo a un hash**  
  ```redis
  HSET mi_hash campo1 valor1
  ```

- **Obtener el valor de un campo**  
  ```redis
  HGET mi_hash campo1
  ```

- **Obtener todos los campos y valores**  
  ```redis
  HGETALL mi_hash
  ```

- **Verificar si un campo existe**  
  ```redis
  HEXISTS mi_hash campo1
  ```

- **Eliminar un campo**  
  ```redis
  HDEL mi_hash campo1
  ```

## Administración de bases de datos

- **Cambiar de base de datos**  
  ```redis
  SELECT número_base_datos
  ```

- **Ver claves en la base de datos actual**  
  ```redis
  KEYS *
  ```

- **Limpiar todas las claves de la base de datos actual**  
  ```redis
  FLUSHDB
  ```

- **Limpiar todas las claves de todas las bases de datos**  
  ```redis
  FLUSHALL
  ```


## Información y monitoreo
