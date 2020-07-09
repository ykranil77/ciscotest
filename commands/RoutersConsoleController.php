<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

use app\models\Routers;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class RoutersConsoleController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */

    public function actionCreate($rows=0, $type="")
    {
        if($rows == 0)
            echo "Please enter no of rows you want to create. e.g. php yii routers-console/create 5" . "\n";

        if(empty($type))
            echo "Router type can not be blank. Please specify router type. e.g. AGS/CSS" . "\n";

        for($i=0; $i<$rows; $i++) {

            //create routers
            $model = new Routers();
            $model->type = $type;
            $model->sapid = $this->generateRandomString(18); // 18 digit random value
            $model->hostname = long2ip(mt_rand()+mt_rand()+mt_rand());  // IP address  
            $model->loopback = $this->generateRandomString(14); // 18 digit random value
            $model->mac_address = $this->generateRandomString(3).":".rand(0,9).$this->generateRandomString(2).":".rand(00,99).":".$this->generateRandomString(3).":".rand(00,99);
            
            //validate model
            if($model->validate()) {
                $model->save();
            }
        }

        return ExitCode::OK;
    }

    private function generateRandomString($strength = 16, $input="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ") {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }     
        return $random_string;
    }
}
