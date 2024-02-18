<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;




class AdminController extends Controller
{
    const MODULO = 'admin.pages.';

    public function getView(String $pagina, $params = null)
    {
        if ($params) {
            return view(self::MODULO . $pagina, ['dados' => $params]);
        }
        return view(self::MODULO . $pagina);
    }
    public function index()
    {
        $dados = Reserva::count();
        return $this->getView('index', $dados);
    }

    public function listaReservas()
    {
        $dados = Reserva::paginate(15);

        return $this->getView('tables.simple', $dados);
    }
}
