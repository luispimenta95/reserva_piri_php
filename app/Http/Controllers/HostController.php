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
        $idsHospedes = array();
        $informacoesReserva = [];

        for ($i = 0; $i < count($nome); $i++) {
            $informacoesHospedes = [
                'nome' => $nome[$i],
                'cpf' => $cpf[$i],
                'nascimento' => $nascimento[$i],
                'email' => $email[$i],
                'telefone' => $telefone[$i]
            ];
            $lastId = Database::table('hospedes')->insertGetId($informacoesHospedes);
            array_push($idsHospedes, $lastId);
            array_push($hospedes, $informacoesHospedes);
        }
        //Iinformacoes Hospedes
        $data['dataInicial'] = $request->dataInicial;
        $data['dataFinal'] = $request->dataFinal;
        $data['hospedes'] = $hospedes;
        // Fim das informacoes hospedes

        //Reserva
        $informacoesReserva['dataInicial'] = $request->dataInicial;
        $informacoesReserva['dataFinal'] = $request->dataFinal;
        $informacoesReserva['hospedes'] = json_encode($idsHospedes);

        Database::table('reserva')->insert($informacoesReserva);

        //Fim reserva
        return $app->gerarPdf($data);
    }
}
