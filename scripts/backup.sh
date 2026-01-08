#!/bin/bash
# -------------------------------------------------------------------------
# ASIR AUTOMATION: LAMP BACKUP SCRIPT
# Autor: Jorge Olcina
# Descripción: Respalda Base de Datos + Web y rota archivos antiguos.
# -------------------------------------------------------------------------

# 1. CONFIGURACIÓN (¡Edita esto!)
# -------------------------------------------------------------------------
BACKUP_DIR="/home/administrador/backups_blog"  # Donde se guardan los zip
WEB_DIR="/var/www/html"                        # La carpeta de tu web
DB_USER="TuUsuario"                                 # Tu usuario de MariaDB
DB_PASS="CONTRASEÑA"                   # ¡Pon tu contraseña real!
DB_NAME="NombreBD"                            # Nombre de tu base de datos
DATE=$(date +%Y-%m-%d_%H%M)                    # Fecha para el nombre del archivo
RETENTION=7                                    # Días que guardamos los backups

# 2. PREPARACIÓN
# -------------------------------------------------------------------------
mkdir -p $BACKUP_DIR
echo "Starting backup process: $DATE"

# 3. VOLCADO DE BASE DE DATOS (SQL)
# -------------------------------------------------------------------------
echo ">> Exporting Database..."
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/db_backup_$DATE.sql

if [ $? -eq 0 ]; then
    echo "   [OK] Database exported."
else
    echo "   [ERROR] Database export failed!"
    exit 1
fi

# 4. COMPRESIÓN DE ARCHIVOS (TAR.GZ)
# -------------------------------------------------------------------------
echo ">> Compressing Web Files & SQL..."
# Empaquetamos la web y el SQL que acabamos de generar
tar -czf $BACKUP_DIR/full_backup_$DATE.tar.gz $WEB_DIR $BACKUP_DIR/db_backup_$DATE.sql

# Borramos el SQL suelto porque ya está dentro del zip
rm $BACKUP_DIR/db_backup_$DATE.sql

if [ $? -eq 0 ]; then
    echo "   [OK] Backup created: full_backup_$DATE.tar.gz"
else
    echo "   [ERROR] Compression failed!"
    exit 1
fi

# 5. ROTACIÓN (Limpieza de antiguos)
# -------------------------------------------------------------------------
echo ">> Deleting backups older than $RETENTION days..."
find $BACKUP_DIR -type f -name "*.tar.gz" -mtime +$RETENTION -delete

echo "--------------------------------------"
echo "BACKUP COMPLETED SUCCESSFULLY!"
echo "Size: $(du -h $BACKUP_DIR/full_backup_$DATE.tar.gz | cut -f1)"
echo "--------------------------------------"
