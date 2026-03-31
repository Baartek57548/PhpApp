#!/usr/bin/env bash

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
COMPOSE_DIR="$ROOT_DIR/docker-php"

if ! command -v docker >/dev/null 2>&1; then
    echo "Blad: Docker nie jest zainstalowany albo nie jest dostepny w PATH."
    exit 1
fi

if ! docker compose version >/dev/null 2>&1; then
    echo "Blad: plugin Docker Compose nie jest dostepny."
    exit 1
fi

echo "Zatrzymywanie i usuwanie kontenerow projektu..."
docker compose -f "$COMPOSE_DIR/docker-compose.yml" --project-directory "$COMPOSE_DIR" down --remove-orphans

echo "Projekt zostal zatrzymany."
