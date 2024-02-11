<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;




class AppController extends Controller
{
    public function gerarPdf(array $params)
    {
        $this->createFolder($params['camArquivo']);
        $data = $this->tratarDados($params);

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('pdf.document', $data);


        $pdf->save($params['camArquivo']  . $params['nomePdf']);
        $mensagens = $this->mensagensSistema();
        return view('hospedes.index')->with('message', $mensagens['reservaSolicitada']);
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

    private function formatarCpf($cpf)
    {
        $docFormatado = substr($cpf, 0, 3) . '.' .
            substr($cpf, 3, 3) . '.' .
            substr($cpf, 6, 3) . '-' .
            substr($cpf, 9, 2);

        return $docFormatado;
    }
    private function tratarDados($params)
    {
        $hosts = array();
        foreach ($params['hospedes'] as $hospede) {
            $hospede['nascimento'] = date('d/m/Y', strtotime($hospede['nascimento']));
            $hospede['cpf'] = $this->formatarCpf($hospede['cpf']);
            array_push($hosts, $hospede);
        }

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
            'hospedes' => $hosts
        ];

        return $data;
    }
    private function createFolder($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
    }

    public function mensagensSistema()
    {
        $mensagens = [
            'reservaSolicitada' => " <div class=alert alert-success> Teste</div>",
            'reservaCancelada' => '<div class="alert alert-danger" role="alert">Reserva cancelada com sucesso!</div>'
        ];
        return $mensagens;
    }
}
