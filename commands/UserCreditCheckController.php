<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\UserRecords;
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
class UserCreditCheckController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
       
        $query= User::find();
        foreach ($query->each() as $user) {
            if ($user->allocated_credits > 0) {
                $allocated_used_credits = UserRecords::find()->where(['user_id' => $user->id, 'credit_type' => User::CREDITS_ALLOCATED])->sum('credit_used');
                $remaining_allocated_credits =  $user->allocated_credits - $allocated_used_credits;
                if ($remaining_allocated_credits < 30) {
                    $userModel= User::find($user->id);
                    $userModel->sendEmailNotificationCreditLow($user->id);
                }
            }
        }
    }
       
    
}
