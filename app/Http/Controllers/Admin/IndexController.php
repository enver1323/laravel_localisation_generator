<?php


namespace App\Http\Controllers\Admin;


class IndexController extends AdminController
{
    public function index()
    {
        return $this->render('index');
    }
}
