<div class="container">
    <h3>Objavi novicoooo</h3>
    <form action="/articles/store" method="POST">
        <div>
            <label for="title" class="form-label">Naslov</label>
            <input type="text" class="form-control" id="title" name="title"
                   value="<?php echo isset($_POST["title"]) ? htmlspecialchars($_POST["title"]) : ""; ?>">
        </div>
        <div>
            <label for="abstract" class="form-label">Povzetek</label>
            <textarea class="form-control" id="abstract" name="abstract" rows="3"><?php echo isset($_POST["abstract"]) ? htmlspecialchars($_POST["abstract"]) : ""; ?></textarea>
        </div>
        <div>
            <label for="text" class="form-label">Vsebina</label>
            <textarea class="form-control" id="text" name="text" rows="6"><?php echo isset($_POST["text"]) ? htmlspecialchars($_POST["text"]) : ""; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Objavi</button>
        <label class="text-danger"></label>
    </form>
</div>
 