# PhpApp

Prosta aplikacja PHP uruchamiana w Dockerze, przygotowana jako projekt semestralny. Repozytorium zawiera gotowe srodowisko developerskie, skrypty start/stop oraz podstawowy zestaw narzedzi jakosciowych: PHPStan, PHP CS Fixer, PHPUnit i CI.

Adres aplikacji po uruchomieniu lokalnym:

```text
http://localhost:8095
```

## Wymagania

- Docker
- Docker Compose
- Bash
- `curl`
- `flock`

## Szybki start

Sklonuj repozytorium i uruchom projekt z katalogu glownego:

```bash
git clone https://github.com/Baartek57548/PhpApp.git
cd PhpApp
./start.sh
```

Zatrzymanie projektu:

```bash
./stop.sh
```

Skrypt `start.sh`:

- buduje obrazy,
- uruchamia kontenery,
- wykonuje `composer install`,
- czeka, az aplikacja zacznie odpowiadac.

Domyslny port to `8095`. Mozesz go zmienic w pliku `docker-php/.env`. Jesli plik nie istnieje, skrypt utworzy go automatycznie na podstawie `docker-php/.env.example`.

## Struktura projektu

- `docker-php/` - konfiguracja Dockera i kod aplikacji
- `docker-php/projects/inf-backend/` - glowny kod aplikacji PHP
- `scripts/` - skrypty pomocnicze uruchamiane przez `start.sh` i `stop.sh`
- `materials/` - materialy referencyjne od prowadzacego
- `.github/workflows/` - konfiguracja CI

## Uruchamianie reczne

Jesli chcesz uruchomic projekt bez skryptu:

```bash
cd docker-php
docker compose up -d --build
docker compose exec -T php_8_4 composer install
```

Po starcie otworz w przegladarce:

```text
http://localhost:8095
```

## Przydatne komendy

Podglad logow:

```bash
cd docker-php
docker compose logs -f
```

Wejscie do kontenera PHP:

```bash
cd docker-php
docker compose exec php_8_4 bash
```

## Narzedzia developerskie

Z katalogu glownego repozytorium:

```bash
cd docker-php && docker compose exec -T php_8_4 composer analyse
cd docker-php && docker compose exec -T php_8_4 composer cs:check
cd docker-php && docker compose exec -T php_8_4 composer cs:fix
cd docker-php && docker compose exec -T php_8_4 composer test
```

Jesli jestes juz w katalogu `docker-php`, uruchamiaj bez dodatkowego `cd`:

```bash
docker compose exec -T php_8_4 composer analyse
docker compose exec -T php_8_4 composer cs:check
docker compose exec -T php_8_4 composer cs:fix
docker compose exec -T php_8_4 composer test
```

Znaczenie komend:

- `composer analyse` - analiza statyczna kodu przez PHPStan
- `composer cs:check` - sprawdzenie zgodnosci stylu kodu
- `composer cs:fix` - automatyczne poprawienie stylu kodu
- `composer test` - uruchomienie testow PHPUnit

## CI

W repozytorium jest przygotowany workflow GitHub Actions w `.github/workflows/ci.yml`. Pipeline uruchamia:

- `composer validate --strict`
- `PHPStan`
- `PHP CS Fixer` w trybie sprawdzania
- `PHPUnit`

## Rozwiazywanie problemow

Jesli `./start.sh` zwraca komunikat `Nie ma takiego pliku ani katalogu`, upewnij sie, ze jestes w katalogu glowym repozytorium albo uruchamiasz skrypt przez pelna sciezke.

Poprawnie:

```bash
cd PhpApp
./start.sh
```

albo:

```bash
/sciezka/do/PhpApp/start.sh
```
