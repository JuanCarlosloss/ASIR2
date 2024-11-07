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
