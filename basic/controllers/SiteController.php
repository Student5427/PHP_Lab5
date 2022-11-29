<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Images;
//��� 4 ����
use Codeception\Attribute\DataProvider;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\UploadedFile;
use yii\base\ErrorException;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'images2'],
                'rules' => [
                    [
                        'actions' => ['logout', 'images2'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->render('test', ['test' => Yii::$app->user->identity]);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
	
    }
    public function actionImages()
        {
            //$images = Images::find()->all();
            $query = "SELECT * FROM images";
            $images = Images::findBySql($query)->all();
	    //return var_dump($images);
            //$pagination = new Pagination(['defaultPageSize' => 10, 'totalCount' => count($images)]);
            //$images = $images->offset( $pagination ->offset)->limit ($pagination -> limit) ->all ;
            //return $this->render('images', ['images'=>$images, 'pagination'=>$pagination]);
            //$dataprovider = new ActiveDataProvider(['query'=>Images::findBySql($query)->all(),
            //'pagination' => ['pageSize' => 20]]);
	    //������������ ��� images.php, ������� � ���-�� ���-�� �������� ������ Activerecord $images
            return $this->render('images', compact('images'));
        }
     public function actionImages2()
	{	//��� ������� GridView
		$dataProvider = new ActiveDataProvider(['query' => Images::find()]);
		$images = Images::find();
		//��� �������� �� ��������(������ LinkPager)
		$pagination = new Pagination(['defaultPageSize'=>10, 'totalCount' => $images->count()]);
		$dataProvider = new ActiveDataProvider(['query' => Images::find(), 'pagination' => $pagination]);
                //������ ������� �������� � ��� ������ - �� ����� �-�� compact, � ����� ������������� ������
		return $this->render('images2', ['dataProvider'=>$dataProvider, 'pagination'=>$pagination, 'images'=>$images]);
	}
     public function actionUpdate($id)
	{
		$image = Images::findOne($id);
		if ($image->load(Yii::$app->request->post())) {
		$image->save();
            		return $this->redirect('index.php?r=site%2Fimages2');
        	}
		return $this->render('update', compact('image'));
	}

    public function actionAdd()
    {
	
        $image = new Images();
	
        if (Yii::$app->request->isPost) {
            $image->load(Yii::$app->request->post());
            $image->name =UploadedFile::getInstance($image, 'name');
	    $image->save();
            $image->name->saveAs('upload/'. $image->name->baseName . '.' . $image->name->extension);

            //$image->save();
                        return $this->render('view', ['model'=>$image]);
                }
            return $this->render('update', ['image'=>$image]);

    }

    public function actionDelete2($id)
    {
        $image = Images::findOne($id);
        if ($image)
        {
            $image->delete();
            return $this->redirect('index.php?r=site%2Fimages2');
        }

    }

    /*public function actionDelete($id)
    {
        $image = Images::findOne($id);
        if ($image)
        {
            $image->delete();
            return $this->redirect('index.php?r=site%2Fimages2');
        }

    }*/

    public function actionDelete($id)
    {
       $image = Images::findOne($id);
       return $this->render('delete.php', ['model'=>$image, 'id' => $id]);
        
    }

    public function actionView($id)
    {
        $image = Images::findOne($id);
        return $this->render('view.php', ['model'=>$image]);
    }

}


