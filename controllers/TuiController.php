<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\Tui;

class TuiController extends Controller
{
    
    public function actionEntry()
    {
        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // valid data received in $model

            // do something meaningful here about $model ...

            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // either the page is initially displayed or there is some validation error
            return $this->render('entry', ['model' => $model]);
        }
    }
        /**
     * Return data to browser as JSON and end application.
     * @param array $data
     */
    protected function renderJSON($data)
    {
        header('Content-type: application/json');
        echo CJSON::encode($data);

        foreach (Yii::app()->log->routes as $route) {
            if($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        }
        Yii::app()->end();
    }

    public function actionTest($id)
    {
        // $headers is an object of yii\web\HeaderCollection 
        $headers = Yii::$app->request->headers;

        // returns the Accept header value
        $accept = $headers->get('Accept');

        if ($headers->has('User-Agent')) { /* there is User-Agent header */ }

        $userHost = Yii::$app->request->userHost;
        $userIP = Yii::$app->request->userIP;

        $request = Yii::$app->request;
        if ($request->isAjax) { /* the request is an AJAX request */ }
        if ($request->isGet)  { /* the request method is GET */ }
        if ($request->isPost) { /* the request method is POST */ }
        if ($request->isPut)  { /* the request method is PUT */ }


        //  \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
         $model = new Tui();
         $model->name= (string)$id . $userHost . $userIP . $request->queryString;
         
        // return $this->render($model);

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        return $response->data = ['data' => $model,'code' => 200 ];
    }


}