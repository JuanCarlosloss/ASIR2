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
