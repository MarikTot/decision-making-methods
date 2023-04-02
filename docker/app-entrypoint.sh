#!/usr/bin/env sh

set -e

APP_DIR="${APP_DIR:-/app}";
STARTUP_DELAY="${STARTUP_DELAY:-0}";

if [ "$STARTUP_DELAY" -gt 0 ]; then
  echo "[INFO] Wait $STARTUP_DELAY seconds before start ..";
  sleep "$STARTUP_DELAY";
fi;

if ! php "${APP_DIR}/bin/console" --version > /dev/null 2>&1; then
  (>&2 echo "[WARNING] Application probably broken down!");
fi;

echo '[INFO] Wait for services ready state';
counter=0;
try_limit=60;

while :; do
  counter=$(($counter + 1));

  if [ $counter -gt $try_limit ]; then
    echo '[ERROR] Errors limit reached'; sleep 10; exit 1;
  fi;

  # Call any commands here for make sure that all dependent services is up and ready
  php "${APP_DIR}/bin/console" -n d:m:m && break;

  echo '[INFO] Required for application starting services is not ready. Wait for 2 seconds ..'; sleep 2;
done;

exec "$@";
