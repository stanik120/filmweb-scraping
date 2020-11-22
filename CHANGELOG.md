# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- Na podstawie tytułu oraz opcjonalnie daty premiery filmu funkcja pobiera stronę z opisem filmu i zapisuje ją w zmiennej $movie_page
- Funkcja zapisuje do poniższych zmiennych kolejno:
    $title - tytuł filmu
    $original_title - oryginalny tytuł filmu
    $url - łącze do informacji o filmie na Filmweb.pl
    $rate - średnia ocena użytkowników
    $rate_count - ilość ocen
    $description - opis filmu
    $poster - łącze do plakatu
- Jeżeli film nie zostanie znaleziony funkcja jest zatrzymywana z błędem "Nie można znaleźć filmu"
