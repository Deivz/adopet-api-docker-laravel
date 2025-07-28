#!/bin/sh

echo "⏳ Aguardando banco de dados em $DB_HOST:$DB_PORT..."

while ! nc -z -w 1 "$DB_HOST" "$DB_PORT"; do
  sleep 1
done

echo "✅ Banco de dados disponível, iniciando Laravel..."

# Instala dependências se ainda não existem
if [ ! -d "vendor" ]; then
  echo "📦 Instalando dependências do Composer..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
else
  echo "📦 Dependências já instaladas."
fi

# Gera a chave de criptografia se necessário
if [ ! -f ".env" ]; then
  echo "⚠️  Arquivo .env não encontrado, copiando .env.example..."
  cp .env.example .env
fi

if ! grep -q "^APP_KEY=" .env || [ -z "$(grep '^APP_KEY=' .env | cut -d '=' -f2)" ]; then
  echo "🔐 Gerando APP_KEY..."
  php artisan key:generate --ansi
else
  echo "🔐 APP_KEY já definido."
fi

# Roda as migrations se desejar
php artisan migrate --force || true

# Inicia o servidor Laravel
php artisan serve --host=0.0.0.0 --port=8000