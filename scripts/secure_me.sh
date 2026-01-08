#!/bin/bash

# --- Script de Hardening Inicial para Ubuntu Server ---
# Autor: Jorge Olcina (yoryo.es)

echo "--- Iniciando proceso de seguridad (Hardening) ---"

# 1. Actualización de repositorios
sudo apt update && sudo apt upgrade -y

# 2. Configuración del Firewall (UFW)
echo "[+] Configurando Firewall..."
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow 80/tcp    # HTTP
sudo ufw allow 443/tcp   # HTTPS
sudo ufw allow 22/tcp    # SSH
sudo ufw --force enable

# 3. Protección contra Fuerza Bruta (Fail2Ban)
echo "[+] Instalando Fail2Ban..."
sudo apt install fail2ban -y
sudo systemctl enable fail2ban
sudo systemctl start fail2ban

# 4. Limpieza de paquetes innecesarios
sudo apt autoremove -y

echo "--- Servidor asegurado correctamente ---"
