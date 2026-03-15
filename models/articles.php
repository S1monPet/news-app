<?php
/*
    Model za novico. Vsebuje lastnosti, ki definirajo strukturo novice in sovpadajo s stolpci v bazi.

    V modelu moramo definirati tudi relacije oz. povezane entitete/modele. V primeru novice je to $user, ki 
    povezuje novico z uporabnikom, ki je novico objavil. Relacija nam poskrbi za nalaganje podatkov o uporabniku, 
    da nimamo samo user_id, ampak tudi username, ...
*/

require_once 'users.php'; // Vključimo model za uporabnike

class Article
{
    public $id;
    public $title;
    public $abstract;
    public $text;
    public $date;
    public $user;

    // Konstruktor
    public function __construct($id, $title, $abstract, $text, $date, $user_id)
    {
        $this->id = $id;
        $this->title = $title;
        $this->abstract = $abstract;
        $this->text = $text;
        $this->date = $date;
        $this->user = User::find($user_id); //naložimo podatke o uporabniku
    }

    // Metoda, ki iz baze vrne vse novice
    public static function all()
    {
        $db = Db::getInstance(); // pridobimo instanco baze
        $query = "SELECT * FROM articles;"; // pripravimo query
        $res = $db->query($query); // poženemo query
        $articles = array();
        while ($article = $res->fetch_object()) {
            // Za vsak rezultat iz baze ustvarimo objekt (kličemo konstuktor) in ga dodamo v array $articles
            array_push($articles, new Article($article->id, $article->title, $article->abstract, $article->text, $article->date, $article->user_id));
        }
        return $articles;
    }

    // Metoda, ki vrne eno novico z določenim id-jem iz baze
    public static function find($id)
    {
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $id);
        $query = "SELECT * FROM articles WHERE id = '$id';";
        $res = $db->query($query);
        if ($article = $res->fetch_object()) {
            return new Article($article->id, $article->title, $article->abstract, $article->text, $article->date, $article->user_id);
        }
        return null;
    }
}