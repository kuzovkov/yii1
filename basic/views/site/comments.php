<?php
use yii\widgets\LinkPager;
?>

<h3>Comments</h3>

<p>Last you have seen <a href="<?php echo Yii::$app->urlManager->createUrl(['site/user', 'name' => $name]) ?>"><?=$name?></a></p>
<p>Cookie: <?=$cookiename?></p>
<ul>
<?php foreach ($comments as $comment):?>
    <li><b><a href="<?php echo Yii::$app->urlManager->createUrl(['site/user', 'name' => $comment->name]) ?>"><?=$comment->name?></a>:</b> <?=$comment->text?></li>

<?php endforeach;?>
</ul>

<?php echo LinkPager::widget(['pagination' => $pagination]);?>