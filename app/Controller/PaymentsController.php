<?php

//TODO: This page has error in receiving from gateway

class PaymentsController extends AppController{
    
    
    public $publicActions = array('onlineSend','onlineReceive','send');
    public $uses = array('Payment');
    protected $_nusoap = null;
    
    
/**
 * Before redirect to Payment::send() must be set several param
 * 
 * @param mixed $price  : Price that user must be pays
 * @param mixed $referer : Program redirect to this address after transaction is complete
 * @param mixed $ref_id  : unique string for this pay, this ref_id used for later request such as verifyPayment
 * @param array otherInfo : other optional info that we want show in send payment page 
 *              served index
 *                  Section = indicate this payment is for which section
 * @return void
 */
    public function _setParams($price, $referer, $ref_id, $otherInfo = array()){
        $pay = array();
        //Total of payment
        $pay['price'] = $price;
        
        $pay['priceWithTax'] = $this->_addTax($price);
        
        if(!empty($otherInfo['noTax'])){
            $pay['priceWithTax'] = $price;
        }
        
        //Redirect to this action
        $pay['ref_url'] = $referer;
        
        // Id for verify payment
        $pay['ref_id'] = $ref_id;
        
        $pay['info'] = $otherInfo;
        return $this->Session->write('Payment-Params',$pay);
    }
    
/**
 * Get parameters from session
 * 
 * @param mixed $key
 * @return
 */
    protected function _getParam($key = null){
        if(is_null($key)){
            return $this->Session->read('Payment-Params');
        }
        return $this->Session->read('Payment-Params.'.$key);
    }
    
    protected function _removeParam(){
        return $this->Session->delete('Payment-Params');
    }
    
/**
 * Save current Session and other info in OnlinePayment Model
 * Then redirect user to gateway
 * 
 * @param $gate Gateway for pay 
 *          enbank
 *          postbank
 *          tejaratbank
 * @return void
 */
    public function onlineSend($gate = null){
        // read Payment Info from session
        // all actions must be store their payment params in session['Payment-Params']
        $params = $this->_getParam();
        
        if(is_null($params)){
            $this->Session->setFlash('اشکال در دریافت اطلاعات','alert',array('type' => 'error'));
            $this->redirect($this->referer());
        }
        //TODO: comment this, because if we click twice, session is removed and we won't it
        // Delete info from Session
        //$this->Session->delete('Payment-Params');
        
        // Check this referer_id is not in table
        $payInfo = $this->Payment->find('first',array('conditions' =>array('ref_id' => $params['ref_id'])));
        
        // if this request is saved in table
        if($payInfo){
            // if payed , user cann't pay again
            if($payInfo['Payment']['status']){
                $this->Session->setFlash('این درخواست قبلا پرداخت شده است','alert',array('type' => 'error'));
                $this->redirect($params['ref_url']);
            }
            $this->Payment->id = $payInfo['Payment']['id'];
        }
        
        // Store all data in session info in table , for new or current row (if has one row) 
        $this->Payment->save(array(
            'price'   => $params['priceWithTax'],
            'ref_id'  => $params['ref_id'],
            )
        );
        
        $this->set('price',$params['priceWithTax']);
        $this->set('res_num',$this->Payment->id);
        
        switch($gate){
            case 'postbank':
                $this->_pbSend();
                break;
            case 'tejaratbank':
                $this->_tbSend();
                break;
            default:
                $this->_enSend();
                break;
        }
    }

/**
 * Recieve data from gateway then check verify transaction and save info in OnlinePayment aand Payment
 * 
 * @return
 */
    public function onlineReceive($gateway = null){
        $params = array();
        switch($gateway){
            case 'postbank':
                $params = $this->_pbReceive();
                break;
            case 'tejaratbank':
                $params = $this->_tbReceive();
                break;
            default:
                $params = $this->_enReceive();
        }
        $params['ref_url'] = $this->_getParam('ref_url');
        $this->set($params);
    }

    /**
     * Return url of send Page that must be show for users
     */ 
    public function _sendPage(){
        $url = array('controller' => 'payments', 'action' => 'send', 'plugin' => false );
        $prefixes = Router::prefixes();
        
        foreach($prefixes as $prefix){
            $url[$prefix] = false;
        }
        return $url;
    }
    
    public function send(){
        $this->set('section', $this->Session->read('Payment-Params.info.Section'));
        $this->set('price', $this->Session->read('Payment-Params.price'));
        $tax = $this->_addTax($this->Session->read('Payment-Params.price'), false);
        if($this->Session->read('Payment-Params.info.noTax')){
            $tax = 0;
        }
        $this->set('tax', $tax);
        $this->set('priceWithTax', $this->Session->read('Payment-Params.priceWithTax'));
        if(! $this->_getParam()){
            $this->Session->setFlash('اشکال در دریافت اطلاعات پرداخت','alert',array('type' => 'error'));
            $this->redirect($this->homepages[$this->Auth->user('Role.name')]);
        }
        
        // Check this referer_id is not in table
        $payInfo = $this->Payment->find('first',array('conditions' =>array('ref_id' => $this->_getParam('ref_id'))));

        // if this request is saved in table
        if($payInfo and $payInfo['Payment']['ref_num'] !== null){
            $this->Session->setFlash('این درخواست قبلا پرداخت شده است','alert',array('type' => 'error'));
            $this->redirect($this->_getParam('ref_id'));
        }
        // if has row without ref_num , update it
        $this->Payment->id = (! empty($payInfo))?$payInfo['Payment']['id']:false;
        
        if($this->request->is('post')){
            // can't send empty data
            // i don't check it in model validation because i want ref_num can be null for online payment
            // but i don't empty it in offline payment
            if(empty($this->request->data['ref_num']) or empty($this->request->data['pay_date'])){
                return $this->Session->setFlash('تمامی فیلدها تکمیل گردد','alert',array('type' => 'error'));
            }
            
            $this->request->data['price'] = $this->_getParam('price');
            $this->request->data['ref_id'] = $this->_getParam('ref_id');
            $this->request->data['status'] = 0;
            $this->request->data['person_id'] = $this->_givePersonInfo('Person.id');
            if($this->Payment->save($this->request->data)){
                $this->Session->setFlash('اطلاعات پرداخت ثبت گردید','alert',array('type' => 'success'));
                $refUrl = $this->_getParam('ref_url');
                $this->_removeParam();
                $this->redirect($refUrl);
            }else{
                $this->Session->setFlash('اشکال در ثبت اطلاعات پرداخت','alert',array('type' => 'error'));
            }
        }
    }
    /**
     * while we redirect to bank is possible session expired
     * so we must save all session data in table and when receive info from bank
     * if session expired create it again
     * @param $id : ID column of Payments table
     */
     //TODO: We don't use this method
    function _manageSession($id){
        
        // Get session info from table
        $pay = $this->OnlinePayment->read(null,$id);
        $session = unserialize($pay['OnlinePayment']['session']);
        if(empty($pay['OnlinePayment']['session'])){
            return false;
        }
        
        // Get current Session
        $currentSession = $this->Session->read();
        
        // give Config param from session and delete it from $currentSession
        $config = $currentSession['Config'];
        unset($currentSession['Config']);
        
        // if current Session is empty
        if(empty($currentSession)){
            // Merge stored session with current session
            $_SESSION = array_merge($session,$this->Session->read());
        }
        return true;
    }
    
    /**
     * Check given price that equal with recieved price via transaction
     * 
     * @param mixed $ref_id referer that must be send 
     * @param mixed $price original price 
     * @return true or false
     */
    function _verifyOnlinePayment($ref_id,$price){
        $pay = $this->Payment->find('first',array(
                'conditions' =>array('Payment.ref_id' => $ref_id)
                )
        );
        if(! $pay['Payment']['verify'])
            return false;
        
        return ($pay['Payment']['verify'] == $price);
    }
    
        /**
     * Return payment info for given refID
     * 
     * @param string $refID, reference id 
     * @return array: info of payment
     */
    public function _getPaymentInfo($refID){
        if(! $refID){
            return false;
        }
        
        $info = $this->Payment->find('first',array(
            'conditions' => array(
                'Payment.ref_id' => $refID,
                'Payment.ref_num IS NOT NULL', 
            ),
            'order' => ' Payment.id DESC',
            'contain' => false,
        )); 
        
        if(empty($info)){
            return array();
        }
        // return null for every row that has no data
        // this rows created for online payments, when user send data and we have no recieved data
        if($info['Payment']['ref_num'] === null){
            return array();
        }
        return $info['Payment'];
    }
    
        public function _pageOfOptions(){
        $prefixes = Router::prefixes();
        $url = array('controller' => 'payments','action' => 'send','plugin' => false);
        foreach($prefixes as $prefix){
            $url[$prefix] = false;
        }
        return  $url;
    }
    
    public function admin_index(){
        //escape empty rows
        // this rows created for online payments, 
        $this->paginate['conditions'][] = 'Payment.ref_num IS NOT NULL' ;
        $this->paginate['order'] = 'Payment.id DESC';
        $this->set('payments',$this->paginate());
    }
    
    /**
     * change status payment
     * 
     * @return void
     */
    public function admin_changeStatus(){
        
        // extract given params
        extract($this->request->named);
        
        // only can have two status
        $status = ($status == 1)?1:-1;
        
        $this->Payment->id = $pay_id;
        
        if(! $this->Payment->exists()){
            $this->Session->setFlash('چنین پرداختی وجود ندارد','alert',array('type' => 'error'));
            $this->redirect($this->referer());
        }
        
        if($this->request->is('post')){
            if($this->Payment->saveField('status',$status)){
                $this->Session->setFlash('پرداخت ویرایش گردید','alert',array('type' => 'success'));
            }else{
                $this->Session->setFlash('اشکال در ویرایش پرداخت','alert',array('type' => 'error'));
            }
        }
        $this->redirect($this->referer());
    }
    
    function admin_reverse($ref = null, $price = null){
        $res = $this->_reverseTrans( $ref , $price);
        if( $res == 1 )
        	echo 'reversed successfully' ;
        else
        	echo $this->__enErrorVerify[$res];
        $this->autoRender = false;
    }
    
    
/** 
 * Eghtesad novin
 */
    private $__enMerchantID = '00109145-114669';
    private $__enPassword = '456979';
    private $__enWSDL = 'https://modern.enbank.net/ref-payment/ws/ReferencePayment?WSDL' ;
    private $__enURL = 'https://modern.enbank.net/CardServices/controller';
    private $__enErrorResponse = array(
        'Canceled By User'     => 'تراکنش بوسيله خريدار کنسل شده',
        'Invalid Amount'       => 'مبلغ سند برگشتي  از مبلغ تراکنش اصلي بيشتر است',
        'Invalid Transaction'  => 'درخواست برگشت تراکنش رسيده است در حالي که تراکنش اصلي پيدا نمي شود',
        'Invalid Card Number'  => 'شماره کارت اشتباه است',
        'Invalid Card'         => 'اطلاعات وارده نادرست است و یا کارت غیرفعال می باشد',
        'No Such Issuer'       => 'چنين صادر کننده کارتي وجود ندارد',
        'Expired Card Pick Up' => 'از تاريخ انقضاي کارت گذشته است',
        'Incorrect PIN'        => 'رمز کارت اشتباه است pin',
        'No Sufficient Funds'  => 'موجودي به اندازه کافي در حساب شما نيست',
        'Issuer Down Slm'      => 'سيستم کارت بانک صادر کننده فعال نيست',
        'TME Error'            => 'خطا در شبکه بانکي',
        'Exceeds Withdrawal Amount Limit'      => 'مبلغ بيش از سقف برداشت است',
        'Transaction Cannot Be Completed'      => 'امکان سند خوردن وجود ندارد',
        'Allowable PIN Tries Exceeded Pick Up' => 'رمز کارت 3 مرتبه اشتباه وارد شده کارت شما غير فعال خواهد شد',
        'Response Received Too Late'           => 'تراکنش در شبکه بانکي تايم اوت خورده',
        'Suspected Fraud Pick Up'              => 'اشتباه وارد شده cvv2 ويا ExpDate فيلدهاي'
     );
    private $__enErrorVerify = array(
        '-1' => 'خطای داخلی شبکه',
        '-2' => 'سپرده ها برابر نیستند',
        '-3' => 'ورودی ها حاوی کاراکترهای غیر مجاز میباشد',
        '-4' => 'کلمه عبور یا کد فروشنده اشتباه است',
        '-5' => 'خطای بانک اطلاعاتی',
        '-6' => 'سند قبلا برگشت کامل خورده',
        '-7' => 'رسید دیجیتالی تهی است',
        '-8' => 'طول ورودی ها بیشتر از حد مجاز است',
        '-9' => 'وجود کارکترهای غیر مجاز در مبلغ برگشتی',
        '-10' => 'رسید دیجیتالی حاوی کارکترهای غیر مجاز است',
        '-11' => 'طول ورودی ها کمتر از حد مجاز است',
        '-12' => 'مبلغ برگشتی منفی است',
        '-13' => 'مبلغ برگشتی برای برگشت جزیی بیش از مبلغ برگشت نخورده رسید دیجیتالی است',
        '-14' => 'چنین تراکنشی تعریف نشده است',
        '-15' => 'مبلغ برگشتی به صورت اعشاری داده شده',
        '-16' => 'خطای داخلی سیستم',
        '-17' => 'برگشت زدن تراکنشی که با کارت بانکی غیر از بانک اقتصاد نوین انجام شده',
        '-18' => 'فروشنده نامعتبر است ip address'
    );
    protected function _enSend(){
        $this->set('mid',$this->__enMerchantID);
        $this->set('url',$this->__enURL);
        $this->render('send_en');
    }
    protected function _enReceive(){
        // Get Info from bank
        $form = $_POST;
        // have no info
        if(empty($form)){
            $this->set('ref_url',$this->_getParam('ref_url'));
            return array('ref_url' => $this->_getParam('ref_url'));
        }
        $pay = array();
        $pay['ref_num'] = @$form['RefNum'];
        $pay['cus_ref_num'] = @$form['CustomerRefNum'];
        $pay['online_state'] = $form['State'];
        $pay['type'] = 'آنلاین - بانک اقتصاد نوین';
        $pay['person_id'] = $this->_givePersonInfo('Person.id');
        $pay['pay_date'] = Jalali::dateTime();
        
        //Save info into table
        $this->Payment->id = $form['ResNum'];
        
        if(! $this->Payment->exists()){
            $this->Session->setFlash('اطلاعات پرداختی یافت نشد');
            return false;
        }
        //Read info from table
        $payInfo = $this->Payment->read();
        
        // This request is payed before
        if($payInfo['Payment']['status']){
            $this->Session->setFlash('تراکنش قبلا تائید شده است');
            return false;
        }
        if(! $this->Payment->save($pay)){
            $this->Session->setFlash('اشکال در ذخیره اطلاعات');
            return false;
        }
        
        //Read info from table
        $payInfo = $this->Payment->read();
        
        // Construct this variables  
        $verify = false; // if true means transaction is verified or not it is false
        $error = null;  // contain error message title
        $msg = null;    // contain message must be show to user
        
        // get state, when state is not OK show it to user
        $res = $form['State'];
        
        // if every thing is OK call this method
        if($form['State'] == 'OK' && !empty($form['RefNum'])){
            
            // verify
            $res = $this->_enVerify($form['RefNum']);
        }
        // error in calling web method
        if($res === false){
            $verify = false;
            $msg = 'تراکنش با موفقیت انجام نشد';
            $error = 'اشکال در تائید پرداخت';
        }
        
        // state is not OK
        elseif(! is_numeric($res)){
            $verify = false;
            $msg = 'تراکنش با موفقیت انجام نشد';
            $error = $this->__enErrorResponse[$res];
            
        // web method return negetive value
        }elseif($res < 0){
            $verify = false;
            $msg = 'تراکنش با موفقیت انجام نشد';
            $error = $this->__enErrorVerify[$res];
        }else{
            
            //Save verify
            $this->Payment->save(array('online_verify' => $res));
            
            //TODO: We don't use this method because don't need it
            // if result > 0 means transaction is done, now call this method
            //$this->_manageSession($this->OnlinePayment->id);
            
            $verify = true;
            if( $res == $payInfo['Payment']['price'] ) {
                    $msg = "پرداخت با موفقيت انجام شد  لطفا کد رهگيري را يادداشت کنيد : ".$payInfo['Payment']['cus_ref_num'];

            } elseif( $res > $payInfo['Payment']['price'] ) {
                //web method partial reverse transaction
                $revAmont = $res - $payInfo['Payment']['price'];
                $reverse  = $this->_enReverseTrans($form['RefNum'], $revAmont );

                $msg = "کاربر گرامي  مبلغ پرداختي بيش از مبلغ درخواستي است";
                
                if( $reverse == 1 ) {
                    $msg .= "مابقي مبلغ پرداخت شده به حساب شما برگشت خورده";
                    $this->Payment->save(array('verify' => $payInfo['Payment']['price']));
                } else {
                    $msg .= '<br /> مبلغ اضافه :'.$revAmont;
                    $msg .= "<br /> ما بقي مبلغ پرداختي شما در اينده اي نزديک به حساب شما برگشت خواهد خورد ";
                }
                $msg .= "<br />پرداخت با موفقيت انجام شد  لطفا کد رهگيري را يادداشت کنيد : ".$payInfo['Payment']['cus_ref_num'];

            } elseif( $res < $payInfo['Payment']['price'] ) {
                $verify = false;
                $error = "مبلغ پرداختي شما کمتر از مبلغ سفارش است ";
                
                //web method full reverse transaction
                $rev     = $this->_enReverseTrans( $res );
                if( $rev == 1 ) {
                    $msg = "کل مبلغ پرداختي به حساب شما برگشت خورده است";
                } else {
                    $msg .= "در اينده اي نزديک کل مبلغ پرداختي به حساب شما برگشت خواهد خورد  لطفا کد رهگيري را يادداشت کنيد : ".$payInfo['Payment']['cus_ref_num'];
                }
            }
            
            // Submit Payment if every things is OK
            if($verify){
                //Save Status
                $this->Payment->saveField('status',1);
            }
        }
        return compact('verify','error','msg');
    }
    
    protected function _enVerify($refNum = null)
    {
        if(empty($refNum)) {
            return false;
        }
        $this->_enCreateSoap();
        $soapProxy = $this->_nusoap->getProxy() ;
        $result     = false;

        for( $a=1;$a<6;++$a ) {
            $result  = $soapProxy->VerifyTransaction($refNum , $this->__enMerchantID);
            if( $result !== false ) {
                break;
            }
        }
        return $result;
    }

    protected function _enReverseTrans( $refNumber , $price = 0)
    {
        if( empty($refNumber) or empty($price)) {
            return false;
        }
        $this->_enCreateSoap();
        $soapProxy = $this->_nusoap->getProxy() ;
        $result     = false;

        for( $a=1;$a<6;++$a ) {
            $result     = $soapProxy->reverseTransaction( $refNumber, $this->__enMerchantID, $this->__enPassword, $price );
            if( $result != false )
                break;
        }
        return $result;
    }
    
    protected function _enCreateSoap(){
        App::uses('soap_client', 'Utility');
        if($this->_nusoap)
            return;
        $this->_nusoap = new soap_client($this->__enWSDL,'wsdl');
        
    }
    
    
// Tejarat Bank
    /** Testing
    private $__tbMerchantID = 'F119';
    private $__tbWSDL = 'http://pg.sabapardazesh.net:9086/paymentGateway/services/merchant.wsdl';
    private $__tbURL = 'http://pg.sabapardazesh.net:9085/paymentGateway/page';
    */
    private $__tbMerchantID = 'A244';
    private $__tbWSDL = 'http://pg.tejaratbank.net/paymentGateway/services/merchant.wsdl';
    private $__tbURL = 'https://pg.tejaratbank.net/paymentGateway/page';
    
    private $__tbErrorResponse = array(
        '100' => 'موفقیت تراکنش',
        '110' => 'انصراف دارنده کارت',
        '120' => 'موجودی حساب کافی نیست',
        '130' => 'اطلاعات کارت اشتباه است',
        '131' => 'رمز کارت اشتباه است',
        '132' => 'کارت مسدود شده است',
        '133' => 'کارت منقضی شده است',
        '140' => 'زمان موردنظر به پایان رسیده است',
        '150' => 'خطای داخلی بانک',
        '160' => 'خطا در اطلاعات CVV2 یا تاریخ انقضا',
        '166' => 'بانک صادر کننده کارت شما مجوز انجام تراکنش را صادر نکرده است',
        '200' => 'مبلغ تراکنش بیشتر از سقف مجاز در هر تراکنش می باشد',
        '201' => 'مبلغ تراکنش بیشتر از سقف مجاز در روز می باشد',
        '202' => 'مبلغ تراکنش بیشتر از سقف مجاز در ماه می باشد',
    );
    private $__tbErrorVerify = array(
        '-20' => 'وجود کاراکترهای غیرمجاز در درخواست',
        '-30' => 'تراکنش قبلا برگشت خورده است',
        '-50' => 'طول رشته درخواست غیرمجاز است',
        '-51' => 'خطا در درخواست',
        '-80' => 'تراکنش مورد نظر یافت نشد',
        '-81' => 'خطای داخلی بانک',
        '-90' => 'تراکنش قبلا تایید شده است',
    );
    protected function _tbSend(){
        $this->set('mid',$this->__tbMerchantID);
        $this->set('url',$this->__tbURL);
        $this->render('send_tb');
    }
    
    protected function _tbReceive(){
        // Get Info from bank
        $form = $this->request->data;
        if(empty($form)){
            return false;
        }
        
        $pay = array();
        $pay['result'] = $form['resultCode'];
        $pay['ref_num'] = $form['referenceId'];
        $pay['type'] = 'آنلاین - بانک تجارت';
        $pay['status'] = 0;
        $pay['person_id'] = $this->_givePersonInfo('Person.id');
        $pay['pay_date'] = Jalali::dateTime();
        //Save info into table
        $this->Payment->id = $form['paymentId'];
        $payInfo = $this->Payment->find('first',array(
            'conditions' =>array('id' => $form['paymentId']),
            'contain' => false,
        ));
        if(empty($payInfo)){
            return false;
        }
        // This request is payed
        if($payInfo['Payment']['status']){
            return true;
        }
        $this->Payment->save($pay);
        
        //Read info from table
        $payInfo = $this->Payment->read(null);
        
        // Construct this variables  
        $verify = false;
        $error = null;
        $msg = null;
        
        $res = false;
        
        // if every thing is OK call this method
        if($payInfo['Payment']['result'] == '100'){
            // verify
            $res = $this->_tbVerify($payInfo['Payment']['ref_num']);
            // error in calling web method
            if($res > 0){
                if($res == $payInfo['Payment']['price']){
                    //Save verify
                    $this->Payment->save(array('status' => 1));
                    $msg = 'تراکنش با موفقیت انجام شد';
                    $msg .= '<br />کد پیگیری : '.$payInfo['Payment']['ref_num'];
                    $verify = true;
                }
                
            }else{
                $verify = false;
                $msg = 'تراکنش با موفقیت انجام نشد';
                $error = $this->__tbErrorVerify[$res].'<br /> کد پیگیری : '.$payInfo['Payment']['ref_num'];
            }
        }else{
            $verify = false;
            $msg = 'تراکنش با موفقیت انجام نشد';
            $error = 'اشکال در تائید پرداخت ';
            $error .= $this->__tbErrorResponse[$payInfo['Payment']['result']];
        }
        
        // Delete this row if hasn't pay
        if(! $verify){
            $this->Payment->delete();
        }
        
        return compact('verify','error','msg');
    }
    
    protected function _tbCreateSoap(){
        App::import('Utility', 'Tejarat/nusoap');
        if($this->_nusoap)
            return;
        $this->_nusoap = new nusoap_client($this->__tbWSDL,true);
    }
    
    protected function _tbVerify($ref_id){
        if(empty($ref_id)) {
            return false;
        }
        $this->_tbCreateSoap();
        $this->_nusoap->setUseCurl(0);
        $this->_nusoap->soap_defencoding = 'UTF-8';
        $this->_nusoap->decode_utf8 = true;
        $this->_nusoap->setEndpoint($this->__tbWSDL);
        $params = array("verifyRequest" => array(
            'merchantId' => $this->__tbMerchantID,
            'referenceNumber' => $ref_id
            )
        );
        return $this->_nusoap->call("verify", $params);
    }
    
// Post Bank
    private $__pbMerchantID = '59000009';
    private $__pbWSDL = 'https://www.pbi24.com/VirtualPOS/VPOS.asmx?wsdl';
    private $__pbURL = 'https://www.pbi24.com/VirtualPOS/VPOS.aspx';
    private $__pbErrorResponse = array(
        '01' => 'خطا در انجام عملیات',
        '02' => 'کد ورودی اشتباه می باشد',
        '03' => 'مبلغ دریافتی اشتباه می باشد.',
        '04' => 'شماره کارت ورودی اشتباه می باشد',
        '05' => 'ورودی اشتباه می باشد',
        '06' => 'تاریخ انقضا ورودی اشتباه می باشد',
        '07' => 'رمز دوم ورودی اشتباه می باشد',
        '08' => 'خطای سیستمی',
        '09' => 'خطای سیستمی',
        '10' => 'خطای اجرا از شتاب',
        '11' => 'خطای نامشخص',
        '12' => 'کد فروشگاه اشتباه است',
        '13' => 'درخواست کننده معتبر نمی باشد',
    );
    protected function _pbSend(){
        $this->set('mid',$this->__pbMerchantID);
        $this->set('url',$this->__pbURL);
        $this->render('send_pb');
    }
    
    protected function _pbReceive(){
        // Get Info from bank
        $form = $this->request->query;
        if(empty($form)){
            return false;
        }
        
        $pay = array();
        $response = $form['RequestResponse'];
        $response = explode(',', $response);
        $pay['result'] = $response[0];
        $pay['ref_num'] = @$response[2];
        $pay['pb_card'] = @$response[3];
        $pay['type'] = 'آنلاین - پست بانک';
        $pay['status'] = 0;
        //Save info into table
        $this->Payment->id = $form['CustomerId'];
        $payInfo = $this->Payment->find('first',array(
            'conditions' =>array('id' => $form['CustomerId']),
            'contain' => false,
        ));
        if(empty($payInfo)){
            return false;
        }
        // This request is payed before
        if($payInfo['Payment']['status']){
            return true;
        }
        $this->Payment->save($pay);
        
        //Read info from table
        $payInfo = $this->Payment->read(null);
        
        // Construct this variables  
        $verify = false;
        $error = null;
        $msg = null;
        
        $res = false;
        
        // if every thing is OK call this method
        if($payInfo['Payment']['result'] == '00'){
            // verify
            $res = $this->_pbVerify($payInfo['Payment']['pb_card'], $payInfo['Payment']['ref_num'], $payInfo['Payment']['price']);
            // error in calling web method
            if($res){
                //Save verify
                $this->Payment->save(array('status' => 1));
                $verify = true;
            }else{
                $verify = false;
                $msg = 'تراکنش با موفقیت انجام نشد';
                $error = 'اشکال در تائید پرداخت'.'<br /> کد پیگری : '.$payInfo['Payment']['ref_num'];
            }
        }else{
            $verify = false;
            $msg = 'تراکنش با موفقیت انجام نشد';
            $error = 'اشکال در تائید پرداخت';
            $error = $this->__pbErrorResponse[$payInfo['Payment']['result']];
            if(!empty($payInfo['Payment']['ref_num'])){
                $error.= '<br /> کد پیگری : '.$payInfo['Payment']['ref_num'];
            }
        }
        
        // Delete this row if hasn't pay
        if(! $verify){
            $this->Payment->delete();
        }
        
        return compact('verify','error','msg');
    }
    
    protected function _pbCreateSoap(){
        App::uses('soap_client', 'Utility');
        if($this->_nusoap)
            return;
        $this->_nusoap = new soap_client($this->__pbWSDL,'wsdl');
    }
    
    protected function _pbVerify($card, $trace, $amount){
        if(empty($card)) {
            return false;
        }
        $this->_pbCreateSoap();
        $soapProxy = $this->_nusoap->getProxy() ;
        $result     = false;

        for( $a=1;$a<6;++$a ) {
            $result  = $soapProxy->TraceCheckWithAmount($card, $trace, $amount, $this->__pbMerchantID);
            if( $result !== 'false' ) {
                $result = true;
                break;
            }
            $result = false;
        }
        
        return $result;
    }
    
    protected function _addTax($price, $priceWithTax = true){
        if($priceWithTax)
            return intval($price + (5 * $price / 100));
        return intval(5 * $price / 100);
    }
}