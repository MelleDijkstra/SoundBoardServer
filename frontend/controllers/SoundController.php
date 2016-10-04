<?php

namespace frontend\controllers;

use frontend\models\SoundUploadForm;
use Yii;
use common\models\Sound;
use common\models\search\SoundSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SoundController implements the CRUD actions for Sound model.
 */
class SoundController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Sound models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SoundSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sound model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sound model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sound();
        $model->soundFile = UploadedFile::getInstance($model, 'soundFile');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->soundFile = UploadedFile::getInstance($model, 'soundFile');
            $model->generateFilename();
            $model->soundFile->saveAs(Yii::getAlias('@uploadPath').'/'.$model->filename);
            // Set null so ->save() doesn't throw an error
            $model->soundFile = null;
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Sound model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // Get the uploaded file for validating
        $model->soundFile = UploadedFile::getInstance($model, 'soundFile');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Set soundFile again, because after validate soundFile is a string
            $this->saveFile($model);
            // Set null so ->save() doesn't throw an error
            $model->soundFile = null;
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Sound model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sound model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sound the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sound::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $model Sound
     */
    private function saveFile($model)
    {
        // Check if old file has to be deleted
        $model->deleteOldFile();
        // Get the file
        $model->soundFile = UploadedFile::getInstance($model, 'soundFile');
        // Generate new name for file
        $model->generateFilename();
        // Save it
        $model->soundFile->saveAs(Yii::getAlias('@uploadPath').'/'.$model->filename);
    }
}
