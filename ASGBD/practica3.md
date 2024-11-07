### Gestión y Configuración de Bases de Datos SQLite
### Eres el (DBA) administrador de una base de datos SQLite para una pequeña aplicación de gestión de frutas en dispositivos móviles. Tendrás que configurar correctamente la base de datos, optimizar su rendimiento, realizar backups/restauraciones y garantizar la seguridad de los datos almacenados.
### Finalidad:
- Gestionar y configurar el entorno de la base de datos SQLite.
- Optimizar el rendimiento de la base de datos a través de diferentes técnicas de ajuste.
- Implementar copias de seguridad y restauración.
- Aplicar técnicas de seguridad para proteger los datos sensibles.
#### Requisitos del entorno:
- Instalación de SQLite: Asegúrate de tener SQLite instalado en tu entorno de trabajo. Puedes verificarlo con:
bash
- Copiar código
- sqlite3 --version
### Crea una base de datos llamada frutas.db que almacenará la información de mandarinas, melocotones y caquis.
1. Configuración de la base de datos (2 puntos)
1.1. Creación de tablas y estructura
Crea las siguientes tablas básicas con las restricciones adecuadas:
#### Mandarinas:
- id_mandarina (INTEGER, PK, AUTOINCREMENT): Identificador único para cada mandarina.
- color (TEXT, NOT NULL): Color de la mandarina.
- nombre (TEXT, NOT NULL): Nombre de la mandarina.
- fecha_recoleccion (DATE, NOT NULL): Fecha en la que se recogió la mandarina.
- ![image](https://github.com/user-attachments/assets/12767c86-8bd9-4a00-b14b-c48062ea81fb)

#### Melocotones:
- id_melocoton (INTEGER, PK, AUTOINCREMENT): Identificador único para cada melocotón.
- tipo (TEXT, NOT NULL): Tipo de melocotón.
- suave (BOOLEAN, NOT NULL): Indica si el melocotón es suave (1) o no (0).
- ![image](https://github.com/user-attachments/assets/4326e1a1-87e0-4b95-8eee-e7fce7783043)
#### Caquis:
- id_caqui (INTEGER, PK, AUTOINCREMENT): Identificador único para cada caqui.
- id_mandarina (INTEGER, FK, NOT NULL): Relacionado con id_mandarina en la tabla mandarinas.
- id_melocoton (INTEGER, FK, NOT NULL): Relacionado con id_melocoton en la tabla melocotones.
- color (TEXT, NOT NULL): Color del caqui.
- pedunculo (BOOLEAN, NOT NULL): Indica si el caqui tiene pedúnculo (1) o no (0).
- tiempo_maduracion (INTEGER, NOT NULL): Tiempo de maduración en días.
- ![image](https://github.com/user-attachments/assets/8d6d7caf-6c72-44d5-a098-f5dcba02466c)
#### 1.2. Tamaño y más...
Justifica cuánto ocupa tu base de datos en disco. ¿En qué momento aumenta de tamaño si se mete más info? ¿como DBA harías algo para optimizar esto?
- el tamaño de la base de datos en disco depende del número de filas y columnas, así como de los tipos de datos y el índice que se usan.
#### Optimización 
- Compactación
- Índices adecuados
- Tipos de datos eficientes
#### 3. Optimización del rendimiento y mantenimiento (5 puntos)
Se ha encontrado un trozo de log de consultas a la base de datos durante el día 27 de octubre de 2024. Se pide que optimizaciones realizarías y por qué para mejorar la base de datos en función de la información que te ofrece el log y justifícalo.
PISTA: Utiliza EXPLAIN QUERY PLAN y chequea todos los PRAGMAS de SQLite.
- Consultas repetitivas: Varias consultas seleccionan los mismos campos repetidamente, como SELECT color, tamaño FROM Mandarinas.
- Filtros por campo específico: Existen consultas de filtrado frecuentes, como SELECT pedunculo FROM Mandarinas WHERE pedunculo = 1.
- Actualizaciones puntuales: También hay algunas consultas UPDATE, por ejemplo, UPDATE Caquis SET pedunculo = 0 WHERE id_caqui = 15.
#### Optimización
- Crear índices en columnas
- CREATE INDEX idx_mandarinas_pedunculo ON Mandarinas (pedunculo);
- CREATE INDEX idx_mandarinas_fecha_recogida ON Mandarinas (fecha_recogida);
- CREATE INDEX idx_mandarinas_tamaño ON Mandarinas (tamaño);
- CREATE INDEX idx_mandarinas_color ON Mandarinas (color);
#### 4. Copias de seguridad y restauración (2.5 puntos)
#### 3.1 Realización de una copia de seguridad con el nombre frutas_bonitas_bonitas.db
- sqlite3 nombre_original.db ".backup frutas_bonitas_bonitas.db"
- ![image](https://github.com/user-attachments/assets/33ac875f-930f-4d59-acda-e445bf95cd81)
#### 3.2 Realiza la restauración desde la copia de seguridad
- ![image](https://github.com/user-attachments/assets/b1ded0a2-4af3-4bf5-a4ff-d370f0748942)
#### 3.3 Automatización de backups
- Crea un script para backups automáticos y que ejecute todos los días a las 23:59:59
- 0 0 * * * /home/alumno/Documents/frutitas.db ".backup /home/alumno/Documents/frutas_bonitas_bonitas_$(date +\%Y\%m\%d\%H\%M\%S).db"
- ![image](https://github.com/user-attachments/assets/67daba4a-9cab-460d-ad87-4c4e6a9f9876)

#### 5. Preguntas sin ChatGPT ni IA's: (0.5 puntos)
- ¿Cómo impactan los cambios en el PRAGMA en el rendimiento y la seguridad de la base de datos?
* PRAGMA synchronous: Ajustado a NORMAL o OFF mejora el rendimiento al reducir escrituras en disco, pero disminuye la durabilidad en caso de fallo.
* PRAGMA journal_mode: WAL aumenta la concurrencia y mejora la velocidad en lecturas/escrituras simultáneas
* PRAGMA cache_size: Aumentar la caché mejora la velocidad al reducir accesos a disco
- ¿Qué mecanismos adicionales usarías para proteger una base de datos SQLite en un entorno de producción?
* Cifrado: Protege los datos sensibles en caso de acceso no autorizado.
* Control de acceso al archivo: Establecer permisos de archivo restrictivos en el sistema operativo para proteger la base de datos contra accesos no deseados.
* Backups regulares: Garantizan recuperación de datos en caso de corrupción o pérdida.
- ¿Qué diferencia existe entre los modos de journaling como DELETE, TRUNCATE y WAL en SQLite?
