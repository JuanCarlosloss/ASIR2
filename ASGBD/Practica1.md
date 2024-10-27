## Empresa 1

| Comando | Valor | Por qué |
|:----------:|:----------:|:----------:|
| innodb_buffer_pool_size   | 60-80% de RAM disponible  | Mejora el rendimiento en acceso a datos, esencial para lectura/escritura rápida.  |
| innodb_log_file_size    | 512MB - 1GB   | Reduce la frecuencia de escritura en disco para alta concurrencia.  |
| max_connections   | 	500-1000  | 	Soporta múltiples conexiones simultáneas sin rechazar usuarios.  |
| query_cache_size  | 0MB   | Mejor desactivado en alta concurrencia para evitar demoras.  |
| table_open_cache  | 5000-10000   | Permite que las tablas se mantengan abiertas, evitando retrasos.   |
| tmp_table_size y max_heap_table_size   | 128MB  | Aumenta el tamaño de tablas temporales en memoria, reduciendo el uso de disco.   |
|  innodb_flush_log_at_trx_commit | 	1   | 	Garantiza la durabilidad de transacciones importantes.  |
| log_bin   |	ON   | Permite replicación y backups incrementales.  |
| slow_query_log y slow_query_log_file   | ON  | Facilita el diagnóstico y optimización de consultas lentas.   |
| long_query_time   | 1-2 segundos   | Detecta consultas que superan el tiempo esperado.   |
| bind_address   | 127.0.0.1 si es local; IP de red si es servidor remoto   | Si la base de datos está en un servidor dedicado, establecer la IP correcta mejora la seguridad limitando accesos.   |
| innodb_file_per_table performance_schema   | ON   | Mejora la gestión y rendimiento de tablas.  |
| performance_schema   | ON   | Habilita monitoreo detallado de rendimiento.   |

## Empresa 2

| Comando | Valor | Por qué |
|:----------:|:----------:|:----------:|
| innodb_buffer_pool_size   | 60-70% de la RAM   | 	Mantiene los datos en memoria para un acceso rápido en esas lecturas masivas.   |
| innodb_log_file_size    | 256-512MB   | 	Adecuado para la mayoría de lecturas y algunas escrituras, manejando carga sin pausas.   |
| max_connections   | 	500-800   | Soporta alta concurrencia de usuarios conectados simultáneamente.  |
| query_cache_size  | 0MB  | Mejor desactivado para evitar retrasos en alta concurrencia.   |
| table_open_cache  | 	5000   | Mantiene abiertas las tablas de usuarios, perfiles y publicaciones, acelerando acceso.   |
| tmp_table_size y max_heap_table_size  | 64MB   | Suficiente para operaciones temporales y consultas en memoria sin pasar a disco.   |
| innodb_flush_log_at_trx_commit   | 1  | Asegura que cualquier cambio en el perfil sea visible en tiempo real, clave para consistencia.   |
| log_bin   | ON  | Activa la replicación y permite backups incrementales para escalabilidad y seguridad.   |
| Slow_query_log   | ON   | Logea consultas lentas para identificar y optimizar consultas pesadas o complejas.   |
| slow_query_log_file   | /var/log/mysql/slow.log  | 	Archivo donde se guardan las consultas lentas, para revisarlas y mejorarlas.   |
| long_query_time   | 1-2 segundos   | 	Detecta consultas más lentas de lo normal, ayudando a afinar el rendimiento.   |
| bind_address   | 127.0.0.1 si es local; IP externa si es acceso remoto   | Configura la seguridad y accesibilidad según dónde esté alojada.  |
| innodb_file_per_table performance_schema   | ON   | 	Mejora el rendimiento y facilita la administración de tablas individuales.   |
| performance_schema   | 	ON   | 	Permite monitoreo avanzado para analizar cargas y optimizar rendimiento en tiempo real.   |

## Empresa 3

| Comando | Valor | Por qué |
|:----------:|:----------:|:----------:|
| innodb_buffer_pool_size   | 60-70% de la RAM  | Maximiza el acceso rápido a datos, esencial para lecturas frecuentes   |
| innodb_log_file_size    | 	256-512MB   | 	Suficiente para lecturas altas y escrituras esporádicas sin demoras.   |
| max_connections   | 500-800   | Soporta alta concurrencia, permitiendo acceso simultáneo de usuarios.   |
| query_cache_size  | 0MB  | 	Mejor desactivado en alta concurrencia para evitar bloqueos en lecturas.   |
| table_open_cache  | 5000   | Mantiene abiertas tablas claves como usuarios y publicaciones para mejorar rendimiento.  |
| tmp_table_size   | 	64MB   | Soporta consultas temporales en memoria, mejorando el rendimiento en lecturas complejas.  |
| max_heap_table_size   | 	64MB   | Igual que tmp_table_size para soportar operaciones temporales sin usar disco.   |
| innodb_flush_log_at_trx_commit   | 1   | Asegura que los cambios sean visibles en tiempo real, ideal para consistencia en datos de perfiles.  |
| log_bin   | ON   | 	Permite replicación y backups incrementales, útil para escalabilidad.   |
| Slow_query_log   | ON   | Registra consultas lentas para optimizar las que puedan ralentizar la red social.   |
| slow_query_log_file   | /var/log/mysql/slow.log   | Especifica el archivo para guardar consultas lentas, útil en análisis de rendimiento.   |
| long_query_time   | 1-2 segundos   | Identifica consultas que excedan tiempos óptimos, facilitando su optimización.  |
| bind_address   | 127.0.0.1 si es local; IP pública si es acceso externo  | Ajusta la seguridad y accesibilidad según el entorno.   |
| innodb_file_per_table performance_schema   | ON  | Facilita el manejo de tablas y optimización de rendimiento en perfiles y publicaciones.  |
| performance_schema   | 	ON   | 	Monitoreo detallado para identificar consultas lentas o problemas de carga.   |
