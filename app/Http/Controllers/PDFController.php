<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;




class PDFController extends Controller
{
    public function store(Request $request)
    {
        $dataIni = date('d/m/Y', strtotime($request->dataIni));
        $dataFim = date('d/m/Y', strtotime($request->dataFim));
        $empresa = config('app.empresa');
        $nome = config('app.nome');
        $telefone = config('app.telefone');
        $cpf = config('app.cpf');
        $cidade = config('app.cidade');
        $uf = config('app.uf');
        $fracao = config('app.fracao');
        $numero = config('app.numero');
        $bloco = config('app.bloco');
        $tipo = config('app.tipo');
        $dia = $this->getDataAtual();
        $email = config('app.email');



        $data = [
            'empresa' => $empresa,
            'nome' => $nome,
            'telefone' => $telefone,
            'cpf' => $cpf,
            'cidade' => $cidade,
            'uf' => $uf,
            'fracao' => $fracao,
            'numero' => $numero,
            'bloco' => $bloco,
            'tipo_quarto' => $tipo,
            'dia' => $dia,
            'dataInicial' => $dataIni,
            'dataFinal' => $dataFim,
            'email' => $email
        ];
        return PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('pdf.document', $data)->stream();
    }
    private function getDataAtual(): String
    {
        $dia = Carbon::now()->format('d');
        $mes = Carbon::now()->format('m');
        $ano = Carbon::now()->format('Y');
        $months = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro',
            'Novembro', 'Dezembro'
        ];
        return $dia . ' de ' . $months[$mes - 1] . ' de ' . $ano;
    }
}
