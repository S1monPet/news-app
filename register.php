<?php 
/* Stran z obrazcem za registracijo */

include_once 'header.php';

// Funkcija preveri, ali v bazi obstaja uporabnik z določenim imenom in vrne true, če obstaja.
function username_exists($username){
	global $conn;
	$username = mysqli_real_escape_string($conn, $username);
	$query = "SELECT * FROM users WHERE username='$username'";
	$res = $conn->query($query);
	return mysqli_num_rows($res) > 0;
}

// Funkcija ustvari uporabnika v tabeli users. Poskrbi tudi za ustrezno šifriranje uporabniškega gesla.
function register_user($username, $email, $password){
	global $conn;
	// Vse podatke iz obrazca prečistimo s funkcijo mysqli_real_escape_string, s čimer preprečimo SQL injection
	$username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);
	// Geslo vedno šifriramo, nikoli ga ne hranimo v surovi obliki. Uporabimo vgrajeno funkcijo password_hash()
	$pass = password_hash($password, PASSWORD_DEFAULT);
	/* 
        Več o šifriranju gesel:
        http://php.net/manual/en/faq.passwords.php#faq.passwords 
		https://crackstation.net/hashing-security.htm
	*/
	$query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$pass');";
	if($conn->query($query)){
		return true;
	}
	else{
		echo mysqli_error($conn);
		return false;
	}
}

$error = "";

/* 
Ločiti moramo dva scenarija: 
1. Uporabnik obišče register.php ($_POST je prazen): prikažemo obrazec za registracijo
2. Uporabnik pošlje podatke iz obrazca v $_POST: obdelamo zahtevek za registracijo (validacija, insert v bazo, ...)
*/
if(isset($_POST["register"])){
    /*
		VALIDACIJA: preveriti moramo, ali je uporabnik pravilno vnesel podatke (unikatno uporabniško ime, dolžina gesla,...)
		Validacijo vnesenih podatkov VEDNO izvajamo na strežniški strani. Validacija, ki se izvede na strani odjemalca (recimo Javascript), 
		služi za bolj prijazne uporabniške vmesnike, saj uporabnika sproti obvešča o napakah. Validacija na strani odjemalca ne zagotavlja
		nobene varnosti, saj jo lahko uporabnik enostavno zaobide (developer tools,...).
	*/
    //Preveri če so vsi podatki izpolnjeni
    if(empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"])){
        $error = "Izpolnite vse podatke.";
    }
	//Preveri če se gesli ujemata
	else if($_POST["password"] != $_POST["repeat_password"]){
		$error = "Gesli se ne ujemata.";
	}
	//Preveri ali uporabniško ime obstaja
	else if(username_exists($_POST["username"])){
		$error = "Uporabniško ime je že zasedeno.";
	}
	//Podatki so pravilno izpolnjeni, registriraj uporabnika
	else if(register_user($_POST["username"], $_POST["email"], $_POST["password"])){
		header("Location: login.php");
		die();
	}
	//Prišlo je do napake pri registraciji
	else{
		$error = "Prišlo je do napake med registracijo uporabnika.";
	}
}
?>

<div class="container">
    <h3 class="mb-3">Registracija</h3>
    <form action="register.php" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Vzdevek</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST["username"]) ? $_POST["username"]: ""; ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-pošta</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"]: ""; ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Geslo</label>
            <input type="password" class="form-control" id="password" name="password" value="<?php echo isset($_POST["password"]) ? $_POST["password"]: ""; ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Ponovi geslo</label>
            <input type="password" class="form-control" id="repeat" name="repeat_password" value="<?php echo isset($_POST["repeat_password"]) ? $_POST["repeat_password"]: ""; ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="register">Registriraj</button>
        <label class="text-danger"><?php echo $error; ?></label>
    </form>
</div>

<?php
include_once 'footer.php';
?>