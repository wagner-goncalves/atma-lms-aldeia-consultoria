<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{

    public function valida($curso)
    {

        $user = auth()->user();
        $erros = [];

        $alunoMatriculado = false;
        $cursoConcluido = false;
        $feedbackRespondido = false;

        $matricula = \App\Models\Matricula::where('curso_id' , '=' , $curso->id)->where('user_id' , '=' , $user->id)->first();
        is_object($matricula) ?: $erros["alunoMatriculado"] = "O usuário logado não está matriculado neste curso.";

        $curso->percentualConclusao() == 100 ?: $erros["cursoConcluido"] = "Ainda não é possível responder o feedback. Conclua todas as aulas do curso.";

        $feedbackRespondido = $curso->feedbackRespondido($curso->id);
        !$feedbackRespondido ?: $erros["feedbackRespondido"] = "Você já respondeu este feedback. Obrigado!";

        return count($erros) > 0 ? $erros : false;
    }

    public function index($curso)
    {
        $perguntas = [];
        $curso = \App\Models\Curso::find($curso);
        $erros = $this->valida($curso);
        if($erros) return view('feedback.index',compact('perguntas', 'curso'))->withErrors($erros);

        $perguntas = $this->getPerguntasCurso($curso->id); 
        return view('feedback.index', compact('perguntas', 'curso'));
    }

    public function store(Request $request, $curso)
    {
        try{
            $user = auth()->user();
            $perguntas = $this->getPerguntasCurso($curso); 

            $validationRules = [];
            $customMessages = [];
            $customMessages[('required')] = 'Responda todas as perguntas';
            foreach($perguntas as $pergunta)  $validationRules[('pergunta_id_' . $pergunta->id)] = 'required|integer';
            $this->validate($request, $validationRules, $customMessages);

            foreach($request->all() as $key => $resposta_id){
                if(strpos($key, 'pergunta_id_') !== false){
                    $pergunta_id = intval(str_replace("pergunta_id_", "", $key));
                    $feedback = \App\Models\Feedback::create([
                        'curso_id' => $curso,
                        'pergunta_id' => $pergunta_id,
                        'resposta_id' => $resposta_id,
                        'user_id' => $user->id,
                    ]);
                }
            }
        }catch(\Exception $e){
            
        }

        $curso = \App\Models\Curso::find($curso);
        $curso->concluirCurso($curso->id);

        return view('feedback.concluido', compact('curso'));
    }
    

    private function getPerguntasCurso($curso_id){
        return \App\Models\Pergunta::join('questionarios', 'perguntas.questionario_id', '=', 'questionarios.id')
        ->where('questionarios.curso_id', '=', $curso_id)
        ->orderBy('perguntas.ordem','asc')
        ->select('perguntas.*')
        ->get();
    }
}
