<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<h1><?=Html::encode($id);?></h1>
<h1><?=Html::encode($name);?></h1>
<h1><?=HTMLPurifier::process($name);?></h1>
<h1><?=Html::encode($arr[2]);?></h1>

