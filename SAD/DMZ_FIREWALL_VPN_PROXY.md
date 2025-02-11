# Esquema de la Red

## Dispositivo | Interfaz | Red / IP  
**FW1 (pfSense Externo)** | WAN | 192.168.100.0/24 (probando en un entorno NAT).  
**FW1 (pfSense Externo)** | DMZ | 192.168.1.1/24  
**FW2 (pfSense Interno)** | DMZ | 192.168.1.2/24  
**FW2 (pfSense Interno)** | LAN | 192.168.0.1/24  
**Servidor VPN** | DMZ | 192.168.1.10/24  
**Servidor Proxy** | LAN | 192.168.0.10/24  
**Cliente Interno** | LAN | 192.168.0.100/24  

# Configuración de VirtualBox para cada máquina

## 1. Firewall Externo (FW1 - pfSense)

### Configuración General  
- Nombre de la máquina: FW1 (pfSense)  
- RAM: 2 GB  
- CPU: 1 vCPU  
- Disco duro: 8 GB (Dinámicamente asignado)  
- Sistema operativo: pfSense ISO, FreeBSD 64-bit (descargar ISO de la última versión del sitio oficial).  

### Configuración de Red  
- **Adaptador 1 (WAN):**  
  - Tipo: Red NAT  
  - Propósito: Conexión a Internet.  
- **Adaptador 2 (DMZ):**  
  - Tipo: Red Interna  
  - Nombre de la red interna: DMZ  

## 2. Firewall Interno (FW2 - pfSense)

### Configuración General  
- Nombre de la máquina: FW2 (pfSense)  
- RAM: 2 GB  
- CPU: 1 vCPU  
- Disco duro: 8 GB (Dinámicamente asignado)  
- Sistema operativo: pfSense ISO, FreeBSD 64-bit (descargar ISO de la última versión del sitio oficial).  

### Configuración de Red  
- **Adaptador 1 (DMZ):** Red Interna (Nombre: DMZ)  
- **Adaptador 2 (LAN):** Red Interna (Nombre: LAN)  

## 3. Servidor VPN (Ubuntu Server o similar)

### Configuración General  
- Nombre de la máquina: Servidor VPN  
- RAM: 2 GB  
- CPU: 1 vCPU  
- Disco duro: 10 GB (Dinámicamente asignado)  
- Sistema operativo: Ubuntu Server 22.04 ISO o similar.  

### Configuración de Red  
- **Adaptador 1 (DMZ):** Red Interna (Nombre: DMZ)  

## 4. Servidor Proxy (Squid en Ubuntu Server o similar)

### Configuración General  
- Nombre de la máquina: Servidor Proxy  
- RAM: 2 GB  
- CPU: 1 vCPU  
- Disco duro: 10 GB (Dinámicamente asignado)  
- Sistema operativo: Ubuntu Server 22.04 ISO. O similar.  

### Configuración de Red  
- **Adaptador 1 (LAN):** Red Interna (Nombre: LAN)  

## 5. Cliente Interno

### Configuración General  
- Nombre de la máquina: Cliente Interno  
- RAM: 1 GB  
- CPU: 1 vCPU  
- Disco duro: 8 GB (Dinámicamente asignado)  
- Sistema operativo: Windows 7/10/11.  

### Configuración de Red  
- **Adaptador 1 (LAN):** Red Interna (Nombre: LAN)  

# Configuración de Firewalls con pfSense

## 1.1. Configuración del Firewall Externo (FW1)

### Reglas de Firewall (WAN y DMZ)

- **Permitir acceso al servidor VPN en la DMZ:**  
  - Interfaz: WAN  
  - Proto: UDP  
  - Puerto: 1194  
  - Destino: 192.168.1.10  

- **Permitir tráfico desde DMZ hacia Internet:**  
  - Interfaz: DMZ  
  - Proto: TCP/UDP  
  - Puerto: Any  
  - Destino: Any  

- **Bloquear tráfico directo de DMZ a LAN (excepto VPN a Proxy):**  
  - Interfaz: DMZ  
  - Proto: Any  
  - Destino: 192.168.0.0/24  
  - Acción: Block  
  - Excepción: 192.168.1.10 -> 192.168.0.10  

## NAT en FW1  
- **Outbound NAT:** Habilita NAT automático o manual.  
- **Regla NAT:** Traduce 192.168.1.0/24 → WAN (masquerade).  

## 1.2. Configuración del Firewall Interno (FW2)

### Reglas de Firewall (DMZ y LAN)

- **Permitir tráfico del Proxy a Internet:**  
  - Interfaz: LAN  
  - Proto: TCP  
  - Origen: 192.168.0.10  
  - Destino: Any  
  - Puerto: 80, 443  

- **Permitir tráfico de Cliente Interno al Proxy (3128):**  
  - Interfaz: LAN  
  - Proto: TCP  
  - Origen: 192.168.0.0/24  
  - Destino: 192.168.0.10  
  - Puerto: 3128  

- **Permitir tráfico de la VPN al Proxy:**  
  - Interfaz: DMZ  
  - Proto: TCP  
  - Origen: 192.168.1.10  
  - Destino: 192.168.0.10  
  - Puerto: 3128  

- **Bloquear tráfico directo de DMZ a LAN (excepto VPN a Proxy):**  
  - Interfaz: DMZ  
  - Proto: Any  
  - Destino: 192.168.0.0/24  
  - Acción: Block  
  - Excepción: 192.168.1.10 -> 192.168.0.10  

## NAT en FW2  
- **Outbound NAT:** Automático.  

# Instalación y Configuración del Servidor Proxy (Squid)

## 2.1. Instalación de Squid
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install squid -y
```

# Configuración de Squid y Servidor VPN

## 2.2. Configuración de Squid

### Abre el archivo de configuración:
```bash
sudo nano /etc/squid/squid.conf
```

### Realiza las siguientes modificaciones:
Definir las redes permitidas: Agrega las ACLs para la red interna y la VPN.
```plaintext
acl localnet src 192.168.0.0/24
acl vpnnet src 192.168.1.10/24

http_access allow localnet
http_access deny all
```
Configurar el puerto del Proxy: Asegúrate de que Squid escucha en el puerto 3128.
```plaintext
http_port 3128
```
Habilitar el acceso anónimo (opcional): Si no necesitas autenticación, asegúrate de que no haya reglas de autenticación configuradas.

## Configuración de Bloqueo de Páginas Web

### Crea una lista negra de URLs prohibidas:
Abre un archivo para definir las páginas bloqueadas:
```bash
sudo nano /etc/squid/blacklist.txt
```
Añade los dominios o URLs que deseas bloquear (uno por línea):
```plaintext
facebook.com
youtube.com
twitter.com
```
Guarda y cierra el archivo.

### Configurar Squid para usar la lista negra:
Edita el archivo principal de configuración de Squid:
```bash
sudo nano /etc/squid/squid.conf
```
Añade una ACL (Access Control List) para la lista negra:
```plaintext
acl blocked_sites dstdomain "/etc/squid/blacklist.txt"

http_access deny blocked_sites
```
Coloca esta regla antes de la línea `http_access allow localnet` para que tenga prioridad.

### Reinicia el servicio de Squid:
```bash
sudo systemctl restart squid
```

## Configuración de Restricciones de Tiempo

Puedes permitir o bloquear el acceso en horarios específicos para determinados usuarios o redes.

### Define las horas permitidas o bloqueadas:
Edita el archivo de configuración de Squid:
```bash
sudo nano /etc/squid/squid.conf
```
Define un rango de tiempo usando time ACLs. Por ejemplo:
```plaintext
acl working_hours time MTWHF 08:00-18:00
```
Esto define un rango de tiempo de lunes a viernes (MTWHF) de 08:00 a 18:00.

### Aplica restricciones basadas en tiempo:
Combina la ACL de tiempo con una red o usuarios específicos:
```plaintext
http_access allow localnet working_hours
http_access deny localnet !working_hours
```
Esto permite el acceso solo durante el horario laboral y lo bloquea fuera de este.

### Reinicia el servicio de Squid:
```bash
sudo systemctl restart squid
```

## Combinación de Restricciones de Páginas y Tiempo

Puedes combinar las ACLs de tiempo y páginas bloqueadas para aplicar reglas específicas:
Por ejemplo, bloquear YouTube fuera del horario laboral:
```plaintext
acl youtube dstdomain .youtube.com
acl working_hours time MTWHF 08:00-18:00
http_access deny youtube !working_hours
```

## Verificación de Configuración

### Probar el acceso bloqueado:
Intenta acceder a una de las páginas en la lista negra desde un navegador configurado con el Proxy.
Verifica que el acceso sea rechazado.

### Verificar los logs de Squid:
Monitorea los accesos bloqueados en tiempo real:
```bash
sudo tail -f /var/log/squid/access.log
```

### Reiniciar Squid y aplicar los cambios:
```bash
sudo systemctl restart squid
sudo systemctl enable squid
```

# Configuración del Servidor VPN (OpenVPN en la DMZ)

### Instalar OpenVPN en Ubuntu Server:
```bash
sudo apt update
sudo apt install openvpn easy-rsa -y
```

### Configurar el servidor OpenVPN:
```plaintext
Dirección del servidor: 192.168.1.10
Puerto: 1194
Red del túnel: 10.8.0.0/24
Rutas:
push "route 192.168.0.0 255.255.255.0"
```

### Habilita el reenvío de paquetes en `/etc/sysctl.conf`:
```plaintext
net.ipv4.ip_forward=1
```

### Configura las reglas de NAT en la DMZ:
```bash
sudo iptables -t nat -A POSTROUTING -s 10.8.0.0/24 -o eth0 -j MASQUERADE
```

### Inicia OpenVPN:
```bash
sudo systemctl start openvpn@server
sudo systemctl enable openvpn@server
```

# Configuración del Cliente Interno

Configura el cliente para usar el Proxy:

### En el navegador:
```plaintext
Proxy HTTP: 192.168.0.10
Puerto: 3128
```
Verifica el acceso a Internet desde el cliente.

# Pruebas de Conectividad

## Pruebas del Proxy (Squid)
### a) Verifica conectividad desde el cliente interno (192.168.0.100)
Prueba la navegación:
Accede a un sitio web permitido, como [Google](https://www.google.com).
Resultado esperado: El acceso debe ser exitoso.

### Logs del Proxy:
En el servidor Proxy, verifica los logs de acceso en tiempo real:
```bash
sudo tail -f /var/log/squid/access.log
```
Resultado esperado: Los registros deben mostrar la solicitud del cliente con la IP 192.168.0.100.

### b) Bloqueo de sitios configurados en Squid
Intenta acceder a un sitio bloqueado (por ejemplo, [Facebook](https://www.facebook.com)).
Resultado esperado: El acceso debe ser rechazado.

### Verifica los logs del Proxy:
Busca entradas que muestran el bloqueo del sitio en los logs:
```bash
grep facebook /var/log/squid/access.log
```
Resultado esperado: El log debe registrar el intento de acceso con un código de error (`TCP_DENIED`).

### c) Restricciones de tiempo
Intenta acceder a Internet fuera del horario permitido (según las ACLs configuradas en Squid, por ejemplo, fuera de `08:00-18:00`).
Resultado esperado: El acceso debe ser bloqueado.

### Verifica los logs:
Busca en los registros intentos fuera del horario permitido:
```bash
sudo tail -f /var/log/squid/access.log
```

# Pruebas de Seguridad

### a) Acceso desde la DMZ a la red interna
Desde el servidor VPN (192.168.1.10) en la DMZ, intenta acceder al cliente interno (192.168.0.100):
```bash
ping 192.168.0.100
```
Resultado esperado: El tráfico debe estar bloqueado por el Firewall1 (DMZ → LAN).

### Intenta conectarte por SSH al Proxy (192.168.0.10) desde la DMZ:
```bash
ssh usuario@192.168.0.10
```
Resultado esperado: El acceso debe estar permitido únicamente si se configuró en el Firewall1.

### Verificación del tráfico Proxy
Desde el cliente interno (192.168.0.100), se accede a Internet a través del Proxy.
En el servidor Proxy, verifica los logs para confirmar que todo el tráfico pasa por Squid:
```bash
sudo tail -f /var/log/squid/access.log
```

### Más Pruebas:
#### Traceroute completo:
```bash
traceroute 8.8.8.8
```
Resultado esperado: El tráfico debe pasar por el Proxy (192.168.0.10).

#### Prueba de DNS:
```bash
nslookup www.google.com
```
#### Resultado esperado: La resolución debe ser exitosa.


