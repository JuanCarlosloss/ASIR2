# Ejercicio 1: Gestión de Permisos en un Entorno de Trabajo Multiusuario

## Escenario: Imagina que eres el administrador de un equipo de desarrollo con varios usuarios, y necesitas configurar los permisos de un proyecto compartido entre tres usuarios: monon1, tronko2 y birmingam3. Cada uno debe tener permisos específicos para un directorio de proyecto, de acuerdo con su rol.

### Paso 1: Crear un entorno simulado de usuarios y grupos Crea los tres usuarios y un grupo común llamado devEria12.
- - ![image](https://github.com/user-attachments/assets/82865c6f-7f70-4d67-b3bb-ea9ac55a1d6d)
- -
- Crea un directorio llamado di_recto para el proyecto y cambia el grupo propietario a devEria12.

### Paso 2: Configuración de permisos básicos Configura los permisos para que solo los usuarios del grupo devEria12 puedan escribir en el directorio.

- Verifica mostrando los permisos del directorio:

### Paso 3: Configuración de permisos avanzados monon1 debe tener permisos completos (lectura, escritura, ejecución) en todo el proyecto. Cambia el propietario del directorio a monon1.

- Los otros dos usuarios del grupo solo deben poder leer y ejecutar archivos, pero no modificarlos. Cambia los permisos de modo que el grupo devEria12 solo tenga permisos de lectura y ejecución.

### Preguntas:

- ¿Qué sucede si un usuario fuera del grupo devEria12 intenta acceder al directorio?
- ¿Qué sucede si tronko2 intenta modificar un archivo dentro del directorio?

# Ejercicio 2: Control de Acceso con el Bit SGID en Directorios

## Escenario: El equipo de desarrollo necesita colaborar en un subdirectorio dentro de di_recto. Queremos asegurarnos de que cualquier archivo creado en ese subdirectorio tenga automáticamente el mismo grupo propietario (devEria12), para facilitar la colaboración.

### Paso 1: Crear un subdirectorio para colaboración Crea un subdirectorio llamado di_afano dentro de di_recto:

- Cambia el grupo propietario del subdirectorio a devEria12.

### Paso 2: Aplicar el bit SGID Aplica el bit SGID al subdirectorio di_afano, para que todos los archivos creados en él hereden el grupo propietario:

- Verifica y muestra los permisos del subdirectorio:

### Paso 3: Crear archivos de prueba Cambia a tronko2 y crea un archivo llamado archivo_tronko2.txt dentro del subdirectorio di_afano:

- Verifica y muestra los permisos y el grupo propietario del archivo:

### Preguntas:

- ¿Cuál es el grupo propietario del archivo creado por tronko2?
- ¿Qué ventaja aporta el bit SGID en un entorno de colaboración?
