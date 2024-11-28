#Simulación de ataques en Kali Purple
## 1.- Creación de diccionarios con PYDICTOR Y DYMERGE
### Vamos a trabajar con la herramienta Pydictor, que permite la creación de diccionarios para fuerza bruta. Sus principales características son las siguientes:
#### Pydictor se utiliza para crear diccionarios para fuerza bruta.
####  Esta herramienta crea la lista de palabras tanto en palabras normales como en diferentes tipos de cifrado, como el cifrado base64.
####  Pydictor está escrito en Python.
### Hay dos métodos para romper la contraseña usando esta herramienta:
- crear una lista de palabras normales.
- crear la lista de palabras en formato base64.
### Instala las herramientas Pydictor y Dymerge y crea dos diccionarios de palabras con Pydictor: uno con números y otro con una lista de palabras con letras en mayúsculas. 

## Instalacion Pydictor
- Hay que usar el siguiente comando para descargar el pydictor en su repositorio oficial de github
```bash
git clone --depth=1 --branch=master https://github.com/landgrey/pydictor
```
- ![image](https://github.com/user-attachments/assets/a806d7bf-485d-4d6f-9a50-ad284fa8f1ba)
- ![image](https://github.com/user-attachments/assets/0d115b9f-01d0-479e-9162-2558ee7aef5c)

## Instalacion dymerge
- Igual que con Pydictor descargaremos con el comando git clone el repositorio de dymerge
```bash
git clone https://github.com/k4m4/dymerge
```
- ![image](https://github.com/user-attachments/assets/b86354ec-ebe3-45d3-920e-e87c9d915ec1)
- ![image](https://github.com/user-attachments/assets/45c40618-a6b5-45e2-94e9-046de19c5e98)

## Instalacion Hydra
- Usaremos apt para instalar hydra
```bash
sudo apt install hydra
```
- ![image](https://github.com/user-attachments/assets/6a490951-c10d-4b5a-acf9-1007672d931f)
- ![image](https://github.com/user-attachments/assets/050d7704-00bd-4317-a09f-caef0f7680ac)

## Crear Diccionarios
- #### Para crear diccionarios hay que ir a la carpeta del pydictor y luego usar python3
- ![image](https://github.com/user-attachments/assets/de7aa7e7-ec3d-4393-a40b-3dc54d8b2b55)
- #### Para crear dicionarioos de numeros usaremos el siguiente comando (lo limitaremos a 3 digistos para no tardar mucho tiempo para hacer el ataque) y para que sea de numeros tiene que ser base "d"
```bash
python3 pydictor.py -base d --len 3 3 -o numeros.txt
```
- ![image](https://github.com/user-attachments/assets/b4478c94-e942-4734-9cf3-6c117d2b56dd)
- ![image](https://github.com/user-attachments/assets/a4edba35-1e01-47dc-b560-4f1186d253a2)
- #### Para crear el diccionario de letras mayusculas tiene que ser base "c"
```bash
python3 pydictor.py -base c --len 3 3 -o letras_mayusculas.txt
```
- ![image](https://github.com/user-attachments/assets/24461590-9554-41a5-81f5-950e4ac9622c)
- ![image](https://github.com/user-attachments/assets/5c46634c-5c17-4cce-ab83-e03c036dbc27)
## Fucionar Diccionarios
- #### ¡importante! dymerge funciona con python2 porque si lo ejecutamos con pyhton3 va a dar errores de sintaxis al intentar ejecutarlo
- ![image](https://github.com/user-attachments/assets/c43c33d8-23d7-460a-afd8-0b3c93049a51)
- #### Para fucionar usaremos este comando
```bash
python2 dymerge.py -f ../pydictor/results/numeros.txt ../pydictor/results/letras_mayusculas.txt -o diccionarion.txt
```
- En mi caso he puesto las rutas donde tengo los diccionarios creados
- ![image](https://github.com/user-attachments/assets/ca06eb5b-8d43-4618-8698-888fbdc88a96)
- ![image](https://github.com/user-attachments/assets/20f15587-1ebc-44e8-8a92-3c85efa96caa)

## Al ataque!!!
### Utilizaremos la herramienta Hydra para simular 2 ataques por fuerza bruta con diccionarion:

## 2.- Utilizar diccionarion con Hydra para simular un ataque de fuerza bruta en SSH:
### Instalar OpenSSH 
- No he usado openssh porque ya linux tiene su podrio ssh que es **sshd** y es el que usaré para hacer el ataque 
### Iniciar y configurar el servidor SSH en Kali Purple.
- Ya el sshd viene instalado y configurado en la maquina por lo que no es necesario hacer ninguna modificación
### Crear un usuario que simule ser el objetivo de tus pruebas.
![image](https://github.com/user-attachments/assets/c79020db-b166-426d-a91c-4d042880e622)
```bash
adduser pruebas
```
- usaré una contraseña poca segura para hacer el ataque 
### Conectar al servidor SSH desde tu sistema.
### Simular un ataque de fuerza bruta utilizando Hydra y diccionarion
- Para atacar usaremos el siguiente comando 
```bash
hydra -l pruebas -P /home/alumno/dymerge/diccionarion.txt ssh://127.0.0.1 -t 4 -w 1 -vV
````
- ![image](https://github.com/user-attachments/assets/49fb43db-3f3c-4e6c-a797-52e47a4e7087)
- ![image](https://github.com/user-attachments/assets/7d02c949-24fd-4883-b31f-5cb6341e353f)
### Revisar los logs del sistema para analizar los intentos de conexión.
- ![image](https://github.com/user-attachments/assets/6b62acbe-1f4b-4730-8eec-0acfde9611ad)
### Analizar los resultados y estudiar cómo mitigar ataques similares en entornos reales.
- Para evitar que pueden hacer este tipo de ataques podemos limitar el numero de intengos en la configuracion del ssh, tambien hay que crear contraseñas mas robustas para a la hora de que intente atacar sea mas difiicil romper las contraseñas y otro consejo mas seria bloquear las ips que intenten ahcer ataques para evitar futuros problemas
## 3.- Utilizar diccionarion con Hydra para simular un ataque de fuerza bruta con HTTP (formulario web)
### Instalar y configurar DVWA(https://github.com/digininja/DVWA) como una aplicación web vulnerable en tu servidor Apache local.
```bash
git clone https://github.com/digininja/DVWA
```
- ![image](https://github.com/user-attachments/assets/d937118b-f9c2-44fb-9ec0-5eb01700106b)
- luego de haberlo descargado hay que ir a la siguiente rura y copiar un archivoy renombrarlo
```bash
cp config/config.inc.php.dist config/config.inc.php
```
- Hay que meterse en el archivo config.inc.php y cambiara la contraseña que viene por una que queramos
- ![image](https://github.com/user-attachments/assets/33b5cfbd-53b5-45ab-8216-0e1c02d56faa)
- Hay que crear una base datos en mariadb
```sql
mysql> create database dvwa;
mysql> create user dvwa@localhost identified by 'p@ssw0rd';
mysql> grant all on dvwa.* to dvwa@localhost;
mysql> flush privileges;
````
- Despues hay que ingresar a la ruta en el navegador para instalar la aplicaciñon web
- ![image](https://github.com/user-attachments/assets/833bedaf-8350-4d20-a86b-7ac2092b7f16)
### Identificar los detalles del formulario de login para poder construir el ataque.
### Usar Hydra para realizar un ataque de fuerza bruta, utilizando diccionarion.
### Analizar los resultados y estudiar cómo mitigar ataques similares en entornos reales.
 
