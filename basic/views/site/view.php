<?php
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<h2> Изображение </h2>
<?php
echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        ['attribute'=>'name', 'value'=>'upload/'.$model->name, 'format'=>['image', ['width'=>576, 'height' =>456]]],
	'caption',],
]);


?>
