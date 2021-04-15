<?php
namespace app\controllers;
use app\models\Plans;
use app\models\UserPlans;
use app\models\Transactions;
use Yii;
use yii\db\IntegrityException;
use app\models\CancelPlanForm;

class PaymentController extends BaseController
{
    public $layout = 'inner-layout';

    public function actionProduct()
    {
        //UserPlans::find()->where(['user_id'=> Yii::$app->user->identity->id, 'plan_id' => $id])->andWhere(['is_expire'=> 0])->one();
        $request = Yii::$app->request;
        $id = $request->get('plan_id');
        $usermodel = Yii::$app->user->identity;
        $planModel= Plans::findOne($id);
        $model = new UserPlans();
        try {
            if ($model->load(Yii::$app->request->post())) {
                $paystack = Yii::$app->Paystack;
                $ref = $paystack->generateRef();
                $email = $usermodel->email;
                $currency = $planModel->currency;
                $amount= $planModel->price;
                $amount = ($currency == 'NGN') ? ($amount * 100) : $amount;
                $data = array('reference'=>$ref,'amount'=>$amount,'email'=>$email , 'currency' => $currency);
                $transaction = $paystack->transaction();
                $transaction->setRequestOptions($data);
                $transaction->initialize();
                if (!$transaction->hasError) {
                    $model->reference_id= $ref;
                    if($model->save()){
                        $transaction->redirect();
                    }else{
                        return $model->errors;
                    }                 
                } else {
                    return $transaction->getError();
                   
                }
            }
        }catch(\Exception $e){
        return $e->getMessage();
        }
        
        return $this->render("product", array(
            'model' => $model,
            'planModel' => $planModel,
            'usermodel' => $usermodel,
        ));
    }

    public function actionDetails()
    {  
        $request = Yii::$app->request;
        $trxref = $request->get('trxref');
        try {
            $userplans = UserPlans::find()->where(['reference_id' => $trxref])->one(); 
            if (!empty($userplans)) {
                if (isset($trxref) && !empty($trxref)) {
                    $paystack = Yii::$app->Paystack;
                    $transaction = $paystack->transaction()->setRequestOptions($trxref);
                    $transaction->verify();
                    if (!$transaction->hasError) {
                        $model= new Transactions();
                        $model->reference_id= $trxref;
                        $model->amount_paid= $transaction->data['amount'];
                        $model->domain = $transaction->data['domain'];
                        $model->status =  $transaction->data['status'];
                        $model->gateway_response =  $transaction->data['gateway_response'];
                        $model->channel =$transaction->data['channel'];
                        $model->currency =$transaction->data['currency'];
                        $model->ip_address =$transaction->data['ip_address'];
                        $model->customer_code =$transaction->data['customer']['customer_code'];
                        $model->authorization_code=$transaction->data['authorization']['authorization_code'];
                        $model->card_type=$transaction->data['authorization']['card_type'];
                        $model->bank=$transaction->data['authorization']['bank'];
                        $model->country_code=$transaction->data['authorization']['country_code'];
                        $model->brand=$transaction->data['authorization']['brand'];
                        $model->signature=$transaction->data['authorization']['signature'];
                        $model->created_at = $transaction->data['paid_at'];
                        if ($model->save()) {
                            $userplans = UserPlans::find()->where(['reference_id' => $trxref])->with('plans')->one();
                            if ($userplans) {
                                $userplans->status= '1';
                                $userplans->credits= $userplans->plans->number_credits;
                                $userplans->created_at= strtotime($transaction->data['paid_at']);
                                $effectiveDate = strtotime('+'.$userplans->plans->validity. 'months', strtotime($transaction->data['paid_at']));
                                $userplans->expiration_date= $effectiveDate;  
                                $userplans->save();
                                Yii::$app->getSession()->setFlash('success', 'Your payement has been processed successfully.');
                                return $this->redirect(["payment/confirm"]);
                             }
                        } else {
                          //  return $this->render("confirm");
                           // var_dump($model->getError);
                        }
                    } else {
                        var_dump($transaction->getError);
                    }
                }
            }
        }
        catch (IntegrityException $e) {
            return $this->redirect(["site/front"]);
        }
        catch(\Exception $e){
            Yii::$app->getSession()->setFlash('error',  $e->getMessage());
             return $this->redirect(["site/front"]);
        }
    
    }

    public function actionConfirm()
    {
      return $this->render('confirm');
    }


    public function actionCancel() {
        try {
            $model= new CancelPlanForm();
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if (Yii::$app->request->isAjax) {
                if ($model->load(Yii::$app->request->post())) {
                    $planModel= UserPlans::findOne($model->id);
                    $planModel->is_cancel= $model->is_cancel;
                    $planModel->credits=0;
                    if ($planModel->save()) {
                    return [
                      'data' => [
                          'success' => true,
                          'id' => $model->id,
                           'message' => 'Plan Cancelled Successfully'
                      ],
                      'code' => '0'
                  ];
                    } else {
                        return [
                      'data' => [
                          'error' => true,
                          'id' => '0',
                          'redirect_uri' => 'null',
                          'message' =>  $planModel->getFirstErrors()
                      ]
                  ];
                    }
                } else {
                 //   return $model->errors;
                }
            } else {
              //  return $model->errors;
            }
        }catch(\Exception $e){
         return $e->getMessage();
        }
      
    }
    public function actionTransactionList()
    {
        $paystack = Yii::$app->Paystack;

        $transaction = $paystack->transaction()->fetchAll();

   
        if (!$transaction->hasError)
        {
            var_dump($transaction->status);
            var_dump($transaction->message);
            var_dump($transaction->data);
            //$transaction->redirect();
        }
        else
        {
            var_dump($transaction->getError());
        }
    }

    public function actionTransactionFetch()
    {
        $paystack = Yii::$app->Paystack;

        $transaction = $paystack->transaction();
        $transaction->fetch(598615);

        var_dump($transaction->status);
        var_dump($transaction->message);
        var_dump($transaction->data);
    }

    public function actionTransactionCharge()
    {
        $paystack = Yii::$app->Paystack;

        $transaction = $paystack->transaction();
        $transaction->charge(array('amount'=>100000,'email'=>'smladeoye@ymail.com'));

        var_dump($transaction->status);
        var_dump($transaction->message);
        var_dump($transaction->data);
    }

    public function actionTransactionTimeline()
    {
        $paystack = Yii::$app->Paystack;

        $transaction = $paystack->transaction();
        $transaction->timeline(598615);

        var_dump($transaction->status);
        var_dump($transaction->message);
        var_dump($transaction->data);
    }

    public function actionTransactionTotal()
    {
        $paystack = Yii::$app->Paystack;

        $transaction = $paystack->transaction();
        $transaction->total();

        var_dump($transaction->status);
        var_dump($transaction->message);
        var_dump($transaction->data);
    }

    public function actionTransactionExport()
    {
        $paystack = Yii::$app->Paystack;

        $transaction = $paystack->transaction();

        $transaction->export();

        //get export url
        $url = $transaction->getExportUrl();

        //download the exported data
        $transaction->download();
    }

    public function actionCustomerCreate()
    {
        $paystack = Yii::$app->Paystack;

        $email = 'smladeoye@ymail.com';
        $data = array('email'=>$email);

        $customer = $paystack->customer()->setRequestoptions($data);
        $customer->create();

        var_dump($customer->status);
        var_dump($customer->message);
        var_dump($customer->data);
        var_dump($customer->response);
    }

    public function actionCustomerList()
    {
        $paystack = Yii::$app->Paystack;

        $data = array('page'=>1,'perPage'=>30);

        $customer = $paystack->customer()->setRequestOptions($data);
        $customer->fetchAll();

        var_dump($customer->status);
        var_dump($customer->message);
        var_dump($customer->data);
    }

    public function actionCustomerFetch()
    {
        $paystack = Yii::$app->Paystack;


        $customer = $paystack->customer()->setRequestOptions(100466);
        $customer->fetch();

        var_dump($customer->status);
        var_dump($customer->message);
        var_dump($customer->data);
    }

    public function actionCustomerUpdate()
    {
        $paystack = Yii::$app->Paystack;

        $data = array('phone'=>'ade');

        $customer = $paystack->customer();
        $customer->update(100466,$data);

        var_dump($customer->status);
        var_dump($customer->message);
        var_dump($customer->data);
    }

    public function actionCustomerWhitelist()
    {
        $paystack = Yii::$app->Paystack;

        $data = array('phone'=>'ade');

        $customer = $paystack->customer();
        $customer->whitelist(100466);

        var_dump($customer->status);
        var_dump($customer->message);
        var_dump($customer->data);
    }

    public function actionCustomerBlacklist()
    {
        $paystack = Yii::$app->Paystack;

        $data = array('phone'=>'ade');

        $customer = $paystack->customer();
        $customer->blacklist(100466);

        var_dump($customer->status);
        var_dump($customer->message);
        var_dump($customer->data);
    }

    public function actionSubaccountCreate()
    {
        $paystack = Yii::$app->Paystack;

        $email = 'smladeoye@ymail.com';
        $data = array('primary_contact_email'=>$email,'business_name'=>'something','settlement_bank'=>'first bank','account_number'=>'123456789','percentage_charge'=>'20');

        $subaccount = $paystack->subaccount()->setRequestoptions($data);
        $subaccount->create();

        var_dump($subaccount->status);
        var_dump($subaccount->message);
        var_dump($subaccount->data);
    }

    public function actionSubaccountList()
    {
        $paystack = Yii::$app->Paystack;

        $subaccount = $paystack->subaccount();
        $subaccount->fetchAll();

        var_dump($subaccount->status);
        var_dump($subaccount->message);
        var_dump($subaccount->data);
    }

    public function actionSubaccountFetch()
    {
        $paystack = Yii::$app->Paystack;

        $subaccount = $paystack->subaccount()->setRequestoptions(765);
        $subaccount->fetch();

        var_dump($subaccount->status);
        var_dump($subaccount->message);
        var_dump($subaccount->data);
    }

    public function actionSubaccountUpdate()
    {
        $paystack = Yii::$app->Paystack;

        $data = array('primary_contact_email'=>'ade@yahoo.com');

        $subaccount = $paystack->subaccount();
        $subaccount->update('765',$data);

        var_dump($subaccount->status);
        var_dump($subaccount->message);
        var_dump($subaccount->data);
    }

    public function actionSubaccountListBanks()
    {
        $paystack = Yii::$app->Paystack;

        $subaccount = $paystack->subaccount();
        $subaccount->listBank();

        var_dump($subaccount->status);
        var_dump($subaccount->message);
        var_dump($subaccount->data);
    }

    public function actionPlanCreate()
    {
        $paystack = Yii::$app->Paystack;

        $data = array('name'=>'test2','interval'=>\smladeoye\paystack\Paystack::PLAN_INTERVAL_WEEKLY,'amount'=>'20000');

        $plan = $paystack->plan()->setRequestoptions($data);
        $plan->create();

        var_dump($plan->status);
        var_dump($plan->message);
        var_dump($plan->data);
    }

    public function actionPlanList()
    {
        $paystack = Yii::$app->Paystack;

        $plan = $paystack->plan();
        $plan->fetchAll();

        var_dump($plan->status);
        var_dump($plan->message);
        var_dump($plan->data);
    }

    public function actionPlanFetch()
    {
        $paystack = Yii::$app->Paystack;

        $plan = $paystack->plan()->setRequestoptions(2532);
        $plan->fetch();

        var_dump($plan->status);
        var_dump($plan->message);
        var_dump($plan->data);
    }

    public function actionPlanUpdate()
    {
        $paystack = Yii::$app->Paystack;

        $data = array('amount'=>'40000');

        $plan = $paystack->plan();
        $plan->update('2532',$data);

        var_dump($plan->status);
        var_dump($plan->message);
        var_dump($plan->data);
    }

    public function actionSubscriptionCreate()
    {
        $paystack = Yii::$app->Paystack;

        $email = 'smladeoye@ymail.com';
        $data = array('plan'=>'PLN_c6gz1bcbhjuhb7z','customer'=>$email);

        $subscription = $paystack->subscription()->setRequestoptions($data);
        $subscription->create();

        var_dump($subscription->status);
        var_dump($subscription->message);
        var_dump($subscription->data);
    }

    public function actionSubscriptionList()
    {
        $paystack = Yii::$app->Paystack;

        $subscription = $paystack->subscription();
        $subscription->fetchAll();

        var_dump($subscription->status);
        var_dump($subscription->message);
        var_dump($subscription->data);
    }

    public function actionSubscriptionFetch()
    {
        $paystack = Yii::$app->Paystack;

        $subscription = $paystack->subscription();
        $subscription->fetch('SUB_htnzp14rytxyh2o');

        var_dump($subscription->status);
        var_dump($subscription->message);
        var_dump($subscription->data);
    }

    public function actionSubscriptionEnable()
    {
        $paystack = Yii::$app->Paystack;

        $subscription = $paystack->subscription();
        $subscription->enable('SUB_htnzp14rytxyh2o','refwxvdh6gq1d7y');

        var_dump($subscription->status);
        var_dump($subscription->message);
        var_dump($subscription->data);
    }

    public function actionSubscriptionDisable()
    {
        $paystack = Yii::$app->Paystack;

        $subscription = $paystack->subscription();
        $subscription->disable('SUB_htnzp14rytxyh2o','refwxvdh6gq1d7y');

        var_dump($subscription->status);
        var_dump($subscription->message);
        var_dump($subscription->data);
    }

    public function actionPageCreate()
    {
        $paystack = Yii::$app->Paystack;

        $page = $paystack->page()->setRequestoptions(['name'=>'smladeoye']);
        $page->create();

        var_dump($page->status);
        var_dump($page->message);
        var_dump($page->data);
    }

    public function actionPageList()
    {
        $paystack = Yii::$app->Paystack;

        $page = $paystack->page();
        $page->fetchAll();

        var_dump($page->status);
        var_dump($page->message);
        var_dump($page->data);
    }

    public function actionPageFetch()
    {
        $paystack = Yii::$app->Paystack;

        $page = $paystack->page()->setRequestoptions('GS5OeTCeur');
        $page->fetch();

        var_dump($page->status);
        var_dump($page->message);
        var_dump($page->data);
    }

    public function actionPageUpdate()
    {
        $paystack = Yii::$app->Paystack;

        $data = array('description'=>'testing payge slug');

        $page = $paystack->page();
        $page->update('GS5OeTCeur',$data);

        var_dump($page->status);
        var_dump($page->message);
        var_dump($page->data);
    }

    public function actionPageAvailability()
    {
        $paystack = Yii::$app->Paystack;

        $page = $paystack->page();
        $page->checkAvailability('GS5OeTCeur');

        var_dump($page->status);
        var_dump($page->message);
        var_dump($page->data);
    }

    public function actionSettlementList()
    {
        $paystack = Yii::$app->Paystack;

        $settlement = $paystack->settlement();
        $settlement->fetchAll();

        var_dump($settlement->status);
        var_dump($settlement->message);
        var_dump($settlement->data);
        var_dump($settlement->meta);
    }
}
?>
