<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;




class AdminController extends Controller
{
    const MODULO = 'admin.pages.';

    public function getView(String $pagina)
    {
        return view(self::MODULO . $pagina);
    }
    public function index()
    {
        return $this->getView('index');
    }

    public function tabelas()
    {
        return $this->getView('tables.simple');
    }
}
