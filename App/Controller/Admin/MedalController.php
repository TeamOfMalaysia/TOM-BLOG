<?php
namespace App\Controller\Admin;


class MedalController extends BaseController
{

    public function index()
    {
        return $this->render('Admin/Medal/index');

    }

}
