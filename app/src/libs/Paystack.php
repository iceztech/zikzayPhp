<?php
namespace Zikzay\lib;

/**
 *Description: ...
 *Created by: Isaac
 *Date: 6/21/2020
 *Time: 12:23 AM
 */

class Paystack{
    public $reference;
    public $amount;
    public $errorMsg;
    public $status;
    protected $paystackModel;

    public function __construct($reference){
        $this->paystackModel = new \Zikzay\Model\Paystack();
        $this->reference = $reference;
        $this->status = false;
        $this->verifyReference();
    }

    public static function init($reference) {
        return new self($reference);
    }
    protected function verifyReference()
    {
        $response = $this->queryPaystack();

        if ($response->status) {
            $this->errorMsg = $response->message;

        } else if ($this->isConfirmedRequest()) {
            $this->errorMsg = "This payment has already been credited";

      

//        } else if ($response->data->status != 'success') {
//            $this->errorMsg = "Transaction was not successful";

        } else {
            $this->successResponse($response);
        }
    }

    protected function isConfirmedRequest() {

        $paystack = \Zikzay\Model\Paystack::search('reference', $this->reference);

        if($paystack !== false){
            return $paystack->confirm;
        }else {
            $this->amount = $this->amount ? $this->amount : 1000;
            \Zikzay\Model\Paystack::$data = [
                'reference' => $this->reference,
                'amount' => $this->amount
            ];
            $this->paystackModel->save();
        }
        return false;
    }

    private function queryPaystack()
    {
        $url = 'https://api.paystack.co/transaction/verify/' . $this->reference;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, [ PAYSTACK_PRIVATE_KEY ]
        );
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }

    protected function successResponse($response){

        $amount = 1000;//$response->data->amount/100;
        if(USER_PAY_CARD_TRANSACTION_CHARGE) {
            $this->amount = round($amount - ($amount * 0.0147783251231527), 2);
        }
        \Zikzay\Model\Paystack::$data = ['confirm' => 0];
        $update = !$this->paystackModel->update(['reference' => $this->reference]);

        if($update) $this->status = true;
    }



}