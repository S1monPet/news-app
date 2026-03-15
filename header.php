<?php
  // Vedno predno uporabljamo sejne spremenljivke, moramo naložizi sejo s klicem funckije session_start()
	session_start();
	
	//Seja poteče po 30 minutah - avtomatsko odjavi neaktivnega uporabnika
	if(isset($_SESSION['LAST_ACTIVITY']) && time() - $_SESSION['LAST_ACTIVITY'] < 1800){
		session_regenerate_id(true);
	}
	$_SESSION['LAST_ACTIVITY'] = time();
	
	//Poveži se z bazo
	$conn = new mysqli('localhost', 'root', '', 'news');
	//Nastavi kodiranje znakov, ki se uporablja pri komunikaciji z bazo
	$conn->set_charset("UTF8");
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <title>Vaja 1 - Novice</title>
	<meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <span class="fs-4">Novice</span>
      </a>

      <ul class="nav nav-pills">
        <li class="nav-item"><a href="/" class="nav-link active" aria-current="page">Domov</a></li>
        <?php
        if(isset($_SESSION["USER_ID"])){
            ?>
            <li class="nav-item"><a href="/publish.php" class="nav-link">Objavi novico</a></li>
            <li class="nav-item"><a href="/logout.php" class="nav-link">Odjava</a></li>
            <?php
        } else{
            ?>
            <li class="nav-item"><a href="/login.php" class="nav-link">Prijava</a></li>
            <li class="nav-item"><a href="/register.php" class="nav-link">Registracija</a></li>
            <?php
        }
        ?>
      </ul>
    </header>
  </div>