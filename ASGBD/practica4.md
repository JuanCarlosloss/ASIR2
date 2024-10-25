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
- ![71K12logzqL _AC_SX569_](https://github.com/user-attachments/assets/76eee0fc-d9f1-47ec-b3e2-a9f6f5b4c1cb)
#### CyberPower
### Fase 3: Simulación de SAI con NUT, Kibana, Prometheus y Grafana.
- **La herramienta NUT** (Network UPS Tools) permite simular el comportamiento de un SAI (Sistema de Alimentación Ininterrumpida) mediante un driver llamado dummy-ups, que crea un dispositivo UPS virtual. Esto es útil para pruebas o prácticas sin tener un hardware físico. La simulación incluye el estado de la batería, el tiempo de respaldo, el voltaje, y otros parámetros que un SAI real reportaría.	
- **Kibana** es una plataforma de análisis y visualización de datos que trabaja junto con Elasticsearch. Permite explorar, visualizar y analizar grandes volúmenes de datos a través de gráficos interactivos, tablas y dashboards. Es ampliamente utilizada para monitorización de logs, ofreciendo herramientas para buscar y filtrar eventos en tiempo real, crear alertas basadas en patrones de comportamiento, y generar dashboards personalizados que facilitan el análisis de datos y la toma de decisiones en entornos de monitorización, seguridad y operaciones.
- **Prometheus** es una herramienta de monitoreo y alerta diseñada para recolectar, almacenar y consultar métricas de sistemas y servicios en tiempo real. Las métricas recolectadas pueden ser consultadas para análisis y alerta cuando ciertos valores superan umbrales definidos, lo que lo convierte en una herramienta esencial para la observabilidad y el monitoreo proactivo de infraestructuras.
**Grafana** es una plataforma de visualización de datos que permite crear dashboards dinámicos para representar gráficamente métricas de sistemas y servicios. Funciona con diferentes fuentes de datos, como Prometheus, InfluxDB o Elasticsearch, para mostrar información en gráficos, tablas y alertas visuales en tiempo real. 
