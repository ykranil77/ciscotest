<?php

namespace app\controllers;

use Yii;
use sizeg\jwt\Jwt;
use sizeg\jwt\JwtHttpBearerAuth;
use yii\rest\Controller;

use app\models\Routers;

class RestController extends Controller
{
	/**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
            'optional' => [
                'login',
            ],
        ];

        return $behaviors;
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogin()
    {
        /** @var Jwt $jwt */
        $jwt = Yii::$app->jwt;
        $signer = $jwt->getSigner('HS256');
        $key = $jwt->getKey();
        $time = time();

        // Adoption for lcobucci/jwt ^4.0 version
        $token = $jwt->getBuilder()
            ->issuedBy('http://ciscotest.com')// Configures the issuer (iss claim)
            ->permittedFor('http://ciscotest.org')// Configures the audience (aud claim)
            ->identifiedBy('4f1g23a12aa', true)// Configures the id (jti claim), replicating as a header item
            ->issuedAt($time)// Configures the time that the token was issue (iat claim)
            ->expiresAt($time + 3600)// Configures the expiration time of the token (exp claim)
            ->withClaim('uid', 100)// Configures a new claim, called "uid"
            ->getToken($signer, $key); // Retrieves the generated token

        return $this->asJson([
            'token' => (string)$token,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionCreateRouter()
    {
    	$post = Yii::$app->request->post();

    	// check request body parameters
    	if(!isset($post["loopback"]) || !isset($post["hostname"])) {
    		return $this->asJson([
	            'success' => false,
	            'status' => 400,
	            'message' => 'Invalid Request. loopback & hostname is required.'
	        ]);
    	}

    	$model = new Routers();

    	$model->type = "AG1";
    	$model->loopback = $post["loopback"];
    	$model->hostname = $post["hostname"];

    	//generate random value for other unique columns
    	$model->sapid = $this->generateRandomString(18); // 18 digit random value
    	$model->mac_address = $this->generateRandomString(3).":".rand(0,9).$this->generateRandomString(2).":".rand(00,99).":".$this->generateRandomString(3).":".rand(00,99);

		if($model->validate()) {
        	if($model->save()) {
        		return $this->asJson([
		            'success' => true,
		            'status' => 200,
		            'message' => 'Record inserted successfully.'
		        ]);
        	} else {
        		return $this->asJson([
		            'success' => false,
		            'status' => 400,
		            'message' => 'Oops! something went wrong! please try again.'
		        ]);
        	}
		} else {
			return $this->asJson([
	            'success' => false,
	            'status' => 400,
	            'message' => json_encode($model->getErrors())
	        ]);
        }
    }

    public function actionUpdateRouter() {
    	$post = Yii::$app->request->post();

    	// check request body parameters
    	if(!isset($post["ip"])) {
    		return $this->asJson([
	            'success' => false,
	            'status' => 400,
	            'message' => 'Invalid Request. IP is required.'
	        ]);
    	}

    	$model = Routers::find()->where(['hostname' => $post["ip"], 'status' => Routers::ACTIVE])->one();
    	
    	if(!$model){
    		return $this->asJson([
	            'success' => false,
	            'status' => 400,
	            'message' => 'No record found for rovided IP - '.$post["ip"]
	        ]);
    	}

    	$model->sapid = isset($post["sapid"]) ? $post['sapid'] : $this->generateRandomString(18); // 18 chars random value
    	$model->loopback = isset($post["loopback"]) ? $post['loopback'] : $this->generateRandomString(14); // 14 chars random value
    	$model->mac_address = $this->generateRandomString(3).":".rand(0,9).$this->generateRandomString(2).":".rand(00,99).":".$this->generateRandomString(3).":".rand(00,99);

    	if($model->update()) {
    		return $this->asJson([
	            'success' => true,
	            'status' => 200,
	            'message' => $post["ip"].' record updated successfully.'
	        ]);
    	} else {
    		return $this->asJson([
	            'success' => false,
	            'status' => 400,
	            'message' => 'Oops! something went wrong! please try again.'
	        ]);
    	}
    	
    }


    public function actionDeleteRouter() {
    	$post = Yii::$app->request->post();

    	// check request body parameters
    	if(!isset($post["ip"])) {
    		return $this->asJson([
	            'success' => false,
	            'status' => 400,
	            'message' => 'Invalid Request. IP is required.'
	        ]);
    	}

    	$model = Routers::find()->where(['hostname' => $post["ip"], 'status' => Routers::ACTIVE])->one();
    	
    	if(!$model){
    		return $this->asJson([
	            'success' => false,
	            'status' => 400,
	            'message' => 'No record found for provided IP - '.$post["ip"]
	        ]);
    	}

    	$model->status = 0;

    	if($model->update()) {
    		return $this->asJson([
	            'success' => true,
	            'status' => 200,
	            'message' => $post["ip"].' record deleted successfully.'
	        ]);
    	} else {
    		return $this->asJson([
	            'success' => false,
	            'status' => 400,
	            'message' => 'Oops! something went wrong! please try again.'
	        ]);
    	}
    	
    }


    public function actionRoutersBySapid($sapId, $type="") {
    	
    	$condition = !empty($type) ? ['sapid' => $sapId, 'type' => $type] : ['sapid' => $sapId];
    	$model = Routers::findOne($condition);
    	
    	if(!$model) {
    		return $this->asJson([
	            'success' => false,
	            'status' => 404,
	            'message' => 'Oops! no router details found for - '.$sapId
	        ]);
    	} 

    	return $this->asJson([
            'success' => true,
            'status' => 200,
            'data' => $model->attributes
        ]);
    }


    public function actionRoutersByRange($start, $end) {

    	$models = Routers::find()->andWhere(['BETWEEN', 'hostname', $start, $end])->all();
    	
    	if(!$models) {
    		return $this->asJson([
	            'success' => false,
	            'status' => 404,
	            'message' => 'Oops! no router details found for - '.$sapId
	        ]);
    	} 

    	return $this->asJson([
            'success' => true,
            'status' => 200,
            'total' => count($models),
            'data' => $models
        ]);
    }


    private function generateRandomString($strength = 16, $input = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ") {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }     
        return $random_string;
    }

    /**
     * Finds the Routers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Routers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Routers::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
