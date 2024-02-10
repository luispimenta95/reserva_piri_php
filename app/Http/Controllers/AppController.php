<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Http\Controllers\AppController;




class AppController extends Controller
{
    public function gerarPdf(array $params)
    {
        $data = [
            'empresa' => config('app.empresa'),
            'nome' => config('app.nome'),
            'telefone' => config('app.telefone'),
            'cpf' => config('app.cpf'),
            'cidade' => config('app.cidade'),
            'uf' => config('app.uf'),
            'fracao' => config('app.fracao'),
            'numero' => config('app.numero'),
            'bloco' => config('app.bloco'),
            'tipo_quarto' => config('app.tipo'),
            'dia' =>  $this->getDataAtual(),
            'dataInicial' =>  date('d/m/Y', strtotime($params['dataInicial'])),
            'dataFinal' =>  date('d/m/Y', strtotime($params['dataFinal'])),
            'email' => config('app.email'),
            'hospedes' => $params['hospedes']
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
