<?php
use yii\widgets\LinkPager;
?>

<h3>Comments</h3>

<ul>
<?php foreach ($comments as $comment):?>
    <li><b><?=$comment->name?>:</b> <?=$comment->text?></li>

<?php endforeach;?>
</ul>

<?php echo LinkPager::widget(['pagination' => $pagination]);?>