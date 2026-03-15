<?php
/*
    Controller za novice. Vključuje naslednje standardne akcije:
        index: izpiše vse novice
        show: izpiše posamezno novico
        
    TODO:
        list: izpiše novice prijavljenega uporabnika
        create: izpiše obrazec za vstavljanje novice
        store: vstavi novico v bazo
        edit: izpiše vmesnik za urejanje novice
        update: posodobi novico v bazi
        delete: izbriše novico iz baze
*/

class articles_controller
{
    public function index()
    {
        //s pomočjo statične metode modela, dobimo seznam vseh novic
        //$ads bo na voljo v pogledu za vse oglase index.php
        $articles = Article::all();

        //pogled bo oblikoval seznam vseh oglasov v html kodo
        require_once('views/articles/index.php');
    }

    public function show()
    {
        //preverimo, če je uporabnik podal informacijo, o oglasu, ki ga želi pogledati
        if (!isset($_GET['id'])) {
            return call('pages', 'error'); //če ne, kličemo akcijo napaka na kontrolerju stran
            //retun smo nastavil za to, da se izvajanje kode v tej akciji ne nadaljuje
        }
        //drugače najdemo oglas in ga prikažemo
        $article = Article::find($_GET['id']);
        require_once('views/articles/show.php');
    }

    public function create(){
        require_once('views/articles/create.php');
    }

        public function store()
    {
        if (!isset($_SESSION["USER_ID"])) {
            header("Location: /auth/login");
            die();
        }

        if (empty($_POST["title"]) || empty($_POST["abstract"]) || empty($_POST["text"])) {
            header("Location: /articles/create?error=1");
            die();
        }

        if (Article::create($_POST["title"], $_POST["abstract"], $_POST["text"], $_SESSION["USER_ID"])) {
            header("Location: /");
        } else {
            header("Location: /articles/create?error=2");
        }
        die();
    }

        public function list()
    {
        if (!isset($_SESSION["USER_ID"])) {
            header("Location: /auth/login");
            die();
        }
        $articles = Article::all_by_user($_SESSION["USER_ID"]);
        require_once('views/articles/list.php');
    }
 
    public function edit()
    {
        if (!isset($_SESSION["USER_ID"])) {
            header("Location: /auth/login");
            die();
        }
        if (!isset($_GET['id'])) {
            return call('pages', 'error');
        }
        $article = Article::find($_GET['id']);
        if ($article == null || $article->user->id != $_SESSION["USER_ID"]) {
            return call('pages', 'error');
        }
        $error = "";
        if (isset($_GET["error"])) {
            $error = "Izpolnite vsa polja.";
        }
        require_once('views/articles/edit.php');
    }
 
    public function update()
    {
        if (!isset($_SESSION["USER_ID"])) {
            header("Location: /auth/login");
            die();
        }
        if (!isset($_GET['id'])) {
            header("Location: /pages/error");
            die();
        }
        $article = Article::find($_GET['id']);
        if ($article == null || $article->user->id != $_SESSION["USER_ID"]) {
            header("Location: /pages/error");
            die();
        }
        if (empty($_POST["title"]) || empty($_POST["abstract"]) || empty($_POST["text"])) {
            header("Location: /articles/edit?id=" . $_GET['id'] . "&error=1");
            die();
        }
        if ($article->update($_POST["title"], $_POST["abstract"], $_POST["text"])) {
            header("Location: /articles/list");
        } else {
            header("Location: /articles/edit?id=" . $_GET['id'] . "&error=2");
        }
        die();
    }
 
    public function delete()
    {
        if (!isset($_SESSION["USER_ID"])) {
            header("Location: /auth/login");
            die();
        }
        if (!isset($_GET['id'])) {
            header("Location: /pages/error");
            die();
        }
        $article = Article::find($_GET['id']);
        if ($article == null || $article->user->id != $_SESSION["USER_ID"]) {
            header("Location: /pages/error");
            die();
        }
        $article->delete();
        header("Location: /articles/list");
        die();
    }
}