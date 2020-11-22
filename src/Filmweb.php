<?php

namespace Scraping;

class Filmweb
{
    // definicja zmiennych
    var $title;
    var $original_title;
    var $url;
    var $rate;
    var $rate_count;
    var $description;
    var $poster;
    var $director;
    var $creator;
    var $genre;
    var $production;
    var $release_date;

    function __construct($title, $date = null)
    {
        $this->scraping($title, $date);
    }

    function scraping($title, $date){
        // utwórz łącze do wyszukania filmu
        $title_date = str_replace(" ", "+", $title) ."+". $date;
        $search_url = "https://www.filmweb.pl/films/search?q=".$this->cleanString($title_date);
        // pobierz stronę z wynikami wyszukiwania dla podanego tytułu filmu oraz daty premiery
        $search_page = $this->save_page($search_url);

        // Znajdź bezpośrednie łącze do informacji o filmie
        $movie_url = $this->between('class="filmPreview__link" href="', '"', $search_page);
        // Jeżeli nie znaleziono filmu zakończ program i zwróć błąd
        if ($movie_url == null){
            exit('Nie można znaleźć filmu');
        }
        unset($search_page);
        // łącze do informacji o filmie
        $movie_url = "https://www.filmweb.pl".$movie_url;

        // Pobierz stronę z informacjami o filmie
        $movie_page = $this->save_page($movie_url);
        // zapisz informacje o filmie do zmiennych
        $this->title = $this->between('<title>', ' (', $movie_page);
        $this->original_title = $this->between('<h2 class="filmCoverSection__orginalTitle">', '</h2>', $movie_page);
        $this->url = $movie_url;
        $this->rate = $this->between('data-rate="', '"', $movie_page);
        $this->rate_count = $this->between('data-count="', '"', $movie_page);
        $this->description = $this->between('itemprop="description">', '</div>', $movie_page);
        $this->poster = $this->between('id="filmPoster" itemprop="image" content="', '"', $movie_page);
        $this->release_date = $this->between('<span class="block">', '</span>', $movie_page);

        $directors = $this->between('data-type="directing-info">', '</div>', $movie_page);
        $director = explode('</a>', $directors);
        foreach ($director as $dir => $val){
            $director[$dir] = $this->between('title="', '"', $val);
            if($director[$dir] != null){
                $this->director[$dir] = $director[$dir];
            }
        }

        $creators = $this->between('data-type="screenwriting-info">', '</div>', $movie_page);
        $creator = explode('</a>', $creators);
        foreach ($creator as $cre => $val){
            $creator[$cre] = $this->between('title="', '"', $val);
            if($creator[$cre] != null){
                $this->creator[$cre] = $creator[$cre];
            }
        }

        $genres = $this->between('itemprop="genre"><span>', '</div>', $movie_page);
        $genre = explode('</a>', $genres);
        foreach ($genre as $gen => $val){
            $genre[$gen] = $this->between('film/', '/', $val);
            if($genre[$gen] != null){
                $this->genre[$gen] = $genre[$gen];
            }
        }

        $productions = $this->between('produkcja</div><div class="filmInfo__info"><span><a href="', '</div>', $movie_page);
        $production = explode('<a href="', $productions);
        foreach ($production as $pro => $val){
            $production[$pro] = $this->between('">', '</a>', $val);
            if($production[$pro] != null){
                $this->production[$pro] = $production[$pro];
            }
        }

    }

    // funkcja odpowiedzialna za znalezienie ciągu znaków pomiędzy dwoma innymi ciągami
    function between($first, $second, $string){
        // jeżeli na stronie nie istnieje szukany argument zwróć null
        if(strstr($string, $first)===False){
            return null;
        }
        $first_len = strlen($first);
        $start = strpos($string, $first)+$first_len;
        $return = substr($string, $start);
        $end = strpos($return, $second);
        $return = substr($return, 0, $end);
        return $return;
    }

    // funkcja odpowiedzialna za pobranie strony i zwrócenie jej w postaci stringa
    function save_page($url){
        $page = curl_init($url);
        curl_setopt($page, CURLOPT_RETURNTRANSFER, 1);
        $page = curl_exec($page);
        return $page;
    }

    // Zamienia wszystkie polskie znaki na takie bez ogonków
    function cleanString($string){
        $chars=array(
            chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
            chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
            chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
            chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
            chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
            chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
            chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
            chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
            chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
            chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
            chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
            chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
            chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
            chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
            chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
            chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
            chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
            chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
            chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
            chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
            chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
            chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
            chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
            chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
            chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
            chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
            chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
            chr(195).chr(191) => 'y',
            chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
            chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
            chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
            chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
            chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
            chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
            chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
            chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
            chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
            chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
            chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
            chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
            chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
            chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
            chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
            chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
            chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
            chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
            chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
            chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
            chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
            chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
            chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
            chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
            chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
            chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
            chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
            chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
            chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
            chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
            chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
            chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
            chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
            chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
            chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
            chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
            chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
            chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
            chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
            chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
            chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
            chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
            chr(197).chr(148) => 'R', chr(197).chr(149) => 'r',
            chr(197).chr(150) => 'R', chr(197).chr(151) => 'r',
            chr(197).chr(152) => 'R', chr(197).chr(153) => 'r',
            chr(197).chr(154) => 'S', chr(197).chr(155) => 's',
            chr(197).chr(156) => 'S', chr(197).chr(157) => 's',
            chr(197).chr(158) => 'S', chr(197).chr(159) => 's',
            chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
            chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
            chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
            chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
            chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
            chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
            chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
            chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
            chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
            chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
            chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
            chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
            chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
            chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
            chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
            chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
            chr(226).chr(130).chr(172) => 'E',
        );
        $string = strtr($string, $chars);
        return $string;
    }

}
