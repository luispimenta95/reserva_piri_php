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

        $pdf = PDF::loadView('pdf.document', $data);
        return $pdf->stream('document.pdf');
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
    public function index()
    {
        $hospedes = Hospede::all();

        return view('hospedes.index', compact('hospedes'));
    }

    /**
     * Show the step One Form for creating a new hospede.
     *
     * @return \Illuminate\Http\Response
     */
    public function createStepOne(Request $request)
    {
        $hospede = $request->session()->get('hospede');

        return view('hospedes.create-step-one', compact('hospede'));
    }

    /**  
     * Post Request to store step1 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postCreateStepOne(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:hospedes',
            'amount' => 'required|numeric',
            'description' => 'required',
        ]);

        if (empty($request->session()->get('hospede'))) {
            $hospede = new Hospede();
            $hospede->fill($validatedData);
            $request->session()->put('hospede', $hospede);
        } else {
            $hospede = $request->session()->get('hospede');
            $hospede->fill($validatedData);
            $request->session()->put('hospede', $hospede);
        }

        return redirect()->route('hospedes.create.step.two');
    }

    /**
     * Show the step One Form for creating a new hospede.
     *
     * @return \Illuminate\Http\Response
     */
    public function createStepTwo(Request $request)
    {
        $hospede = $request->session()->get('hospede');

        return view('hospedes.create-step-two', compact('hospede'));
    }

    /**
     * Show the step One Form for creating a new hospede.
     *
     * @return \Illuminate\Http\Response
     */
    public function postCreateStepTwo(Request $request)
    {
        $validatedData = $request->validate([
            'stock' => 'required',
            'status' => 'required',
        ]);

        $hospede = $request->session()->get('hospede');
        $hospede->fill($validatedData);
        $request->session()->put('hospede', $hospede);

        return redirect()->route('hospedes.create.step.three');
    }

    /**
     * Show the step One Form for creating a new hospede.
     *
     * @return \Illuminate\Http\Response
     */
    public function createStepThree(Request $request)
    {
        $hospede = $request->session()->get('hospede');

        return view('hospedes.create-step-three', compact('hospede'));
    }

    /**
     * Show the step One Form for creating a new hospede.
     *
     * @return \Illuminate\Http\Response
     */
    public function postCreateStepThree(Request $request)
    {
        $hospede = $request->session()->get('hospede');
        $hospede->save();

        $request->session()->forget('hospede');

        return redirect()->route('hospedes.index');
    }
}
