<div class="container">
    <h3 class="mb-3">Moje novice</h3>
    <?php if(count($articles) == 0): ?>
        <p><i>Še niste objavili nobene novice.</i></p>
    <?php else: ?>
        <?php foreach ($articles as $article): ?>
        <div class="article border rounded p-3 mb-3">
            <h4><?php echo htmlspecialchars($article->title); ?></h4>
            <p><?php echo htmlspecialchars($article->abstract); ?></p>
            <p><small>Objavljeno: <?php echo date_format(date_create($article->date), 'd. m. Y \ob H:i:s'); ?></small></p>
            <a href="/articles/edit?id=<?php echo $article->id; ?>" class="btn btn-sm btn-warning">Uredi</a>
            <a href="/articles/delete?id=<?php echo $article->id; ?>" class="btn btn-sm btn-danger"
               onclick="return confirm('Ali res želite izbrisati to novico?')">Izbriši</a>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>