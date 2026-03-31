# tokApp

Gotowa do uruchomienia wersja aplikacji znajduje sie w katalogu `docker-php/projects/inf-backend`.

## Struktura projektu

- `docker-php/` - dzialajace srodowisko Docker i kod aplikacji.
- `scripts/` - skrypty pomocnicze do uruchamiania projektu.
- `materials/` - oryginalne materialy od wykladowcy, zachowane referencyjnie.
- `start.sh` - wygodny launcher z katalogu glownego projektu.

## Uruchamianie

Najwygodniej uruchomic wszystko jednym poleceniem z katalogu glownego projektu:

```bash
cd /home/bartek/Dokumenty/tokApp
./start.sh
```

Mozesz tez odpalic skrypt z dowolnego katalogu, podajac pelna sciezke:

```bash
/home/bartek/Dokumenty/tokApp/start.sh
```

Skrypt:

- buduje kontenery,
- uruchamia Docker Compose,
- wykonuje `composer install`,
- czeka, az aplikacja zacznie odpowiadac pod wskazanym portem.

Domyslny port to `8095`. Mozesz go zmienic w pliku `docker-php/.env` lub skopiowac wzor z `docker-php/.env.example`.

Zatrzymanie projektu:

```bash
cd /home/bartek/Dokumenty/tokApp
./stop.sh
```

Lub z dowolnego katalogu:

```bash
/home/bartek/Dokumenty/tokApp/stop.sh
```

## Dlaczego na screenie byl blad?

Polecenie `./start.sh` uruchamia plik `start.sh` z aktualnego katalogu. Na screenie byles w katalogu domowym `~`, a nie w `/home/bartek/Dokumenty/tokApp`, dlatego Bash zwrocil komunikat `Nie ma takiego pliku ani katalogu`.

## Uruchamianie reczne

1. Przejdz do katalogu z Docker Compose:

   ```bash
   cd docker-php
   ```

2. Zbuduj i uruchom kontenery:

   ```bash
   docker compose up -d --build
   ```

3. Wygeneruj autoload Composera:

   ```bash
   docker compose exec -T php_8_4 composer install
   ```

4. Otworz aplikacje w przegladarce:

   ```text
   http://localhost:8095
   ```

## Przydatne komendy

Zatrzymanie srodowiska:

```bash
./stop.sh
```

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

Uruchomienie testow:

```bash
cd docker-php && docker compose exec -T php_8_4 composer test
```

Uruchomienie analizy statycznej PHPStan:

```bash
cd docker-php && docker compose exec -T php_8_4 composer analyse
```

Sprawdzenie stylu kodu:

```bash
cd docker-php && docker compose exec -T php_8_4 composer cs:check
```

Automatyczne poprawienie stylu kodu:

```bash
cd docker-php && docker compose exec -T php_8_4 composer cs:fix
```

Jesli jestes juz w katalogu `docker-php`, uruchamiasz te komendy bez dodatkowego `cd`:

```bash
docker compose exec -T php_8_4 composer analyse
docker compose exec -T php_8_4 composer cs:check
docker compose exec -T php_8_4 composer cs:fix
docker compose exec -T php_8_4 composer test
```

W repo jest tez przygotowany workflow CI w `.github/workflows/ci.yml`, ktory uruchamia:

- `composer validate`
- `PHPStan`
- `PHP CS Fixer` w trybie sprawdzania
- `PHPUnit`

## GitHub workflow

Najbardziej profesjonalny uklad dla tego projektu jest taki:

- repo `Baartek57548/JavaScript` zostaje jako archiwum projektow z poprzedniego semestru,
- dla tej aplikacji tworzysz osobne nowe repozytorium,
- nie mieszasz starej historii JavaScript z nowym projektem PHP.

### Release starego repo

Najprosciej zrobic to przez GitHub:

1. Wejdz na `https://github.com/Baartek57548/JavaScript`.
2. Otworz zakladke `Releases`.
3. Wybierz `Draft a new release`.
4. Utworz nowy tag, na przyklad `v2025-sem-final`, wskazujacy na branche `main`.
5. Ustaw tytul, na przyklad `Semestr poprzedni - projekty JavaScript`.
6. Dodaj krotki opis i opublikuj release.

### Start nowego repo dla tej aplikacji

Po utworzeniu pustego repo na GitHubie mozesz podpiac ten projekt tak:

```bash
cd /home/bartek/Dokumenty/tokApp
git init -b main
git add .
git commit -m "Initial commit: PHP app with Docker, tests and CI"
git remote add origin https://github.com/TWOJ_LOGIN/TWOJE_NOWE_REPO.git
git push -u origin main
```

Przy tworzeniu nowego repo na GitHubie najlepiej wybrac puste repo bez `README`, `.gitignore` i licencji, zeby pierwszy push przeszedl bez konfliktow.
