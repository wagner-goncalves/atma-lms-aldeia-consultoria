<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aula;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use JsValidator;
use Illuminate\Support\Facades\Storage;

class AulaAdministracaoController extends Controller
{

    protected $validationRules = [
        'titulo' => 'required',
        'modulo_id' => 'required|integer',
        'carga_horaria' => 'required|integer',
        'link' => 'required',
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
            $modulo_id = $request->query('modulo_id');
            $aulas = "";

            $aulas = Aula::sortable()
                    ->join("modulos", "modulos.id", "=", "aulas.modulo_id")
                    ->join("cursos", "cursos.id", "=", "modulos.curso_id")
                    ->orderBy('id', 'desc')
                    ->select("aulas.*", "cursos.nome as curso_nome", "modulos.nome as modulo_nome");

            if(intval($modulo_id) > 0) $aulas->where('aulas.modulo_id', '=', $modulo_id);
            if(intval($curso_id) > 0) $aulas->where('modulos.curso_id', '=', $curso_id);
    
            if (!empty($filter)) {
                $aulas = $aulas
                ->where(function($query) use ($filter) {
                    $query->where('aulas.titulo', 'like', '%'.$filter.'%')
                    ->orWhere('modulos.nome', 'like', '%'.$filter.'%')
                    ->orWhere('cursos.nome', 'like', '%'.$filter.'%');
                })
                ->orderBy('id', 'desc')->paginate(10);



            } else {
                $aulas = $aulas->paginate(10);
            }

            //Filtros
            $cursos = \App\Models\Curso::all()->sortBy("nome");
            $modulos = intval($curso_id) > 0 ? \App\Models\Modulo::where("curso_id", "=", $curso_id)->orderBy("nome")->get() : [];

            return view('aulas.index',compact('aulas', 'cursos', 'curso_id', 'modulos', 'modulo_id', 'filter'))
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

        $aula = new Aula();
        $linkFormatado = "";
        return view('aulas.edit', compact('aula', 'cursos', 'linkFormatado'))->with([
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
        
        $user = Aula::create($requestData);

        return redirect()->route('aulas.index')
                        ->with('success','Aula criada com sucesso.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aula = Aula::find($id);
        return view('aulas.show',compact('aula'));
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

        $aula = Aula::find($id);
        $linkFormatado = $this->formataLink($aula->link);
        
        return view('aulas.edit', compact('aula', 'cursos', 'linkFormatado'))->with([
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

        $aula = Aula::find($id);
        $requestData = $request->all();

        $aula->update($requestData);

        return redirect()->route('aulas.index')
                        ->with('success','Aula alterada com sucesso.');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aula = Aula::find($id);
        Storage::delete($aula->arquivo);
        $aula->delete();
        
        return redirect()->route('aulas.index')
                        ->with('success','Aula excluída com sucesso.');
    }

    public function modulos(Request $request){
        $curso_id = $request->input('depdrop_all_params.curso_id');

        $modulos = \App\Models\Modulo::where('curso_id', $curso_id)
            ->select("id", "nome as name")
            ->orderBy("nome")
            ->get(['id', 'name']);

        $retorno["output"] = $modulos->toArray();
        $retorno["selected"] = "";

        return response()->json($retorno);
    }

    private function formataLink($codigoVideo){
        if($codigoVideo == "") return "";
        return sprintf('<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/%s?controls=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>', $codigoVideo);
    }
}