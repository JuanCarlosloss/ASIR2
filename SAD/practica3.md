## Ejercicio 1: Gestión de Permisos en un Entorno de Trabajo Multiusuario

### Escenario:

#### Imagina que eres el administrador de un equipo de desarrollo con varios usuarios, y necesitas configurar los permisos de un proyecto compartido entre tres usuarios: moon1, tronko2 y birmingham3. Cada uno debe tener permisos específicos para un directorio de proyecto, de acuerdo con su rol.

### Paso 1: Crear un entorno simulado de usuarios y grupos
- ![image](https://github.com/user-attachments/assets/b297bef7-37e8-4a92-929e-4237b6ecf740)
- sudo useradd monon1
- sudo useradd tronko2
- sudo useradd birmingham3
#### Crea los tres usuarios y un grupo común llamado devEriIa2.
- ![image](https://github.com/user-attachments/assets/7d702226-4d8e-412a-9ebd-438c108953d5)
- sudo groupadd devEliza
- sudo usermod -aG devEliza monon1
- sudo usermod -aG devEliza tronko2
- sudo usermod -aG devEliza birmingham3
#### Crea un directorio llamado di_recto para el proyecto y cambia el grupo propietario a devEriIa2.
- ![image](https://github.com/user-attachments/assets/178500ae-f3da-49ef-a526-0043992376e3)4
- sudo mkdir di_reto
- sudo chown :devEliza di_reto
- ![image](https://github.com/user-attachments/assets/aff90e21-f376-43f2-946f-607a8ff53f09)

### Paso 2: Configuración de permisos básicos

#### Configura los permisos para que solo los usuarios del grupo devEriIa2 puedan escribir en el directorio:
- ![image](https://github.com/user-attachments/assets/c290abb3-0400-4db7-9573-92363b903d04)
- sudo chmod 770 di_reto  
#### Verifica mostrando los permisos del directorio:
- ![image](https://github.com/user-attachments/assets/21a8cbc2-8833-494d-affa-bdc3bef2161b)
### Paso 3: Configuración de permisos avanzados
#### moon1 debe tener permisos completos (lectura, escritura, ejecución) en todo el proyecto. Cambia el propietario del directorio a moon1.
- ![image](https://github.com/user-attachments/assets/22ab4bfe-62e7-447b-a236-e963bd93d482)
- sudo chown monon1 di_reto                     
- sudo chmod 770 di_reto
- ![image](https://github.com/user-attachments/assets/94e50c3c-2d3f-49b3-9961-62ec3d334da5)   
#### Los otros dos usuarios del grupo solo deben poder leer y ejecutar archivos, pero no modificarlos. Cambia los permisos de modo que el grupo devEriIa2 solo tenga permisos de lectura y ejecución:
![image](https://github.com/user-attachments/assets/957615db-6422-48a9-8b5f-171b2e11b176)
- sudo chmod 750 di_reto
- ![image](https://github.com/user-attachments/assets/b3b1e26e-f219-4c26-a26d-3614c9d98cb8)
### Preguntas:
#### ¿Qué sucede si un usuario fuera del grupo devEriIa2 intenta acceder al directorio?
- No podrá acceder al directorio ya que los permisos están limitados a devEliza.
#### ¿Qué sucede si tronko2 intenta modificar un archivo dentro del directorio?
- tronko2 solo tendrá permisos de lectura y ejecución, por lo tanto no podrá modificar archivos.

﻿

## Ejercicio 2: Control de Acceso con el Bit SGID en Directorios
### Escenario:
### El equipo de desarrollo necesita colaborar en un subdirectorio dentro de di recto. Queremos asegurarnos de que cualquier archivo creado en ese subdirectorio tenga automáticamente el mismo grupo propietario (devEria2), para facilitar la colaboración.
### Paso 1: Crear un subdirectorio para colaboración
#### Crea un subdirectorio llamado di_afano dentro de /di_recto:
- ![image](https://github.com/user-attachments/assets/c49ab9b9-638b-4f30-bed8-055a36e2a88f)
- sudo mkdir di_reto/di_afano 
#### Cambia el grupo propietario del subdirectorio a deveria2
- ![image](https://github.com/user-attachments/assets/3ad7327e-be9b-4b7f-b7f4-91fa734f11d3)
- sudo chown :devEliza di_reto/di_afano 
- ![image](https://github.com/user-attachments/assets/85503f44-6d05-449f-85d5-5a707012ffec)
#### Paso 2: Aplicar el bit SGID
#### Aplica el bit SGID al subdirectorio di_afano, para que todos los archivos creados en él hereden el grupo propietario
- ![image](https://github.com/user-attachments/assets/7c061877-b3cf-4405-a0b9-5dff0321bead)
- sudo chmod 2770 di_reto/di_afano
#### Verifica y muestra los permisos del subdirectorio:
- ![image](https://github.com/user-attachments/assets/0eece4c6-d2df-4eb9-95aa-b7eea0eb303d)
### Paso 3: Crear archivos de prueba
#### Cambia a tronko2 y crea un archivo llamado archivo_tronko2.txt dentro del subdirectorio di_afano
- ![image](https://github.com/user-attachments/assets/90ada6b7-5961-4a44-a34e-8c0f5855484c)
#### Verifica y muestra los permisos y el grupo propietario del archivo:
![image](https://github.com/user-attachments/assets/366426a5-6676-4143-b3ea-cd65f47fae48)
#### Preguntas:
### ¿Cuál es el grupo propietario del archivo creado por tronko2?
- El grupo propietario será devEliza debido a que el bit SGID se aplicó al directorio, asegurando que todos los archivos creados en él hereden este grupo.
### ¿Qué ventaja aporta el bit SGID en un entorno de colaboración?
- El bit SGID permite que todos los archivos creados dentro del directorio tengan el mismo grupo propietario (devEliza), facilitando que cualquier miembro del grupo acceda y colabore en los archivos sin necesidad de cambiar manualmente el grupo propietario cada vez que se crea un archivo.

## Ejercicio 3: Gestión de Archivos Temporales con Sticky Bit
### Escenario:
#### Se ha creado un directorio temporal compartido entre todos los usuarios del sistema. Necesitas asegurarte de que los usuarios puedan crear y modificar sus propios archivos, pero no puedan eliminar o modificar los archivos de otros
usuarios.
### Paso 1: Crear un directorio temporal
#### Crea un directorio llamado tmp_rano en /tmp
- ![image](https://github.com/user-attachments/assets/5821e6d2-7b6e-4212-aab6-1e5eed21befd)
- sudo mkdir /tmp/tmp_rano
#### Cambia los permisos para que todos los usuarios puedan leer, escribir y ejecutar en el directorio
- ![image](https://github.com/user-attachments/assets/b8b7c838-da6a-46fc-9416-f18db713b069)ls 
- sudo chmod 777 /tmp/tmp_rano
- ![image](https://github.com/user-attachments/assets/3a2d9bee-bf89-4f80-9722-59e5485f7f93)
### Paso 2: Aplicar el sticky bit Aplica el sticky bit al directorio para evitar que los usuarios eliminen archivos de otros
- sudo chmod +t /tmp/tmp_rano
#### Verifica los permisos del directorio
![image](https://github.com/user-attachments/assets/ac433657-8558-41ce-aabe-8c67b45b0655)
### Paso 3: Crear archivos de prueba
#### Cambia a monon1 y crea un archivo en el directorio temporal
- ![image](https://github.com/user-attachments/assets/32a64f9a-05d5-4b0d-8111-5fae13bab67b)
- sudo -u monon1 touch /tmp/tmp_rano/archivo_monon1.txt
#### Cambia a birmingan3 y verifica si puede eliminar el archivo de monon1
- ![image](https://github.com/user-attachments/assets/fcd03fc8-96c4-4c07-875d-44a7a9b3654a)
- sudo -u birmingham3 rm /tmp/tmp_rano/archivo_monon1.txt
###Preguntas:
### ¿Pudo birmingan3 eliminar el archivo de monon1? ¿Por qué?
- No, birmingham3 no pudo eliminar el archivo de monon1 porque el Sticky Bit impide que otros usuarios eliminen archivos que no son de su propiedad en el directorio compartido.
### ¿Cómo ayuda el sticky bit a mejorar la seguridad en directorios compartidos?
- El Sticky Bit asegura que solo los propietarios de los archivos y el administrador del sistema puedan eliminar o modificar los archivos en un directorio compartido, evitando que otros usuarios interfieran con los archivos ajenos.

## Ejercicio 4: Configuración de umask y Creación de Archivos Nuevos

### Escenario:

#### Quieres configurar el entorno de trabajo para que todos los archivos nuevos creados por los usuarios tengan permisos predeterminados restrictivos (solo lectura y escritura para el propietario, sin acceso para el grupo y otros).

### Paso 1: Configurar umask

#### Verifica el valor actual de umask.

#### Cambia el valor de umask a 077 para que los archivos creados sean accesibles solo por el propietario.

### Paso 2: Crear archivos de prueba

#### Crea un archivo nuevo llamado gomaseps_umask y verifica sus permisos.

### Paso 3: Restablecer umask

#### Si deseas restaurar el valor predeterminado de umask, puedes hacerlo:

### Preguntas:

### ¿Cómo afectó el valor de umask a los permisos de los nuevos archivos?
### ¿Cómo podrías usar umask para mejorar la seguridad de los archivos en un sistema multiusuario?

## Ejercicio 5: Implementación de ACLs

### Queremos que birmingham3 pueda leer un archivo específico dentro de un nuevo directorio que se tiene que crear llamado archivos_criticos, pero sin poder modificarlo.

#### Habilita ACLs en el sistema si no están habilitadas (si ya lo están, omite este paso):

#### Crea un archivo llamado osaka.txt dentro de archivos_criticos.

#### Añade una ACL para que birmingham3 pueda leer el archivo osaka.txt, pero no modificarlo.

#### Verifica y muestra las ACLs del archivo:

### Preguntas:

### ¿Cómo afectan las ACLs al comportamiento de permisos tradicionales?
### ¿Qué sucede si birmingham3 intenta modificar el archivo?

## Ejercicio 6: Auditoría y control de accesos mediante logs de permisos

### Escenario:

#### Como administrador, necesitas auditar los accesos a archivos críticos para asegurarte de que nadie acceda de manera indebida a los datos sensibles. Implementarás auditorías en archivos clave para monitorear el acceso.

### Paso 1: Configuración de auditoría de accesos con auditd

#### Instala el servicio de auditoría si no está instalado.
#### Configura una regla para auditar los accesos al archivo archivo_tronko2.txt.

### Paso 2: Verificación de logs de auditoría

#### Accede al archivo archivo_tronko2.txt como moon1.

#### Verifica e interpreta los logs de auditoría.
#### Accede al archivo archivo_tronko2.txt como tronko2.

#### Verifica e interpreta los logs de auditoría.
#### Accede al archivo archivo_tronko2.txt como birmingham3.

#### Verifica e interpreta los logs de auditoría.

### Pregunta:

### ¿Cómo puedes usar las auditorías para mejorar la seguridad de tu sistema?
