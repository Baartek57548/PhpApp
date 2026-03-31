#!/usr/bin/env bash

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
COMPOSE_DIR="$ROOT_DIR/docker-php"
ENV_FILE="$COMPOSE_DIR/.env"
ENV_EXAMPLE_FILE="$COMPOSE_DIR/.env.example"
LOCK_DIR="$ROOT_DIR/.run"
LOCK_FILE="$LOCK_DIR/start.lock"
APP_URL=""

if ! command -v docker >/dev/null 2>&1; then
    echo "Blad: Docker nie jest zainstalowany albo nie jest dostepny w PATH."
    exit 1
fi

if ! command -v curl >/dev/null 2>&1; then
    echo "Blad: curl nie jest zainstalowany albo nie jest dostepny w PATH."
    exit 1
fi

if ! command -v flock >/dev/null 2>&1; then
    echo "Blad: flock nie jest zainstalowany albo nie jest dostepny w PATH."
    exit 1
fi

mkdir -p "$LOCK_DIR"
exec 9>"$LOCK_FILE"

if ! flock -n 9; then
    echo "Blad: inna instancja start.sh juz pracuje. Poczekaj chwile i sprobuj ponownie."
    exit 1
fi

if ! docker info >/dev/null 2>&1; then
    echo "Blad: Docker nie jest uruchomiony."
    exit 1
fi

if ! docker compose version >/dev/null 2>&1; then
    echo "Blad: plugin Docker Compose nie jest dostepny."
    exit 1
fi

if [ ! -f "$ENV_FILE" ] && [ -f "$ENV_EXAMPLE_FILE" ]; then
    cp "$ENV_EXAMPLE_FILE" "$ENV_FILE"
    echo "Utworzono plik konfiguracyjny $ENV_FILE na podstawie wzoru."
fi

if [ -f "$ENV_FILE" ]; then
    APP_PORT="$(grep -E '^APP_PORT=' "$ENV_FILE" | tail -n 1 | cut -d '=' -f 2- || true)"
fi

APP_PORT="${APP_PORT:-8095}"
APP_URL="http://localhost:${APP_PORT}"

echo "Budowanie i uruchamianie kontenerow..."
docker compose -f "$COMPOSE_DIR/docker-compose.yml" --project-directory "$COMPOSE_DIR" up -d --build

echo "Instalowanie zaleznosci Composera..."
docker compose -f "$COMPOSE_DIR/docker-compose.yml" --project-directory "$COMPOSE_DIR" exec -T php_8_4 composer install --no-interaction

echo "Czekanie na odpowiedz aplikacji pod ${APP_URL}..."
for attempt in $(seq 1 30); do
    if curl -fsS "$APP_URL" >/dev/null 2>&1; then
        echo
        echo "Projekt jest gotowy."
        echo "Adres aplikacji: ${APP_URL}"
        exit 0
    fi

    printf "."
    sleep 2
done

echo
echo "Aplikacja nie odpowiedziala na czas. Sprawdz logi poleceniem:"
echo "docker compose -f \"$COMPOSE_DIR/docker-compose.yml\" --project-directory \"$COMPOSE_DIR\" logs -f"
exit 1
