<?php
/**
 * @var yii\web\View $this
 * @var string $userName
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use api\assets\IndexAsset;

//IndexAsset::register($this);

$this->title = 'Админка';
?>
Пользователь: <?= $userName ?>
