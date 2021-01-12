<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\PostCriado;

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

    public function show($curso, Request $request)
    {
        $empresa_id = "";
        $posts = [];
        $empresas = [];
        $requestData = $request->all();
        $curso = \App\Models\Curso::find($curso);
        $erros = $this->valida($curso);

        if($erros) return view('posts.index',compact('posts', 'curso'))->withErrors($erros);

        $user = auth()->user();

        $posts = \App\Models\Post::whereNull("post_id")
            ->where("curso_id", "=", $curso->id)
            ->orderBy('created_at', 'desc');

        if($user->hasRole('Admin')){
            $empresas = \App\Models\Empresa::orderBy("nome")->get();
            if(isset($requestData["empresa_id"]) && intval($requestData["empresa_id"]) > 0){
                $posts->where("empresa_id", "=", $requestData["empresa_id"]);
                $empresa_id = $requestData["empresa_id"];
            }
        }else{
            $posts->where("empresa_id", "=", $user->empresa_id);
        }

        $posts = $posts->paginate(10); 

        return view('posts.index',compact('posts', 'curso', 'empresas', 'empresa_id'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules);
        $requestData = $request->all();

        $requestData["user_id"] = auth()->user()->id;
        $requestData["empresa_id"] = auth()->user()->empresa_id;
        
        $post = \App\Models\Post::create($requestData);

        $loggedUser = auth()->user();
        $curso = \App\Models\Curso::find($post->curso_id);
        $userDestinatario = \App\Models\User::find(1);
        $userDestinatario->notify(new PostCriado($loggedUser, $loggedUser->empresa, $curso, $post));

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
