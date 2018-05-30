# GameOfLIfe

## Uwagi ogólne

- Główne klasy aplikacji znajdują się  w katalogu ./src

- Szkielet REST-owy zbudowany w oparciu o SlimFramework (https://www.slimframework.com/)

- Konfiguracja aplikacji znajduje się w pliku ./config.yml

- Stan gry (generacja komórek) zapisywany jest do pliku ./tmp/game.json

## Instalacja
Aby zainstalować aplikację, w linii poleceń należy wpisać:
```bash
$ composer install
```
## REST API

Dostępne są 2 metody:

- `/seed [POST]` służy do ustawiania stanu początkowego gry (tzw. szablonu)
Metoda przyjmuje 1 parametr: `template` w którym przekazywany jest szablon w postaci dwuwymiarowej tablicy w formacie JSON
- `/tick [GET]` służy do pobierania kolejnego stanu gry

### Przykłady
1. Exploder
Szablon w postaci dwuwymiarowej tablicy PHP przedstawia się następująco:
```php
$data = [
[1,1,1],
[1,0,1],
[1,0,1],
[1,0,1],
[1,1,1]
];
```
więc w formacie JSON będzie wyglądać następująco:
```json
[[1,1,1],[1,0,1],[1,0,1],[1,0,1],[1,1,1]]
```
Wynikiem działania obu metod API jest wyrenderowana siatka gry.
