<?php 
/* Stran za izpis vsebine posamezne novice */

include_once 'header.php';

// Funkcija prebere novico s podanim id-jem iz baze in vrne objekt
function get_article($id){
	global $conn;
    $id = mysqli_real_escape_string($conn, $id);
	$query = "SELECT a.*, u.username FROM articles a LEFT JOIN users u ON u.id = a.user_id WHERE a.id = $id;";
	$res = $conn->query($query);
	if($article = $res->fetch_object()){
		return $article;
	}
	return null;
}

$article = get_article($_GET["id"]);
if($article == null){
    ?>
    <div class="container">
        <i class="text-danger">Zahtevana novica ne obstaja</i>
    </div>
    <?php
    die();
}
?>

<div class="container">
    <h3>Seznam novic</h3>
    <div class="article">
        <h4><?php echo $article->title;?></h4>
        <p><b>Povzetek:</b> <?php echo $article->abstract;?></p>
        <p><?php echo $article->text; ?></p>
        <p>Objavil: <?php echo $article->username; ?>, <?php echo date_format(date_create($article->date), 'd. m. Y \ob H:i:s'); ?></p>
        <a href="/"><button>Nazaj</button></a>
    </div>
</div>

<?php
include_once 'footer.php';
?>