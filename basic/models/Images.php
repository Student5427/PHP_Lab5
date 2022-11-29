<?php

namespace app\models;

use yii\db\ActiveRecord;

class Images extends ActiveRecord 
{
    public $file;
	//�� ������, ���� ��� ������ �� ��������� � ��������� ������� � ��
    public static function tableName()
    {
        return "images";
    }
	//���������: ���� name � caption �� ������ ���� �������, safe �����, ����� �������� ����� ������ � ��
    public function rules()
    {
	return[[['id', 'name', 'caption'], 'safe'], ['name', 'required'], ['caption', 'required'], [['name'], 'file', 'extensions' => 'jpg, png, gif, jpeg', 'maxSize' => 1024*1024*4]];
    }
}

?>

