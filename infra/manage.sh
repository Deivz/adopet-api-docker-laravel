#!/bin/bash

if [ "$#" -lt 3 ]; then
  echo "Uso: $0 <start|stop> <profile-do-banco> <servico-do-app>"
  echo "Exemplo: $0 start pg-dev adopet-dev"
  echo "         $0 stop pg-dev adopet-dev"
  exit 1
fi

ACTION=$1
DB_PROFILE=$2
APP_SERVICE=$3

case "$ACTION" in
  start)
    echo "🟡 Iniciando banco com profile: $DB_PROFILE..."
    docker compose -f docker-compose.db.yml --profile "$DB_PROFILE" up -d --build

    echo "⏳ Aguardando banco ficar disponível..."
    DB_HOST=localhost
    DB_PORT=5432

    while ! nc -z "$DB_HOST" "$DB_PORT"; do
      sleep 1
    done

    echo "✅ Banco disponível!"

    echo "🟢 Iniciando app $APP_SERVICE..."
    docker compose --env-file ../.env -f ../docker-compose.app.yml up --build "$APP_SERVICE"
    ;;

  stop)
    echo "🔴 Parando app $APP_SERVICE..."
    docker compose -f docker-compose.app.yml down "$APP_SERVICE"

    echo "🔴 Parando banco profile $DB_PROFILE..."
    docker compose -f docker-compose.db.yml --profile "$DB_PROFILE" down
    ;;

  *)
    echo "Ação inválida: use start ou stop"
    exit 1
    ;;
esac