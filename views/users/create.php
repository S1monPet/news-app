<div class="container">
    <h3 class="mb-3">Registracija</h3>
    <form action="/users/store" method="POST">
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