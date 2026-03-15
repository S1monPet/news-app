<div class="container">
    <h3 class="mb-3">Prijava</h3>
    <form action="/auth/authenticate" method="POST">
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