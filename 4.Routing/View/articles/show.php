<?php require 'View/includes/header.php'?>

<?php // Use any data loaded in the controller here
?>

<section>
    <h1><?= $article->title ?></h1>
    <p>- By <a href="/author_id=<?php echo $rawArticle['author_ids'];?>"><?= $article->authorNames ?></a></p>
    <p><?= $article->formatPublishDate() ?></p>
    <img src="<?php echo $rawArticle['url'];?>" alt="">
    <p><?= $article->description ?></p>

    <?php // TODO: links to next and previous ?>
    <?php if ($prevArticle): ?>
            <a href="/articles/id=<?php echo $prevArticle['id']; ?>">Previous article</a>
        <?php endif; ?>
        
        <?php if ($nextArticle): ?>
            <a href="/articles/id=<?php echo $nextArticle['id']; ?>">Next article</a>
        <?php endif; ?>
</section>

<?php 
//print_r($article->authorNames);
require 'View/includes/footer.php'?>

