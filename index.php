<?php 
/* Vstopna stran, ki izpiše seznam vseh novic */

// Vključimo datoteko header.php, ki poskrbi za nastavitve seje in izpis menijev in 'glave' strani
include_once 'header.php';

// Funkcija prebere novice iz baze in vrne polje objektov
function get_articles(){
	global $conn;
	$query = "SELECT a.*, u.username FROM articles a LEFT JOIN users u ON u.id = a.user_id;";
	$res = $conn->query($query);
	$ads = array();
	while($ad = $res->fetch_object()){
		array_push($ads, $ad);
	}
	return $ads;
}

$articles = get_articles();
?>

<div class="container">
    <h3>Seznam novic</h3>
    <?php
    foreach ($articles as $article){
        ?>
        <div class="article">
            <h4><?php echo $article->title;?></h4>
            <p><?php echo $article->abstract;?></p>
            <p>Objavil: <?php echo $article->username; ?>, <?php echo date_format(date_create($article->date), 'd. m. Y \ob H:i:s'); ?></p>
            <a href="article.php?id=<?php echo $article->id;?>"><button>Preberi več</button></a>
        </div>
        <?php
    }
    ?>
</div>

<?php

// Vključimo datoteko footer.php, ki poskrbi za izpis noge strani
include_once 'footer.php';
?>