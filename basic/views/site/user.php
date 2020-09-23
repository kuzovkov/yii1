<?php
use app\components\Hello;
?>

<?=$user?>


<div>Widget says: <?php echo Hello::widget(['message' => 'My message'])?></div>
