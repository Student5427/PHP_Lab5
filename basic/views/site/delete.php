<?php
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<h2> Вы действительно хотите удалить изображение?</h2>

<?php
echo Html::a("delete image", ["delete2", 'id'=>$model->id], ['class' => 'btn btn->alert']);
echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        ['attribute'=>'name', 'value'=>'upload/'.$model->name, 'format'=>['image', ['width'=>576, 'height' =>456]]],
	'caption',],
]);


?>

