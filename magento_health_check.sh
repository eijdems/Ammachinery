#!/bin/bash

# CONFIGURATION

MAGENTO_ROOT="/home/cloudpanel/htdocs/www.global-equipment.com"
LOG_DIR="$MAGENTO_ROOT/health_logs"
DATESTAMP=$(/bin/date +'%Y-%m-%d_%H-%M')
LOG_FILE="$LOG_DIR/health_$DATESTAMP.log"

# Ensure log directory exists
/bin/mkdir -p "$LOG_DIR"

# Start Logging
{
echo "===== Magento Health Check ($DATESTAMP) ====="
/bin/hostnamectl | /bin/grep "Static hostname"

echo -e "\n[Uptime and Load]"
/usr/bin/uptime

echo -e "\n[Memory Usage]"
/usr/bin/free -m

echo -e "\n[Disk Usage]"
/bin/df -h

echo -e "\n[Top Processes (Top 10)]"
/usr/bin/ps -eo pid,ppid,cmd,%mem,%cpu --sort=-%mem | /usr/bin/head

echo -e "\n[Service Status (Active/Inactive)]"
for service in nginx apache2 mysql php8.2-fpm redis varnish elasticsearch rabbitmq-server; do
    if /bin/systemctl list-units --type=service | /bin/grep -q $service; then
        echo -n "$service: "
        /bin/systemctl is-active --quiet $service && echo "active" || echo "inactive"
    fi
done

echo -e "\n[Magento Logs]"
if [ -d "$MAGENTO_ROOT/var/log" ]; then
    echo -e "\nLast 20 lines of system.log:"
    /usr/bin/tail -n 20 "$MAGENTO_ROOT/var/log/system.log" 2>/dev/null || echo "system.log not found"

    echo -e "\nLast 20 lines of exception.log:"
    /usr/bin/tail -n 20 "$MAGENTO_ROOT/var/log/exception.log" 2>/dev/null || echo "exception.log not found"
else
    echo "Magento var/log directory not found."
fi

echo -e "\n[Web Server Logs]"
[ -f /var/log/nginx/error.log ] && /usr/bin/tail -n 20 /var/log/nginx/error.log
[ -f /var/log/apache2/error.log ] && /usr/bin/tail -n 20 /var/log/apache2/error.log

echo -e "\n[Security Logs (auth.log)]"
[ -f /var/log/auth.log ] && /usr/bin/tail -n 20 /var/log/auth.log

echo -e "\n===== End of Magento Health Report ====="

} > "$LOG_FILE"

