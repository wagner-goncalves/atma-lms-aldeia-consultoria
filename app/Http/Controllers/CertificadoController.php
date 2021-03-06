<?php

namespace App\Http\Controllers;

use App\Models\Empresa;

class CertificadoController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:Aluno|Admin');
        $this->middleware('auth');
    }    

    private function dadosCertificado($curso)
    {
        $info = [];
        $user = auth()->user();
        $curso = \App\Models\Curso::find($curso);

        $matricula = \App\Models\Matricula::where("user_id", "=", $user->id)
            ->where("curso_id", "=", $curso->id)->first();

        $empresa = $user->empresa()->first();

        $info["carga_horaria"] = $curso->cargaHoraria();
        $info["nome_curso"] = $curso->nome;
        $info["base_certificado"] = $curso->base_certificado;
        $info["data_conclusao"] = \Carbon\Carbon::parse($matricula->data_conclusao)->format('Y-m-d');
        $info["nome_aluno"] = $user->name;
        $info["empresa"] = is_object($empresa) ? $empresa->nome : "";
        return $info;
    }

    private function valida($curso_id){
        $curso = \App\Models\Curso::find($curso_id); 
        if(!is_object($curso)) abort(403, 'Acesso negado.');
        $percentualConclusao = $curso->percentualConclusao();
        $feedbackRespondido = $curso->feedbackRespondido();
        if($percentualConclusao < 100 || !$feedbackRespondido) abort(403, 'Acesso negado.');
    }

    public function download($curso)
    {

        /**
         * 
         * 
         * 
Step 1. Download all the variant's of your font (Regular, Bold, Italic, Bold-Italic)

Step 2. Convert all the fonts to font-name.php and font-name.z from http://www.fpdf.org/makefont/

Step 3. Copy all *.php and *.z files in fonts/ folder which is in root directory of fpdf.php. [You can rename *.php files, but don't rename *.z once you converted them from ttf].

Step 4. Use this code to import the font into your pdf:

//Importing Font and it's variations
$fpdf->AddFont('Gotham','','Gotham-Book.php'); //Regular
$fpdf->AddFont('Gotham','B','Gotham-Book-bold.php'); //Bold
$fpdf->AddFont('Gotham','I','Gotham-Book-italic.php'); //Italic
$fpdf->AddFont('Gotham','BI','Gotham-Book-bold-italic.php'); //Bold_Italic

//Now use it as normal font
$fpdf->SetFont('Gotham','B',11);
         * 
         */

        $this->valida($curso);

        $user = auth()->user();
        $certificado = ["user_id" => $user->id, "curso_id" => $curso];
        \App\Models\Certificado::create($certificado);

        $dadosCertificado = $this->dadosCertificado($curso);
        $pdf = new \Codedge\Fpdf\Fpdf\Fpdf();

        $texto1 = utf8_decode($dadosCertificado["empresa"]);
        $texto2 = utf8_decode("pela participação no " . $dadosCertificado["nome_curso"] . " \n concluido em " . utf8_encode(strftime('%d/%m/%Y', strtotime($dadosCertificado["data_conclusao"]))) . " com carga horária total de " . $dadosCertificado["carga_horaria"] . " horas.");
        
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $texto3 = utf8_decode(strftime('%d de %B de %Y', strtotime($dadosCertificado["data_conclusao"])));

        //$pdf = new AlphaPDF();

        // Orientação Landing Page ///
        $pdf->AddPage('L');

        $pdf->SetLineWidth(1.5);

        // desenha a imagem do certificado
        //$pdf->Image(resource_path("images/base-certificado.png'"),0,0,295);
        $pdf->Image(resource_path("images/" . $dadosCertificado["base_certificado"]), 0, 0, 295, 0, 'PNG');

        // opacidade total
        //$pdf->SetAlpha(1);

        // Mostrar texto no topo
        //$pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
        //$pdf->SetXY(109, 46); //Parte chata onde tem que ficar ajustando a posição X e Y
        //$pdf->MultiCell(265, 10, $texto1, '', 'L', 0); // Tamanho width e height e posição

        // Mostrar o nome
        $pdf->AddFont('Allura','','Allura-Regular.php'); //Regular
        $pdf->SetFont('Allura', '', 50); // Tipo de fonte e tamanho
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(20, 86); //Parte chata onde tem que ficar ajustando a posição X e Y
        $pdf->MultiCell(265, 10, utf8_decode($dadosCertificado["nome_aluno"]), '', 'C', 0); // Tamanho width e height e posição

        // Mostrar o corpo
        //$pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
        //$pdf->SetXY(20, 110); //Parte chata onde tem que ficar ajustando a posição X e Y
        //$pdf->MultiCell(265, 10, $texto2, '', 'C', 0); // Tamanho width e height e posição

        // Mostrar a data no final
        $pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(40, 154); //Parte chata onde tem que ficar ajustando a posição X e Y
        $pdf->MultiCell(165, 10, $texto3, '', 'L', 0); // Tamanho width e height e posição

        $pdfdoc = $pdf->Output('D', 'Certificado ' . ($dadosCertificado["nome_curso"]) . '.pdf', true);

        die();
    }
}
