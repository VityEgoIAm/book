<?php

namespace app\controllers;

use app\models\Book;
use app\models\BookAuthor;
use app\models\BookSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Book models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param string $isbn Isbn
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($isbn)
    {
        return $this->render('view', [
            'model' => $this->findModel($isbn),
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Book();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->image = UploadedFile::getInstance($model, 'image');
                if (!is_null($model->image)) {
                    $model->upload();
                }

                if ($model->save()) {
                    return $this->redirect(['view', 'isbn' => $model->isbn]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $isbn Isbn
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($isbn)
    {
        $model = $this->findModel($isbn);
        $authors = $model->getBookAuthors()->all();

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if (!is_null($model->image)) {
                $model->upload();
            }
            
            $oldIDs = ArrayHelper::map($authors, 'id', 'id');
            $authors = BookAuthor::createMultiple(BookAuthor::class, $authors);
            BookAuthor::loadMultiple($authors, \Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($authors, 'id', 'id')));
            
            $valid = $model->validate();
            $valid = BookAuthor::validateMultiple($authors) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save()) {
                        if (!empty($deletedIDs)) {
                            BookAuthor::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($authors as $author) {
                            $author->book_isbn = $model->isbn;
                            if (! ($flag = $author->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'isbn' => $model->isbn]);
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'authors' => (empty($authors)) ? [new BookAuthor] : $authors,
        ]);
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $isbn Isbn
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($isbn)
    {
        $this->findModel($isbn)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $isbn Isbn
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($isbn)
    {
        if (($model = Book::findOne(['isbn' => $isbn])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
