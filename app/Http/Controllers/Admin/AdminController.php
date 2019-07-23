<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected $service;

    const ITEMS_PER_PAGE = 15;

    const VIEW = 'admin';

    const PARAMS = [];

    protected function render($view, $params = [])
    {
        return view($this->formView($view), $this->formParams($params));
    }

    private function formView(string $view): string
    {
        return sprintf('%s.%s', self::VIEW, $view);
    }

    private function formParams(array $params): array
    {
        return array_merge(self::PARAMS, $params);
    }
}
