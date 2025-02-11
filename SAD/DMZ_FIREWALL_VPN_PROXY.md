# Esquema de la Red

| Dispositivo | Interfaz | Red / IP |
|-------------|----------|-----------|
| **FW1 (pfSense Externo)** | WAN | 192.168.100.0/24 (probando en un entorno NAT) |
| | DMZ | 192.168.1.1/24 |
| **FW2 (pfSense Interno)** | DMZ | 192.168.1.2/24 |
| | LAN | 192.168.0.1/24 |
| **Servidor VPN** | DMZ | 192.168.1.10/24 |
| **Servidor Proxy** | LAN | 192.168.0.10/24 |
| **Cliente Interno** | LAN | 192.168.0.100/24 |

# Configuración de VirtualBox para cada máquina

## 1. Firewall Externo (FW1 - pfSense)

### Configuración General  
- Nombre de la máquina: FW1 (pfSense)  
- RAM: 2 GB  
- CPU: 1 vCPU  
- Disco duro: 8 GB (Dinámicamente asignado)  
- Sistema operativo: pfSense ISO, FreeBSD 64-bit (descargar ISO de la última versión del sitio oficial).
- ![image](https://github.com/user-attachments/assets/25dbab62-dd60-43f0-9e40-c7323448e4a8)

### Configuración de Red  
- **Adaptador 1 (WAN):**  
  - Tipo: Red NAT  
  - Propósito: Conexión a Internet.  
- **Adaptador 2 (DMZ):**  
  - Tipo: Red Interna  
  - Nombre de la red interna: DMZ
- ![image](https://github.com/user-attachments/assets/abbaca18-3acf-4790-abd6-06757b3787fd)

## 2. Firewall Interno (FW2 - pfSense)

### Configuración General  
- Nombre de la máquina: FW2 (pfSense)  
- RAM: 2 GB  
- CPU: 1 vCPU  
- Disco duro: 8 GB (Dinámicamente asignado)  
- Sistema operativo: pfSense ISO, FreeBSD 64-bit (descargar ISO de la última versión del sitio oficial).
-  ![image](https://github.com/user-attachments/assets/a4894b0a-af21-45dc-9f6f-55aa77c3ffe5)


### Configuración de Red  
- **Adaptador 1 (DMZ):** Red Interna (Nombre: DMZ)  
- **Adaptador 2 (LAN):** Red Interna (Nombre: LAN)  
- ![image](https://github.com/user-attachments/assets/716afbd5-6f74-4de3-9fa5-eda1b5f0604e)


## 3. Servidor VPN (Ubuntu Server o similar)

### Configuración General  
- Nombre de la máquina: Servidor VPN  
- RAM: 2 GB  
- CPU: 1 vCPU  
- Disco duro: 10 GB (Dinámicamente asignado)  
- Sistema operativo: Ubuntu Server 22.04 ISO o similar.  
- ![image](https://github.com/user-attachments/assets/925f74bf-8206-4f65-8adc-87287ed0fe14)


### Configuración de Red  
- **Adaptador 1 (DMZ):** Red Interna (Nombre: DMZ)  

## 4. Servidor Proxy (Squid en Ubuntu Server o similar)

### Configuración General  
- Nombre de la máquina: Servidor Proxy  
- RAM: 2 GB  
- CPU: 1 vCPU  
- Disco duro: 10 GB (Dinámicamente asignado)  
- Sistema operativo: Ubuntu Server 22.04 ISO. O similar.  
- ![image](https://github.com/user-attachments/assets/29b9d058-1a98-44ad-abbe-843519e7aaca)


### Configuración de Red  
- **Adaptador 1 (LAN):** Red Interna (Nombre: LAN)  

## 5. Cliente Interno

### Configuración General  
- Nombre de la máquina: Cliente Interno  
- RAM: 1 GB  
- CPU: 1 vCPU  
- Disco duro: 8 GB (Dinámicamente asignado)  
- Sistema operativo: Windows 7/10/11.  
- 
### Configuración de Red  
- **Adaptador 1 (LAN):** Red Interna (Nombre: LAN)  
- ![image](https://github.com/user-attachments/assets/d7fdb607-6c0a-4536-94c1-becd3c8cd472)

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
- ![image](https://github.com/user-attachments/assets/ae01b196-8b3d-450c-9243-9b80b5684a1b)

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

- ![image](https://github.com/user-attachments/assets/63499f60-eec0-42a6-a488-968b19082a10)

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

- ![image](https://github.com/user-attachments/assets/2e81e426-3db8-4112-874b-0e3462a220fd)


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
- ![image](https://github.com/user-attachments/assets/5a4d1f25-712c-4106-935f-3703c21d3cd2)


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

- ![image](https://github.com/user-attachments/assets/df3f668b-47e7-4f1a-8110-d8890e99b57a)


# Configuración del Servidor VPN (OpenVPN en la DMZ)

### Instalar OpenVPN en Ubuntu Server:
```bash
sudo apt update
sudo apt install openvpn easy-rsa -y
```
- ![image](https://github.com/user-attachments/assets/d282b21b-5a05-47db-9387-bddf38b0bf6c)


### Configurar el servidor OpenVPN:
```plaintext
Dirección del servidor: 192.168.1.10
Puerto: 1194
Red del túnel: 10.8.0.0/24
Rutas:
push "route 192.168.0.0 255.255.255.0"
```
- ![image](https://github.com/user-attachments/assets/355f635f-d91c-439e-a5a2-3c0bd4f22fdf)


### Habilita el reenvío de paquetes en `/etc/sysctl.conf`:
```plaintext
net.ipv4.ip_forward=1
```
- ![image](https://github.com/user-attachments/assets/c31bc27f-84af-49c5-98e7-5256f59c91dc)


### Configura las reglas de NAT en la DMZ:
```bash
sudo iptables -t nat -A POSTROUTING -s 10.8.0.0/24 -o eth0 -j MASQUERADE
```
- ![image](https://github.com/user-attachments/assets/7f703136-f218-407c-8afa-528ec7995230)


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

- ![image](https://github.com/user-attachments/assets/d1c632f9-8b50-41bc-9d2d-5195ea1ab62f)


### Logs del Proxy:
En el servidor Proxy, verifica los logs de acceso en tiempo real:
```bash
sudo tail -f /var/log/squid/access.log
```
Resultado esperado: Los registros deben mostrar la solicitud del cliente con la IP 192.168.0.100.

- ![image](https://github.com/user-attachments/assets/a6e4c672-2578-4865-828f-3f1a95bfc3ea)


### b) Bloqueo de sitios configurados en Squid
Intenta acceder a un sitio bloqueado (por ejemplo, [Facebook](https://www.facebook.com)).
Resultado esperado: El acceso debe ser rechazado.

- ![image](https://github.com/user-attachments/assets/bf711381-6572-4be0-8172-7d51569cbe13)


### Verifica los logs del Proxy:
Busca entradas que muestran el bloqueo del sitio en los logs:
```bash
grep facebook /var/log/squid/access.log
```
Resultado esperado: El log debe registrar el intento de acceso con un código de error (`TCP_DENIED`).

- ![image](https://github.com/user-attachments/assets/73363bcd-8c9a-4513-8769-d761c5899150)


### c) Restricciones de tiempo
Intenta acceder a Internet fuera del horario permitido (según las ACLs configuradas en Squid, por ejemplo, fuera de `08:00-18:00`).
Resultado esperado: El acceso debe ser bloqueado.

- ![image](https://github.com/user-attachments/assets/b4b668e7-fe7a-455d-b516-7966a99943f2)


### Verifica los logs:
Busca en los registros intentos fuera del horario permitido:
```bash
sudo tail -f /var/log/squid/access.log
```
- ![image](https://github.com/user-attachments/assets/7143905f-b927-4363-b8b8-02e907ae3d94)


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


