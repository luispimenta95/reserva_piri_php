<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as Database;


class HostController extends Controller
{
    public function index()
    {
        return view('hospedes.index');
    }
    public function receberDados(Request $request)
    {
        $app = new AppController();
        $nome = $request->nome;
        $cpf = $request->cpf;
        $nascimento = $request->nascimento;
        $email = $request->email;
        $telefone = $request->telefone;



        $hospedes = array();

        for ($i = 0; $i < count($nome); $i++) {
            $informacoes = [
                'nome' => $nome[$i],
                'cpf' => $cpf[$i],
                'nascimento' => $nascimento[$i],
                'email' => $email[$i],
                'telefone' => $telefone[$i]
            ];
            Database::table('hospedes')->insert($informacoes);
            array_push($hospedes, $informacoes);
        }
        $data['dataInicial'] = $request->dataInicial;
        $data['dataFinal'] = $request->dataFinal;
        $data['hospedes'] = $hospedes;
        return $app->gerarPdf($data);
    }
}
