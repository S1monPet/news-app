<?php 
/* Stran, ki omogoča prijavo v spletno stran */ 

include_once 'header.php';

// Funckija preveri ustreznost uporabniškega imena ter gesla
function validate_login($username, $password){
	global $conn;
	// Iz baze poiščemo uporabnika s podanim uporabniškim imenom
	$username = mysqli_real_escape_string($conn, $username);
	$query = "SELECT * FROM users WHERE username='$username'";
	$res = $conn->query($query);
    $user_obj = $res->fetch_object();
	// Nato preverimo njegovo geslo s pomočjo funkcije password_verify() (vgrajeno v PHP)
	if($user_obj && password_verify($password, $user_obj->password)){
		return $user_obj->id;
	}
	return -1;
}

$error="";
if(isset($_POST["login"])){
	//Preveri prijavne podatke
	if(($user_id = validate_login($_POST["username"], $_POST["password"])) >= 0){
		//Zapomni si prijavljenega uporabnika v seji in preusmeri na index.php
		$_SESSION["USER_ID"] = $user_id;
		header("Location: index.php");
		die();
	} else{
		$error = "Neveljavni prijavni podatki.";
	}
}
?>

<div class="container">
    <h3 class="mb-3">Prijava</h3>
    <form action="login.php" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Vzdevek</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST["username"]) ? $_POST["username"]: ""; ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Geslo</label>
            <input type="password" class="form-control" id="password" name="password" value="<?php echo isset($_POST["password"]) ? $_POST["password"]: ""; ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="login">Prijava</button>
        <label class="text-danger"><?php echo $error; ?></label>
    </form>
</div>

<?php
include_once 'footer.php';
?>