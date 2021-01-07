<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pergunta;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use JsValidator;
use Illuminate\Support\Facades\Storage;

class PerguntaController extends Controller
{

    protected $validationRules = [
        'pergunta' => 'required',
        'questionario_id' => 'required|integer',
        'ordem' => 'required|integer',
    ];

    public function __construct()
    {
        $this->middleware('role:Admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $filter = $request->query('filter');
            $curso_id = $request->query('curso_id');
            $questionario_id = $request->query('questionario_id');
            $perguntas = "";

            $perguntas = Pergunta::sortable()
                    ->join("questionarios", "questionarios.id", "=", "perguntas.questionario_id")
                    ->join("cursos", "cursos.id", "=", "questionarios.curso_id")
                    ->orderBy('id', 'desc')
                    ->select("perguntas.*", "cursos.nome as curso_nome", "questionarios.nome as questionario_nome");

            if(intval($questionario_id) > 0) $perguntas->where('perguntas.questionario_id', '=', $questionario_id);
            if(intval($curso_id) > 0) $perguntas->where('questionarios.curso_id', '=', $curso_id);
    
            if (!empty($filter)) {
                $perguntas = $perguntas
                ->where(function($query) use ($filter) {
                    $query->where('perguntas.titulo', 'like', '%'.$filter.'%')
                    ->orWhere('questionarios.nome', 'like', '%'.$filter.'%')
                    ->orWhere('cursos.nome', 'like', '%'.$filter.'%');
                })
                ->orderBy('id', 'desc')->paginate(10);



            } else {
                $perguntas = $perguntas->paginate(10);
            }

            //Filtros
            $cursos = \App\Models\Curso::all()->sortBy("nome");
            $questionarios = intval($curso_id) > 0 ? \App\Models\Questionario::where("curso_id", "=", $curso_id)->orderBy("nome")->get() : [];

            return view('perguntas.index',compact('perguntas', 'cursos', 'curso_id', 'questionarios', 'questionario_id', 'filter'))
                ->with('i', (request()->input('page', 1) - 1) * 10);            
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $validator = JsValidator::make($this->validationRules);

        $cursos = \App\Models\Curso::all()->sortBy("nome");

        $pergunta = new Pergunta();
        return view('perguntas.edit', compact('pergunta', 'cursos'))->with([
            'validator' => $validator,
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules);
        $requestData = $request->all();
        
        $user = Pergunta::create($requestData);

        return redirect()->route('perguntas.index')
                        ->with('success','Pergunta criada com sucesso.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pergunta = Pergunta::find($id);
        return view('perguntas.show',compact('pergunta'));
    }

  
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $validator = JsValidator::make($this->validationRules);

        $cursos = \App\Models\Curso::all()
            ->sortBy("nome");

        $pergunta = Pergunta::find($id);
        return view('perguntas.edit', compact('pergunta', 'cursos'))->with([
            'validator' => $validator,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, $this->validationRules);

        $pergunta = Pergunta::find($id);
        $requestData = $request->all();

        $pergunta->update($requestData);

        return redirect()->route('perguntas.index')
                        ->with('success','Pergunta alterada com sucesso.');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pergunta = Pergunta::find($id);
        Storage::delete($pergunta->arquivo);
        $pergunta->delete();
        
        return redirect()->route('perguntas.index')
                        ->with('success','Pergunta excluída com sucesso.');
    }

    public function questionarios(Request $request){
        $curso_id = $request->input('depdrop_all_params.curso_id');

        $questionarios = \App\Models\Questionario::where('curso_id', $curso_id)
            ->select("id", "nome as name")
            ->orderBy("nome")
            ->get(['id', 'name']);

        $retorno["output"] = $questionarios->toArray();
        $retorno["selected"] = "";

        return response()->json($retorno);
    }
}