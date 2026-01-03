#!/bin/bash

# Configuración
DESTINO="~/backups"
FECHA=$(date +%Y-%m-%d)
DB_NOMBRE="cosmos_blog"
WEB_DIR="~/proyectos/Mi-blog-ASIR"

# Crear carpeta de destino si no existe
mkdir -p $DESTINO

# 1. Backup de la Base de Datos
mysqldump -u root $DB_NOMBRE > $DESTINO/db_backup_$FECHA.sql

# 2. Backup de los archivos (comprimido)
tar -czf $DESTINO/files_backup_$FECHA.tar.gz $WEB_DIR

# 3. Limpiar backups antiguos (borra los de más de 7 días)
find $DESTINO -type f -mtime +7 -delete

echo "Backup completado el $FECHA"
