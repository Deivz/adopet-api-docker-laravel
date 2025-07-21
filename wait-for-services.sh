#!/bin/sh

echo "⏳ Aguardando banco de dados em $DB_HOST:$DB_PORT..."

# Espera até que a porta do banco esteja aceitando conexões
while ! nc -z -w 1 "$DB_HOST" "$DB_PORT"; do
  sleep 1
done

echo "✅ Banco de dados disponível, iniciando Laravel..."

# Roda as migrations se desejar
# php artisan migrate --force || true

# Inicia o servidor Laravel
php artisan serve --host=0.0.0.0 --port=8000