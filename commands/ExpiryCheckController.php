<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\UserPlans;
use app\models\User;
use Yii;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ExpiryCheckController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
        public function actionIndex($message = 'hello world')
    {
    
       $query= UserPlans::find()->innerJoin('tbl_user', 'tbl_user.id = tbl_user_plans.user_id')->select('tbl_user_plans.*')->where(['isExpire' => 0])->andWhere(['is_cancel' => 0]);
      
                
       foreach ($query->each() as $user) {
        $planModel= UserPlans::find()->where(['id' => $user->id])->one();
        $current_time_stamp = strtotime(Yii::$app->formatter->asDate('now', 'php:Y-m-d'));
     
         if($current_time_stamp == $user->expiration_date){
                $planModel->isExpire = 1;
                $planModel->credits = 0;
                $userModel= User::findOne($user->user_id);
                
                \Yii::$app->db->createCommand()
                ->update('tbl_user_plans', ['isExpire' => 1 ], ['id' => $user->id])
                ->execute();
                 
                    $userModel->sendEmailNotificationExpirePlan($user->user_id);
              
             }
        }
        return ExitCode::OK;
    }
    // public function actionIndex($message = 'hello world')
    // {
    
    //   $query= UserPlans::find()->innerJoin('tbl_user', 'tbl_user.id = tbl_user_plans.user_id')->select('tbl_user_plans.*')->where(['isExpire' => 0])->andWhere(['is_cancel' => 0]);
        
    //   foreach ($query->each() as $user) {
    //       $planModel= UserPlans::findOne($user->id);
    //       $current_time_stamp = strtotime(Yii::$app->formatter->asDate('now', 'php:Y-m-d'));
    //       if($current_time_stamp == $user->expiration_date){
    //             $planModel->isExpire = 1;
    //             $planModel->credits = 0;
    //             if($planModel->save()){
    //                 $planModel->sendEmailNotificationExpirePlan($user->id);
    //             }
    //          }
    //     }
    //     return ExitCode::OK;
    // }
}
