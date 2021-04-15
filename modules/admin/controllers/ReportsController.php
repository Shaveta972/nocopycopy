<?php

namespace app\modules\admin\controllers;
use app\controllers\BaseController;
use app\models\search\UserSearch;
use app\models\UserPlans;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class ReportsController extends BaseController
{
    /**
     * Before Action
     */
    public function beforeAction($action)
    {
        $this->layout = 'admin'; //your layout name
        return parent::beforeAction($action);
    }

    public function actionSales()
    {
        $searchModel = new UserSearch();
      
        $dataProvider =  $searchModel->search(Yii::$app->request->queryParams);
        $query = UserPlans::find()
        ->select('tbl_user_plans.expiration_date,tbl_user_plans.created_at, tbl_user.first_name, 
         tbl_user.last_name , tbl_transactions.amount_paid , tbl_user.email, tbl_plans.title')
        ->leftJoin('tbl_transactions', '`tbl_transactions`.`reference_id` = `tbl_user_plans`.`reference_id`')
        ->leftJoin('tbl_user', '`tbl_user`.`id` = `tbl_user_plans`.`user_id`')
        ->leftJoin('tbl_plans', '`tbl_plans`.`id` = `tbl_user_plans`.`plan_id`')
        ->where(['role' => 1 ])
        ->groupBy('`tbl_user_plans`.`user_id`');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],

        ]);
        $exportDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,

        ]);
        // echo "<pre>";
        // print_r($dataProvider);
        // echo "</pre>";
        // ${exit();}
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'exportDataProvider' => $exportDataProvider,
        ]);
    }

    public function actionCredit()
    {
        //$searchModel = new UserSearch();
        // $dataProvider =  $searchModel->search(Yii::$app->request->queryParams);
        // echo "<pre>";
        // print_R($dataProvider);
        // echo "</pre>";
        // $customers = User::find();
        // $dataProvider = new ActiveDataProvider([
        //     'query' => $customers,
        //     // 'pagination' => [
        //     //     'pageSize' => 10,
        //     // ],
            
        //  ]);

        //  $exportDataProvider = new ActiveDataProvider([
        //     'query' => $customers,
        //     'pagination'=>false
        // ]);

        // ->select('tbl_user_records.credit_used , (select sum(business_credits) from tbl_user where parent_id=id) as assigned_credits, tbl_user.personal_credits, tbl_user.business_credits, tbl_user.email ,tbl_user.parent_id , sum(credit_used) as credits_used')
        // ->innerJoin('tbl_user_records', 'tbl_user.`id` = `tbl_user_records`.`user_id`')
        // ->leftJoin('tbl_user_plans up', 'up.`user_id` = tbl_suser.`id`')
        // ->groupBy('`tbl_user_records`.`user_id`');
        
        // // ->where(['tbl_user.`id`' => 24]);
        // echo "<pre>";
        // print_R($customers);
        // echo "</pre>";


        // (select sum(business_credits) from tbl_user where parent_id=u.id) as assigned_credits,
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT Count(u.id) as total_users,  
        u.email, u.title, u.first_name, u.last_name,tr.created_at as created_date, 
        (select sum(allocated_credits) from tbl_user where parent_id=u.id) as assigned_credits, 
        (select u.personal_credits+ u.business_credits + up.credits ) as total_credits, 
        up.credits as plan_credits, u.personal_credits, u.business_credits, u.parent_id,  
        tr.user_id, sum(credit_used) as credits_used FROM `tbl_user_records` as tr
        INNER JOIN  tbl_user as u on  u.id = tr.user_id
        LEFT JOIN  tbl_user_plans as up on  up.user_id = u.id where u.role=1
        GROUP BY tr.user_id");
        $dataProvider = new ArrayDataProvider([
            'allModels' => $command->queryAll(),
            'pagination' => [
                'pageSize' => 10,
            ],

        ]);
        $exportDataProvider = new ArrayDataProvider([
            'allModels' => $command->queryAll(),
            'pagination' => false,

        ]);
        
        return $this->render('creditreports', [
            'dataProvider' => $dataProvider,
            'exportDataProvider' => $exportDataProvider,
        ]);
    }

    public function actionCreditReportExport()
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT 
        u.first_name as Firstname,
        u.last_name as Lastname ,
        u.personal_credits as PersonalCredits, 
        u.business_credits as BusinessCredits, 
        up.credits as PlanCredits, 
         (select u.personal_credits+ u.business_credits + up.credits ) as TotalCredits, 
         (select sum(business_credits) from tbl_user where parent_id=u.id) as AssignedCredits, 
         sum(credit_used) as CreditsUsed,
         tr.created_at as CreatedDate  
         FROM `tbl_user_records` as tr
         INNER JOIN  tbl_user as u on  u.id = tr.user_id
         LEFT JOIN  tbl_user_plans as up on  up.user_id = u.id where u.role=1
         GROUP BY tr.user_id");
         $model = $command->queryAll();
       
         $date= date('Y-m-d');
            $filename = "NoCopyCopy_CreditReport_".$date.".xls";
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            $isPrintHeader = false;
            if (! empty($model)) {
                foreach ($model as $row) {
                    if (! $isPrintHeader) {
                    
                        echo implode("\t", array_keys($row)) . "\n";
                        $isPrintHeader = true;
                    }

                    if (empty($row['AssignedCredits'])) {
                        $row['AssignedCredits']=0;
                       }
                       if (empty($row['TotalCredits'])) {
                        $row['TotalCredits']=0;
                       }
                       if (empty($row['CreditsUsed'])) {
                        $row['CreditsUsed']=0;
                       }
                       if (empty($row['PlanCredits'])) {
                        $row['PlanCredits']=0;
                       }
                       if (empty($row['BusinessCredits'])) {
                        $row['BusinessCredits']=0;
                       }
                       if (!empty($row['CreatedDate'])) {
                        $row['CreatedDate']= date('Y-m-d' , $row['CreatedDate']);
                       }
                       
                    echo implode("\t", array_values($row)) . "\n";
                }
            }
            exit();
        
    }

    public function actionSalesReportExport()
    {
        $query = UserPlans::find()
        ->select(' tbl_user.first_name as Firstname, tbl_user.last_name as Lastname ,  tbl_user.email as Email,
        tbl_transactions.amount_paid as Amount,
        tbl_plans.title as PlanName,
        tbl_user_plans.expiration_date as Expiration_Date,
        tbl_user_plans.created_at AS Paid_at')
        ->leftJoin('tbl_transactions', '`tbl_transactions`.`reference_id` = `tbl_user_plans`.`reference_id`')
        ->leftJoin('tbl_user', '`tbl_user`.`id` = `tbl_user_plans`.`user_id`')
        ->leftJoin('tbl_plans', '`tbl_plans`.`id` = `tbl_user_plans`.`plan_id`')
        ->where(['role' => 1 ])
        ->groupBy('`tbl_user_plans`.`user_id`');
         
        $model = $query->asArray()->all();
    //    print_r($model);
    //    die();
            $date= date('Y-m-d');
            $filename = "NoCopyCopy_SalesReport_".$date.".xls";
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            $isPrintHeader = false;
            if (! empty($model)) {
                foreach ($model as $row) {
                    if (! $isPrintHeader) {
                    
                        echo implode("\t", array_keys($row)) . "\n";
                        $isPrintHeader = true;
                    }
    
                       if (!empty($row['Expiration_Date'])) {
                        $row['Expiration_Date']= date('Y-m-d' , $row['Expiration_Date']);
                       }

                       if (!empty($row['Paid_at'])) {
                        $row['Paid_at']= date('Y-m-d' , $row['Paid_at']);
                       }
                       
                    echo implode("\t", array_values($row)) . "\n";
                }
            }
            exit();
        
    }
}
