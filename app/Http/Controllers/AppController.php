<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Hospede;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Http\Controllers\ReservaController as ReservaController;



class AppController extends Controller
{
    public function gerarContrato(Request $request)
    {
        $reservaController = new ReservaController();
        $reserva = Reserva::find($request->id);

        $file = public_path() . '/' . $reserva->camArquivo;
        if (!file_exists($file)) {
            $dados['reserva'] = $reserva;
            $dados['hospedes'] = $reservaController->getHospedesReserva($reserva);

            $this->createFolder(public_path('pdf/reservas/'));
            $data = $this->tratarDadosPdf($dados);

            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('pdf.document', $data);

            $pdf->save($reserva->camArquivo);
        }

        $this->downloadFile($file);
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

    private function formatarCpf($cpf): String
    {

        $cpf = substr($cpf, 0, 3) . '.' .
            substr($cpf, 3, 3) . '.' .
            substr($cpf, 6, 3) . '-' .
            substr($cpf, 9, 2);

        return $cpf;
    }
    private function tratarDadosPdf(array $params): array
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
            'dataInicial' =>  date('d/m/Y', strtotime($params['reserva']['dataInicial'])),
            'dataFinal' =>  date('d/m/Y', strtotime($params['reserva']['dataFinal'])),
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

    public function login()
    {
        return view('autenticacao.login');
    }
    public function validarLogin(Request $request)
    {
        $credentials = $request->only('cpf', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('reservas');
        }
        return redirect()->back()->withErrors('Usuário ou senha inválidos');
    }

    private function downloadFile($file)
    {
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header("Content-Type: application/force-download");
            header('Content-Disposition: attachment; filename=' . urlencode(basename($file)));
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
        }
    }
}
