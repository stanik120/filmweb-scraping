# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]


## [0.0.2] - 2020-11-23
### Dodane
- Do tablicy $director funkcja zapisuje reżyserów.
- Do tablicy $creator funkcja zapisuje scenarzystów.
- Do tablicy $genre funkcja zapisuje gatunki do jakich należy film.
- Do tablicy $production funkcja zapisuje kraje które brały udział w produkcji.
- Do zmiennej $release_date funkcja zapisuje datę premiery;
### Zmienione
- Poprawiłem plik composer.json

## [0.0.1] - 2020-11-22
### Dodane
- Na podstawie tytułu oraz opcjonalnie daty premiery filmu funkcja pobiera stronę z opisem filmu i zapisuje ją w zmiennej $movie_page
- Funkcja zapisuje do poniższych zmiennych kolejno:
    - $title - tytuł filmu
    - $original_title - oryginalny tytuł filmu
    - $url - łącze do informacji o filmie na Filmweb.pl
    - $rate - średnia ocena użytkowników
    - $rate_count - ilość ocen
    - $description - opis filmu
    - $poster - łącze do plakatu
- Jeżeli film nie zostanie znaleziony funkcja jest zatrzymywana z błędem "Nie można znaleźć filmu"

[Unreleased]: https://github.com/stanik120/filmweb-scraping/compare/v0.0.2...HEAD
[0.0.2]: https://github.com/stanik120/filmweb-scraping/compare/v0.0.1...v0.0.2
[0.0.1]: https://github.com/stanik120/filmweb-scraping/releases/tag/v0.0.1
