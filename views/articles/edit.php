<div class="container">
    <h3 class="mb-3">Uredi novico</h3>
    <form action="/articles/update?id=<?php echo $article->id; ?>" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Naslov</label>
            <input type="text" class="form-control" id="title" name="title"
                   value="<?php echo isset($_POST["title"]) ? htmlspecialchars($_POST["title"]) : htmlspecialchars($article->title); ?>">
        </div>
        <div class="mb-3">
            <label for="abstract" class="form-label">Povzetek</label>
            <textarea class="form-control" id="abstract" name="abstract" rows="3"><?php echo isset($_POST["abstract"]) ? htmlspecialchars($_POST["abstract"]) : htmlspecialchars($article->abstract); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="text" class="form-label">Vsebina</label>
            <textarea class="form-control" id="text" name="text" rows="6"><?php echo isset($_POST["text"]) ? htmlspecialchars($_POST["text"]) : htmlspecialchars($article->text); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Shrani</button>
        <a href="/articles/list" class="btn btn-secondary">Nazaj</a>
        <label class="text-danger"><?php echo $error; ?></label>
    </form>
</div>