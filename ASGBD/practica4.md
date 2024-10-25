### Fase 1: Estudia en la web de Synology, uno de los principales fabricantes de NAS, como se configuran estos para controlar un SAI y apagarse en caso de necesidad.
#### Para habilitar el servidor SAI de Synology:
- Inicie sesión en la unidad Synology NAS conectada al dispositivo SAI (por USB o red).
En la pestaña SAI, marque la casilla Habilitar servidor SAI de red para permitir que la unidad Synology NAS transmita la información de SAI a la unidad Synology NAS cliente.
- Haga clic en el botón Dispositivos Synology NAS permitidos.
- En la ventana que aparece, introduzca las direcciones IP del Synology NAS cliente. Haga clic en Aceptar.
- Haga clic en Aplicar para guardar la configuración.
- Ahora el servidor SAI de red puede obtener la información de SAI y transmitirla a unidad Synology NAS cliente que utiliza el dispositivo SAI. Siga estas instrucciones para habilitar la compatibilidad con SAI en la unidad Synology NAS cliente.

### Fase 2: Visita los asistentes recomendadores de 3 de las principales marcas de SAI (Salicru, CyberPower y APC), y encuentra para cada marca el modelo “enrackacle” más apropiado para una carga aproximada de 4000 VA(Voltio-Amperios).
### Fase 3: Simulación de SAI con NUT, Kibana, Prometheus y Grafana.
- **La herramienta NUT** (Network UPS Tools) permite simular el comportamiento de un SAI (Sistema de Alimentación Ininterrumpida) mediante un driver llamado dummy-ups, que crea un dispositivo UPS virtual. Esto es útil para pruebas o prácticas sin tener un hardware físico. La simulación incluye el estado de la batería, el tiempo de respaldo, el voltaje, y otros parámetros que un SAI real reportaría.	
- **Kibana** es una plataforma de análisis y visualización de datos que trabaja junto con Elasticsearch. Permite explorar, visualizar y analizar grandes volúmenes de datos a través de gráficos interactivos, tablas y dashboards. Es ampliamente utilizada para monitorización de logs, ofreciendo herramientas para buscar y filtrar eventos en tiempo real, crear alertas basadas en patrones de comportamiento, y generar dashboards personalizados que facilitan el análisis de datos y la toma de decisiones en entornos de monitorización, seguridad y operaciones.
- **Prometheus** es una herramienta de monitoreo y alerta diseñada para recolectar, almacenar y consultar métricas de sistemas y servicios en tiempo real. Las métricas recolectadas pueden ser consultadas para análisis y alerta cuando ciertos valores superan umbrales definidos, lo que lo convierte en una herramienta esencial para la observabilidad y el monitoreo proactivo de infraestructuras.
**Grafana** es una plataforma de visualización de datos que permite crear dashboards dinámicos para representar gráficamente métricas de sistemas y servicios. Funciona con diferentes fuentes de datos, como Prometheus, InfluxDB o Elasticsearch, para mostrar información en gráficos, tablas y alertas visuales en tiempo real. 
