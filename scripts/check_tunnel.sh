#!/bin/bash

# Comprobar si el servicio cloudflared está corriendo
if ! systemctl is-active --quiet cloudflared; then
    echo "$(date): El túnel está caído. Reiniciando..." >> ~/logs/tunnel_error.log
    sudo systemctl restart cloudflared
else
    echo "El túnel está operativo."
fi
