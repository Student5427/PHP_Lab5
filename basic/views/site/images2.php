<?php
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;

echo Html::a("Add image", ["add"], ['class' => 'btn btn->info']);
#echo '<div style="overflow: auto;overflow-y: hidden; height: 100%;">';
echo GridView::widget(['dataProvider' => $dataProvider,
'layout'=> "{items}\n {pager}",
'options'=>['style' => ['height' => '500px', 'overflow-y' => 'scroll', 'border-collapse' => 'separate', 'border-spacing' => 0]],
'headerRowOptions' =>['style'=>['position' => 'sticky','top' => 0 , 'background-color'=>'black', 'color' => 'white']],
'columns' => ['id', [
            'label' => 'Картинка',
            'format' => ['image', ['width'=>160, 'height' =>90]],
            'value' => function($data){
                return('upload/'.$data->name);
            },
        ],
         'caption',['class' => ActionColumn::class,
'template' => '{view} {update} {delete} {link}',
 'buttons' => [
    'delete' => function ($url,$model) {
        return Html::a(
        '<span class="glyphicon glyphicon-remove"></span>', 
        $url, ['style' => ['color' => 'black']]);
    },
]]]]);
#echo '</div>';
//echo LinkPager::widget(['pagination' => $pagination]);

?>
