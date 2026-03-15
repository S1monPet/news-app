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
                <li class="nav-item"><a href="/articles/create" class="nav-link">Objavi novico</a></li>
                <li class="nav-item"><a href="/users/edit" class="nav-link">Uredi profil</a></li>
                <li class="nav-item"><a href="/auth/logout" class="nav-link">Odjava</a></li>
                <?php
            } else{
                ?>
                <li class="nav-item"><a href="/auth/login" class="nav-link">Prijava</a></li>
                <li class="nav-item"><a href="/users/create" class="nav-link">Registracija</a></li>
                <?php
            }
            ?>
        </ul>
        </header>
    </div>

    <!-- tukaj se bo vključevala koda pogledov, ki jih bodo nalagali kontrolerji -->
    <!-- klic akcije iz routes bo na tem mestu zgeneriral html kodo, ki bo zalepnjena v našo predlogo -->
    <?php require_once('routes.php'); ?> 

    <div class="container">
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="/" class="nav-link px-2 text-body-secondary">Domov</a></li>
            <?php
                if(isset($_SESSION["USER_ID"])){
                    ?>
                    <li class="nav-item"><a href="/articles/create" class="nav-link px-2 text-body-secondary">Objavi novico</a></li>
                    <li class="nav-item"><a href="/users/edit" class="nav-link px-2 text-body-secondary">Uredi profil</a></li>
                    <li class="nav-item"><a href="/auth/logout" class="nav-link px-2 text-body-secondary">Odjava</a></li>
                    <?php
                } else{
                    ?>
                    <li class="nav-item"><a href="/auth/login" class="nav-link px-2 text-body-secondary">Prijava</a></li>
                    <li class="nav-item"><a href="/users/create" class="nav-link px-2 text-body-secondary">Registracija</a></li>
                    <?php
                }
                ?>
            </ul>
            <p class="text-center text-body-secondary">© UM FERI, Novice</p>
        </footer>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>