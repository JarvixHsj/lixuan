<?php

namespace Controller;

use think\Controller;

class BasicAgent extends Controller {

    public function __construct()
    {

        parent::__construct();

        if (!session('agent') && $this->request->action() !== 'out') {
            $this->redirect('@html/Login/index');
        }
    }
}