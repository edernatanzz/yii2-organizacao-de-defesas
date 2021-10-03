<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\User;
use app\models\Usuario;
use app\security\ValidatorRequest;
use DateTime;
use DateTimeZone;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class UsuarioController extends \yii\rest\ActiveController
{

    public $modelClass = 'app\models\Usuario';
    private $user;


    public function beforeAction($action)
    {
        $permission = ValidatorRequest::validatorHeader(Yii::$app->request->headers);
        if (!$permission) {
            throw new \yii\web\ForbiddenHttpException('Voce nao tem permissao para acessar esta pagina', 403);
        }
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $defaultActions = parent::actions();
        unset($defaultActions['create']);
        return $defaultActions;
    }


    public function actionCreate()
    {
        try {
            $model = new Usuario();

            // Coletando valores da requisição POST que foi recebida
            $data = Yii::$app->request->post();

            // Atribuindo os atributos da requição para o modelo
            $model->attributes = $data;


            /// Atribuindo horario/data para os atributos do modelo 
            $dtz = new DateTimeZone("America/Sao_Paulo");
            $now = new DateTime("now", $dtz);
            $now = $now->format("d/m/Y H:i:s");
            $model->created_at = $now;
            $model->updated_at = $now;


            // Coleta a senha enviada pelo formulário para fazer a validacao
            $model->password_has = $data['password'];

            // Gera uma chave aleatoria para usar como token, validando que vai ser unique
            $model->auth_key = Yii::$app->getSecurity()->generateRandomString();
            while ($this->findModelByToken($model->auth_key)) {
                $model->auth_key = Yii::$app->getSecurity()->generateRandomString();
            }

            // Validar os atributos do modelo
            if ($model->validate()) {
                //  Faz a criptografia da senha enviada
                $model->password_has = Yii::$app->getSecurity()->generatePasswordHash($data['password']);

                // Salva o modelo no banco de dados
                // $model->save();

                return [];
            }

            // Caso a validacao falhe, lançar erros para o front
            Yii::$app->response->data = $model->errors;
            Yii::$app->response->statusCode = 422;

            return Yii::$app->response->data;
        } catch (Exception $e) {
            throw $e;
        }
        // throw new \yii\web\NotFoundHttpException('The requested page does not exist.', 403);
    }

    public function actionLogin()
    {
        try {
            $model = new LoginForm();

            // Coletando valores da requisição POST que foi recebida
            $data = Yii::$app->request->post();

            // Atribuindo os atributos da requição para o modelo
            $model->attributes = Yii::$app->request->post();

            // Validando o login
            if ($model->login()) {
                // $session = Yii::$app->session;
                // $session->set('token_access', 'Rafael');
                // $session->save();
                json_encode(Yii::$app->user->getId());
                // return Yii::$app->user->;
            }

            // Caso a validacao falhe, lançar erros para o front
            return $model;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function actionView()
    {
    }

    protected function findModelById($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested page does not exist.', 404);
    }

    protected function findModelByUsername($username)
    {
        if (($model = Usuario::find()->where(['username' => $username])->one()) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested page does not exist.', 404);
    }

    protected function findModelByToken($token)
    {
        if (($model = Usuario::find()->where(['auth_key' => $token])->one()) !== null) {
            return true;
        }

        return false;
    }
}
