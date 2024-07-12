<?php require 'View/includes/header.php'?>

<h1>Articles publiés par <?= htmlspecialchars($articles[0]['author_name']) ?></h1>

<?php foreach ($articles as $article): ?>
    <div>
    <li><a href="?page=articles-show&id=<?= $article['id']?>"><?= $article['title'] ?></a></li>
    </div>
<?php endforeach; ?>
<br>
<?php

 require 'View/includes/footer.php'?>