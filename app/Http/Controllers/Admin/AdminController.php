<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $service;

    const ITEMS_PER_PAGE = 15;

    private static $view = 'admin';

    private static $params = [];

    protected function render($view, $params = [])
    {
        self::setView($view);
        self::setParams($params);

        return view(self::$view, self::$params);
    }

    protected static function setView(string $view): void
    {
        self::$view = sprintf('%s.%s', self::$view, $view);
    }

    private static function setParams(array $params): void
    {
        self::$params = array_merge(self::$params, $params);
    }
}
