<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $validationRules = [
        'post' => 'required',
        'curso_id' => 'required|integer'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function valida($curso)
    {
        $user = auth()->user();
        $erros = [];

        $matricula = \App\Models\Matricula::where('curso_id' , '=' , $curso->id)->where('user_id' , '=' , $user->id)->first();
        is_object($matricula) ?: $erros["alunoMatriculado"] = "O usuário logado não está matriculado neste curso.";

        $curso->tempoRestanteCurso() >= 0 ?: $erros["cursoNoPrazo"] = "O prazo para realização do curso expirou.";

        return count($erros) > 0 ? $erros : false;
    }
    
    public function index($curso)
    {
        return $this->show($curso);
    }    

    public function show($curso)
    {
        
        $aulas = [];
        $curso = \App\Models\Curso::find($curso);
        
        $erros = $this->valida($curso);
        
        $posts = [];

        if($erros) return view('posts.index',compact('posts', 'curso'))->withErrors($erros);
        
        $posts = \App\Models\Post::whereNull("post_id")->orderBy('created_at', 'desc')
            ->paginate(10); 

        return view('posts.index',compact('posts', 'curso'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules);
        $requestData = $request->all();

        $requestData["user_id"] = auth()->user()->id;
        
        $post = \App\Models\Post::create($requestData);

        return redirect()->route('posts.show', $requestData["curso_id"])
            ->with('success', 'Post criado com sucesso.');        
    }    

    public function destroy($id)
    {

        $loggedUser = auth()->user();
        $post = \App\Models\Post::find($id);

        if (!$loggedUser->hasRole('Gestor')  && !$loggedUser->hasRole('Admin')){
            return redirect()->route('posts.show', $post->curso_id)
            ->with('error', 'Operação inválida.');
        }

        $post->delete();
        return redirect()->route('posts.show', $post->curso_id)
            ->with('success', 'Post excluído com sucesso.');
    }

}
