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


}