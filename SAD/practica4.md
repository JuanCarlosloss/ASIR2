### Fase 1: Estudia en la web de Synology, uno de los principales fabricantes de NAS, como se configuran estos para controlar un SAI y apagarse en caso de necesidad.
#### Para habilitar el servidor SAI de Synology:
- Inicie sesión en la unidad Synology NAS conectada al dispositivo SAI (por USB o red).
En la pestaña SAI, marque la casilla Habilitar servidor SAI de red para permitir que la unidad Synology NAS transmita la información de SAI a la unidad Synology NAS cliente.
- Haga clic en el botón Dispositivos Synology NAS permitidos.
- En la ventana que aparece, introduzca las direcciones IP del Synology NAS cliente. Haga clic en Aceptar.
- Haga clic en Aplicar para guardar la configuración.
- Ahora el servidor SAI de red puede obtener la información de SAI y transmitirla a unidad Synology NAS cliente que utiliza el dispositivo SAI. Siga estas instrucciones 
### Para habilitar la compatibilidad con SAI en la unidad Synology NAS cliente:
- Inicie sesión en la unidad Synology NAS cliente que utiliza el dispositivo SAI pero no está conectada por USB o red.
- En la pestaña SAI, marque la casilla de verificación Habilitar compatibilidad con SAI.
- Seleccione Servidor SAI de Synology en el menú desplegable Tipo de SAI.
- En Tiempo antes de que Synology NAS entre en modo de espera, seleccione el momento en que la unidad Synology NAS debería entrar en el modo de espera después de un corte de electricidad.
- Igual que el servidor: Esta opción apagará los productos de Synology cuando se apague el servidor.
- Personalizar hora: Puede indicar el momento en que la unidad Synology NAS debería entrar en el modo de espera después de un corte de electricidad. Introduzca un valor numérico y seleccione segundo(s), minuto(s) u hora(s) en el menú desplegable.
- Observación: Independientemente de la opción seleccionada, Synology NAS entrará automáticamente en el modo de espera cuando el nivel de alimentación sea bajo.
- Introduzca la dirección IP del servidor SAI de red en el campo IP del servidor UPS de red.
- Haga clic en Aplicar para guardar la configuración.
### Fase 2: Visita los asistentes recomendadores de 3 de las principales marcas de SAI (Salicru, CyberPower y APC), y encuentra para cada marca el modelo “enrackacle” más apropiado para una carga aproximada de 4000 VA(Voltio-Amperios).
#### Salicru
- https://www.salicru.com/sais/sps-advance-rt2.html **(Máximo 3000VA no hay de 4000VA)**
- **846€**
- <img src="https://github.com/user-attachments/assets/ff3755ff-70e4-4c21-a3b9-6ce3216df758" alt="sai-salicru" width="200"/>
#### CyberPower
- https://www.cyberpower.com/eu/es/product/sku/pr3000ertxl2u
- **1800€**
- ![saicyberpower](https://github.com/user-attachments/assets/dfe63ea1-2872-4a5a-98f4-8a1604178720)
### Fase 3: Simulación de SAI con NUT, Kibana, Prometheus y Grafana.
- **La herramienta NUT** (Network UPS Tools) permite simular el comportamiento de un SAI (Sistema de Alimentación Ininterrumpida) mediante un driver llamado dummy-ups, que crea un dispositivo UPS virtual. Esto es útil para pruebas o prácticas sin tener un hardware físico. La simulación incluye el estado de la batería, el tiempo de respaldo, el voltaje, y otros parámetros que un SAI real reportaría.	
- **Kibana** es una plataforma de análisis y visualización de datos que trabaja junto con Elasticsearch. Permite explorar, visualizar y analizar grandes volúmenes de datos a través de gráficos interactivos, tablas y dashboards. Es ampliamente utilizada para monitorización de logs, ofreciendo herramientas para buscar y filtrar eventos en tiempo real, crear alertas basadas en patrones de comportamiento, y generar dashboards personalizados que facilitan el análisis de datos y la toma de decisiones en entornos de monitorización, seguridad y operaciones.
- **Prometheus** es una herramienta de monitoreo y alerta diseñada para recolectar, almacenar y consultar métricas de sistemas y servicios en tiempo real. Las métricas recolectadas pueden ser consultadas para análisis y alerta cuando ciertos valores superan umbrales definidos, lo que lo convierte en una herramienta esencial para la observabilidad y el monitoreo proactivo de infraestructuras.
**Grafana** es una plataforma de visualización de datos que permite crear dashboards dinámicos para representar gráficamente métricas de sistemas y servicios. Funciona con diferentes fuentes de datos, como Prometheus, InfluxDB o Elasticsearch, para mostrar información en gráficos, tablas y alertas visuales en tiempo real. 
## Parte 1: Configuración de NUT en modo simulado

### Instalar NUT.

### Configurar NUT en modo simulado:

#### Edita el archivo de configuración de NUT (/etc/nut/ups.conf) y configura un SAI simulado usando el driver dummy-ups.
Añade la siguiente configuración para simular un SAI: [simups] driver = dummy-ups port = /dev/ttyS0 battery.charge = 80 # Simula un 80% de carga de batería ups.status = OL # SAI en línea, sin problemas desc = "Simulated UPS"
Configurar el servicio de NUT:
![image](https://github.com/user-attachments/assets/933c181e-780c-4ce9-b720-91b1e62a0c1f)

#### Edita el archivo /etc/nut/upsmon.conf para definir la monitorización del SAI:
MONITOR simups@localhost 1 upuser password master
Asegúrate de que los permisos del archivo estén correctamente configurados.
Iniciar el servicio de NUT.
- ![image](https://github.com/user-attachments/assets/c17bf5e8-bba9-4619-8985-24c2d310b69f)

#### Verificar el estado del SAI simulado.
- ![image](https://github.com/user-attachments/assets/5cc84152-c9bf-49df-9b4f-c05859d10cb7)

## Parte 2: Monitorización de eventos con Kibana
### 1. Instalar Kibana.
### 2. Configurar NUT para enviar logs.
#### NUT registra eventos críticos, como batería baja o fallos de alimentación, en el archivo de log del sistema. Estos logs pueden enviarse a Kibana para su análisis. Asegúrate de que rsyslog esté configurado para enviar los logs al puerto adecuado de Kibana.
### 3. Crear filtros y dashboards en Kibana para analizar y visualizar los logs generados por NUT.
#### Configura Kibana para analizar y visualizar los logs generados por NUT, tales como:
- Estado de la batería.
- Tiempo de respaldo.
- Eventos críticos como sobrecarga o fallo de alimentación.
#### Crea un dashboard que muestre visualmente los eventos más rele- vantes, como las caídas de energía o la activación del modo batería. 4. Simulación de eventos críticos.
#### Cambia los parámetros en el archivo de configuración de NUT (ups.conf) para simular eventos como batería baja o fallo de alimentación:
- ups.status = OB LB # Modo batería, baja carga
- battery.charge = 10 # Simula un 10% de batería restante Reinicia NUT y verifica cómo se registran los eventos en Kibana. Estos eventos deberían aparecer como logs críticos, que pueden generar alertas si están configuradas.
## Instalar Kibana.
#### Para instalar kibana primero hay que instalar elasticsearch
- ### Para instalar elasticsearch usamos este comando para descargarlos en los repositorios oficiales
```bash
wget https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-8.16.0-linux-x86_64.tar.gz
wget https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-8.16.0-linux-x86_64.tar.gz.sha512
shasum -a 512 -c elasticsearch-8.16.0-linux-x86_64.tar.gz.sha512 
tar -xzf elasticsearch-8.16.0-linux-x86_64.tar.gz
cd elasticsearch-8.16.0/ 
```
- ![image](https://github.com/user-attachments/assets/c06cc80e-40c6-43b9-836a-4a3acecf5e7a)
- ![image](https://github.com/user-attachments/assets/bee88402-13bf-4b9b-85c4-081844781ee9)
- #### Para iniciar elasticseach usamos este comando
```bash
./bin/elasticsearch
```
- al iniciar el programa nos dara una información importante a la hora de configurar kibana y poder acceder al dashboard
- ![image](https://github.com/user-attachments/assets/cec874d1-ab09-4919-9cae-6169e20b3485)
- no cerraremos la terminal ya que si la cerramos el servicio se parará 
### Instalación Kibana
```bash
curl -O https://artifacts.elastic.co/downloads/kibana/kibana-8.16.0-linux-x86_64.tar.gz
curl https://artifacts.elastic.co/downloads/kibana/kibana-8.16.0-linux-x86_64.tar.gz.sha512 | shasum -a 512 -c - 
tar -xzf kibana-8.16.0-linux-x86_64.tar.gz
cd kibana-8.16.0/ 
```
- ![image](https://github.com/user-attachments/assets/bb079d25-ceac-42fa-9b08-ffba0d8e5cb9)
- ![image](https://github.com/user-attachments/assets/8976a843-1cce-4f40-852c-3c600a319d23)
- #### para iniciar el kiabana hay que usar este comando
```bash
./bin/kibana
```
- ![image](https://github.com/user-attachments/assets/de7024fb-4215-4a40-af45-b6ea5ccead8c)
- #### para iniciar el kinaba hay que abrir el navegador y poner este enlace http://localhost:5601/?code=406343 y despues hay que empezar a configurar
- ![image](https://github.com/user-attachments/assets/75d3aa60-f5da-4af5-a4d1-1248ad2c9418)
- hay que poner el token que te ofrecio el elasticsearch para poder configurar el kibana
- hay que poner un codigo de virificacion que se genera en bin/kibana-verification-code
- ![image](https://github.com/user-attachments/assets/994445bb-b8ce-426b-95d4-e2f8faf06b99)
- luego se veria una ventana que se ve como se configura el kibana
- ![image](https://github.com/user-attachments/assets/b2da31fc-c667-4687-85ef-687f56abbbda)
- despues de que se configure nos pedirá credenciales para poder acceder a kibana que se han generado la primera vez que se inició el elasticsearch
- ![image](https://github.com/user-attachments/assets/66462b9c-417e-4449-8d3c-40c8b7381c7c)
- con kibana no helogrado sacar ningun log del sistema ni metricas
### Configurar NUT para enviar logs.
### NUT registra eventos críticos, como batería baja o fallos de alimentación, en el archivo de log del sistema. Estos logs pueden enviarse a Kibana para su análisis. Asegúrate de que syslog esté configurado para enviar los logs al puerto adecuado de Kibana.

### Crear filtros y dashboards en Kibana para analizar y visualizar los logs generados por NUT.

### Configura Kibana para analizar y visualizar los logs generados por NUT, tales como:
- Estado de la batería.
- Tiempo de respaldo.
- Eventos críticos como sobrecarga o fallo de alimentación.
- Crea un dashboard que muestre visualmente los eventos más relevantes, como las caídas de energía o la activación del modo batería.
- Simulación de eventos críticos.

## Cambia los parámetros en el archivo de configuración de NUT (ups.conf) para simular eventos como batería baja o fallo de alimentación:
- ups.status = OB LB # Modo batería, baja carga
- battery.charge = 10 # Simula un 10% de batería restante
- Reinicia NUT y verifica cómo se registran los eventos en Kibana. Estos eventos deberían aparecer como logs críticos, que pueden generar alertas si están configuradas.
