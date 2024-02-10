<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
                'cpf' => $this->formatarCpf($cpf[$i]),
                'nascimento' => date('d/m/Y', strtotime($nascimento[$i])),
                'email' => $email[$i],
                'telefone' => $telefone[$i]
            ];
            // DB::table('hospedes')->insert($informacoes);
            array_push($hospedes, $informacoes);
        }
        $data['dataInicial'] = $request->dataInicial;
        $data['dataFinal'] = $request->dataFinal;
        $data['hospedes'] = $hospedes;
        return $app->gerarPdf($data);
    }

    private function formatarCpf($cpf)
    {
        $docFormatado = substr($cpf, 0, 3) . '.' .
            substr($cpf, 3, 3) . '.' .
            substr($cpf, 6, 3) . '-' .
            substr($cpf, 9, 2);

        return $docFormatado;
    }
}
