<?php

namespace Controller;

use think\Controller;

class BasicAgent extends Controller {

    protected $_agentType = array('0' => '公司总部','1'=>'首席CEO', '2' => '核心总监', '3' => '总代', '4'=>'一级', '5'=>'特约');
    protected $_selectAgent = array('1' => '首席CEO' , '2' => '核心总监', '3' => '总代', '4'=>'一级', '5'=>'特约');


    public function __construct()
    {

        parent::__construct();

        if (!session('agent') && $this->request->action() !== 'out') {
            $this->redirect('@html/Login/index');
        }
    }


    /**
     * 判断是否选择了发货人
     * @return bool
     */
    public static function checkShipmentInfo()
    {
        if (empty(session('shipment.agent_id')) || empty(session('shipment.pro_id')) || empty(session('shipment.take_user_id'))) {
            return false;
        }
        return true;
    }


}