# [Filmweb.pl](https://www.filmweb.pl) scraping
 Prosta biblioteka pobierająca informacje na temat filmu ze strony [Filmweb.pl](https://www.filmweb.pl) na podstawie tytułu oraz opcjonalnie daty premiery.

Jeżeli film nie zostanie znaleziony zostanie zwrócony błąd o treści "Nie można znaleźć filmu"
### Przykład użycia:
```
        use Scraping\Filmweb;
        $title = new Filmweb("the matrix", 1999);
        var_dump($title);
```
### W odpowiedzi otrzymamy:
```
object(Scraping\Filmweb)[250]
  public 'title' => string 'Matrix' (length=6)
  public 'original_title' => string 'The Matrix' (length=10)
  public 'url' => string 'https://www.filmweb.pl/film/Matrix-1999-628' (length=43)
  public 'rate' => string '7.553558349609375' (length=17)
  public 'rate_count' => string '806148' (length=6)
  public 'description' => string 'Haker komputerowy Neo dowiaduje się od tajemniczych rebeliant&oacute;w, że świat, w kt&oacute;rym żyje, jest tylko obrazem przesyłanym do jego m&oacute;zgu przez roboty.' (length=174)
  public 'poster' => string 'https://fwcdn.pl/fpo/06/28/628/7685907.3.jpg' (length=44)
```
###
