# Zeus TFG

## Requisitos

1. Docker
2. PHP
3. MySQLWorkbench (Opcional)

## Como ejecutar

### Base de datos

1. Abrir terminal y lanzar para lanzar el docker: `docker-compose up -d`
2. Lanzar para recrear la base de datos (si no se ha creado ya, o se desea actualizar las tablas):
`docker-compose exec -T mysql mysql -u root zeus_tfg < sql/zeus_tfg.sql`
3. Para restaurar la conexion con docker: `docker restart docker-desktop`
 
### Web

1. Lanzar en la terminal: `php -S localhost:8000`

### Exportar base de datos

1. Abrir la terminal y borrar el archivo antiguo ubicado en la carpeta sql: `rm sql/zeus_tfg.sql`
2. Exportar la base de datos actualizada a la carpeta sql con: `docker-compose exec -T mysql mysqldump -u root zeus_tfg > sql/zeus_tfg.sql`

> Nota:
> Se debe tener en cuenta que en este proyecto mysql esta expuesto en el puerto 3307.
