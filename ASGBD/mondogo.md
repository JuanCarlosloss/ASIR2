# 1. Instala en Docker la última versión Mongo DB oficial.
- Para instalar mongodb hay que descargar el repositorio de mongodb en docker con el siguiente comando
```bash
docker pull mongo
```
- este se descargara y para verificar que se instaló usaremos este comando
```bash
docker images
```
- 
# 2. Explica para MongoDB los siguientes puntos:
### 1 Modelo de datos basado en documentos
- MongoDB utiliza un modelo de datos basado en documentos en lugar de tablas y filas como en bases de datos relacionales. Los datos se almacenan como documentos JSON
### 2 NoSQL
MongoDB es una base de datos NoSQL, lo que significa que no requiere un esquema fijo. Está diseñada para:
- Trabajar con datos semiestructurados y no estructurados.
- Escalabilidad y rendimiento con grandes volúmenes de datos.
- Adopción de estructuras más dinámicas frente al enfoque rígido de las bases de datos relacionales.
### 3 Escalabilidad horizontal
- MongoDB admite escalabilidad horizontal mediante particionamiento. Se divide una colección grande en fragmentos distribuidos en múltiples servidores, manteniendo la alta disponibilidad y la eficiencia.
### 4 Consultas
- MongoDB permite realizar consultas complejas en documentos a través de un lenguaje basado en JSON.
 ```javascript
db.coleccion.find({ "edad": { $gt: 25 } })
```
### 5 Alta disponibilidad
- MongoDB garantiza alta disponibilidad mediante réplicas. Un Replica Set incluye:
- Un nodo primario para lecturas y escrituras.
- Uno o más nodos secundarios como respaldo automático.
### 6 Índices
- Los índices en MongoDB son claves para mejorar el rendimiento de las consultas. Puedes crear índices en campos específicos de los documentos.
```javascript
db.coleccion.createIndex({ "nombre": 1 })
```
### 7 Agregaciones
- El marco de agregación de MongoDB permite realizar transformaciones y cálculos complejos en los datos.
```javascript
db.coleccion.aggregate([
  { $group: { _id: "$direccion.ciudad", total: { $sum: 1 } } }
])
```
Resumen con tus palabras de lo que te parece más interesante
- **Flexibilidad del modelo de documentos:** Es ideal para aplicaciones modernas que manejan datos dinámicos, como JSON.
- **Escalabilidad horizontal:** Su diseño para particionar datos en varios nodos es eficiente para manejar sistemas con alta carga.
- **Agregaciones:** Ofrecen una forma poderosa de procesar grandes volúmenes de datos sin trasladarlos a la aplicación.
- **Alta disponibilidad:** Las réplicas automáticas aseguran la continuidad incluso durante fallas.
- **NoSQL:** Permite adaptarse a las necesidades reales de datos en lugar de ajustarse a un esquema rígido.
