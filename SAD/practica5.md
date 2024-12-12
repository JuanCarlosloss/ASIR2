Configuración y Análisis de Malware con Cuckoo Sandbox
Objetivos
1. Configurar el anfitrión (Kali Purple) para instalar y ejecutar Cuckoo Sandbox.
2. Configurar la máquina huésped (Windows) para ejecutar malware en un entorno controlado.
3. Realizar un análisis de malware utilizando Cuckoo Sandbox.
4. Interpretar los resultados del análisis de malware.
Precaución: Siempre asegúrate de que el análisis se realice en un entorno aislado como máquinas vir tuales. Nunca ejecutes malware directamente en tu sistema principal.
1. Configuración del Anfitrión (Kali Purple)
El anfitrión es donde instalarás y ejecutarás Cuckoo Sandbox. Sigue los siguientes pasos para configurar Kali Purple correctamente.
1.1 Instalar dependencias básicas
Para comenzar, es necesario instalar algunos paquetes y herramientas esenciales en Kali Purple. Abre un a terminal y ejecuta los comandos pertinentes.
1.2 Configurar permisos de captura de tráfico
Cuckoo necesita capturar el tráfico de red generado por el malware. Para otorgar estos permisos, ejecuta en una terminal comandos oportunos.
Reinicia tu sesión para que todo se aplique correctamente.
1.3 Crear un entorno virtual para Cuckoo
Instala Cuckoo en un entorno virtual de Python
1.4 Configurar la base de datos de Cuckoo
Cuckoo necesita una base de datos para almacenar los resultados del análisis. En este caso, utiliza Postg reSQL. Primero, inicia y configura PostgreSQL.
-crea una base de datos llamada cuckoo.
`-crea un usuario llamado cuckoo y dale todos los privilegios.`
A continuación, configura Cuckoo para que utilice esta base de datos editando el archivo de configuración de Cuckoo: cuckoo.conf`
En el archivo de configuración, la sección [database]` con la base de datos
[database]`
`connection = postgresql://cuckoo: cuckoo@localhost/cuckoo`
2. Configuración del Huésped (Windows)
El huésped es donde ejecutarás el malware en un entorno aislado. Sigue los siguientes pasos para config urar la máquina virtual Windows.
2.1 Crear una máquina virtual
Abre VirtualBox en Kali Purple y crea una nueva máquina virtual con las siguientes configuraciones:
Nombre: WindowsAna
Tipo: Microsoft Windows
Versión: Windows 10 (64-bit)
Memoria RAM: 4 GB (ajustable según los recursos disponibles).
Disco duro: 40 GB (mínimo).
Asegúrate de configurar los adaptadores de red de la siguiente manera:
Adaptador 1: NAT (para descargar herramientas en Windows).
Adaptador 2: Host-Only (para que la máquina huésped se comunique con el anfitrión).
2.2 Instalar Windows y herramientas
Instala Windows en la máquina virtual con una ISO de windows 10.
Después de instalar Windows, desactiva Windows Defender y Firewall para evitar interferencias durante el análisis:
1. Ve a Configuración → Actualización y seguridad → Seguridad de Windows → Administrar configu ración.
2. Desactiva las opciones de protección en tiempo real.
También instala las siguientes herramientas de análisis en el huésped:
Procmon (Sysinternals) para el monitoreo de procesos.
Wireshark para la captura de tráfico de red.
Process Explorer (Sysinternals) para el análisis de procesos.
2.3 Tomar un snapshot del huésped
Una vez que hayas instalado las herramientas necesarias, crea un snapshot (llamada `SnapshotAna`) de
la máquina virtual para poder restaurarla rápidamente después de cada análisis.
3. Configurar la Integración entre Anfitrión y Huésped
Para que el análisis de malware funcione correctamente, necesitas configurar una red entre el anfitrión y
el huésped.
3.1 Configurar la red Host-Only
En VirtualBox, ve a Archivo → Configuración → Red y crea una red Host-Only con la siguiente configura
ción:
IP del anfitrión: 192.168.56.1
Máscara de subred: 255.255.255.0
3.2 Configurar el huésped para usar Host-Only
En la máquina virtual Windows, configura la red de la siguiente manera:
1. Ve a Configuración de red.
2. Configura una IP estática:
IP: 192.168.56.101`
Puerta de enlace: 192.168.56.1
DNS 8.8.8.8
Verifica la conectividad con el siguiente comando desde el anfitrión (Kali Purple):
ping 192.168.56.101
4. Configurar y Usar Cuckoo
Ahora que has configurado tanto el anfitrión como el huésped, puedes proceder con la configuración y us
o de Cuckoo Sandbox.
4.1 Crear una máquina virtual en Cuckoo
Cuckoo necesita saber cómo interactuar con la máquina huésped. Abre el archivo de configuración de Virt
ualBox en Cuckoo:
nano ~/.cuckoo/conf/virtualbox.conf`
Añade la siguiente configuración:
`[virtualbox]`
machines win10`
`[win10]` `platform windows`
ip 192.168.56.101
snapshot Snapshot1`
4.2 Iniciar Cuckoo
Ahora puedes iniciar Cuckoo desde la terminal en Kali Purple:
`cd ~/cuckoo
`source venv/bin/activate
cuckoo
En otra terminal, ejecuta el servidor web de Cuckoo:
'cuckoo web`
Accede a la interfaz web de Cuckoo en http://127.0.0.1:8000 desde el navegador.
4.3 Enviar Malware a Cuckoo (Terminal y Web)
1. Enviar Malware a Cuckoo desde la Terminal
Una de las formas más directas de enviar malware a Cuckoo es utilizando la terminal. Esto te permite int
eractuar con Cuckoo desde la línea de comandos, lo cual puede ser útil en situaciones donde quieras auto
matizar el proceso o trabajar sin depender de la interfaz gráfica.
Pasos para enviar malware desde la terminal:
1. Accede a tu máquina Kali Purple anfitriona.
Abre una terminal y asegúrate de estar en el directorio donde tienes instalado Cuckoo. Si no lo has hech
o, activa tu entorno virtual primero:
`cd ~/cuckoo
source venv/bin/activate`
2. Envía el archivo de malware utilizando el comando `cuckoo submit`.
3. Una vez que ejecutas este comando, Cuckoo procesará el archivo de malware y comenzará a realizar
su análisis.
4. Verifica el estado del análisis:
Puedes revisar el progreso del análisis y obtener información sobre el estado utilizando el coma
ndo cuckoo status`. Esto te dará una visión general del estado de las tareas de análisis que se
están ejecutando.
2. Enviar Malware a Cuckoo desde la Interfaz Web
La interfaz web de Cuckoo proporciona una forma más visual y fácil de enviar archivos para su análisis. Es
ta opción es útil si prefieres trabajar con una interfaz gráfica y obtener los resultados de manera más acc
esible.
Pasos para enviar malware desde la interfaz web:
1. Asegúrate de que Cuckoo esté corriendo:
Primero, asegúrate de que tanto el servidor de Cuckoo como el servidor web estén en funcionami
ento. Si no lo has hecho ya, abre dos terminales:
En una terminal, inicia Cuckoo:
cd ~/cuckoo
`source venv/bin/activate`
cuckoo
En otra terminal, inicia el servidor web de Cuckoo:
cuckoo web
2. Accede a la interfaz web de Cuckoo:
Desde tu navegador, abre la siguiente dirección:
http://127.0.0.1:8000
3. Esta es la interfaz web de Cuckoo, onde podrás gestionar tus análisis y ver los resultados.
4. Subir el archivo de malware:
En la interfaz web de Cuckoo, busca la sección "Submit a new task" (Enviar una nueva tarea).
Haz clic en "Browse" (Examinar) para seleccionar el archivo de malware que deseas analizar. Asegúrate de que el archivo esté en una carpeta accesible desde el sistema.
5. Selecciona el archivo de malware:
Navega a la ubicación del archivo de malware en tu máquina y selecciona el archivo que deseas
enviar a Cuckoo.
6. Configura las opciones del análisis (opcional):
Si lo deseas, puedes elegir algunas configuraciones avanzadas como el tipo de máquina virtual
en la que se ejecutará el malware, el snapshot que se debe restaurar (si es que tienes varios), y otros parámetros relacionados con el análisis.
Asegúrate de que la máquina virtual configurada en la sección de "virtualbox.conf" esté seleccio
nada.
7. Enviar el archivo para análisis:
Haz clic en "Submit" para enviar el archivo de malware a Cuckoo para su análisis.
8. Verificar el análisis:
•
Una vez enviado el archivo, podrás ver el progreso del análisis en la interfaz web.
En la pestaña "Tasks" (Tareas), podrás ver la lista de archivos enviados y el estado de cada uno.
Cuando el análisis termine, podrás hacer clic en cualquier tarea para ver un informe detallado co
n los resultados del análisis.
Realiza
por terminal o por web los análisis de los siguientes
malwares, y si es posible por ambos métodos.
Ransomware
-Alguna versión de WannaCry
-Locky Troyanos de Acceso Remoto
-njRAT
Gusanos
-LoveLetter
Rootkits
-ZeroAccess Keyloggers -Alguna versión de Agent Tesla Malware Bancario
-ZeusBankingVersion
Utiliza alguna fuente "segura" para descargar malware, como por
ejemplo:
https://github.com/ytisf/theZoo/
5. Interpretar los Resultados
Una vez que el análisis haya terminado, puedes ver los resultados en la interfaz web de Cuckoo. Para cad
a análisis contestar a los siguientes puntos:
-Propósito, funcionalidad y comportamiento del Malware -Propagación y Distribución
-Técnicas de Comunicación externa
-Modificaciones en el Sistema
-Impacto en la Red, tráfico inusual, DoS,... -Qué técnicas de Evasión tiene para evadir su detección
-Análisis Forense e indicadores de Compromiso (IOCs)(que rastros deja, que procesos levanta,
claves registro, conexiones sospechosas,...) -Estrategias de Mitigación y Prevención