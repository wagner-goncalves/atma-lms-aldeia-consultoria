<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Material;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use JsValidator;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{

    protected $validationRules = [
        'titulo' => 'required',
        'aula_id' => 'required',
        //'email' => 'required|email|unique:users,email',
        //'password' => 'required|same:confirm-password',
        'ordem' => 'required',
        'arquivo' => 'required|file|mimes:pdf',
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
            $materiais = "";

            $materiais = Material::sortable()
                    ->join("aulas", "aulas.id", "=", "materiais.aula_id")
                    ->join("modulos", "modulos.id", "=", "aulas.modulo_id")
                    ->join("cursos", "cursos.id", "=", "modulos.curso_id")
                    ->orderBy('id', 'desc')
                    ->select("materiais.*", "cursos.nome as curso_nome");
    
            if (!empty($filter)) {
                $materiais = $materiais->where('materiais.titulo', 'like', '%'.$filter.'%')
                ->orWhere('aulas.titulo', 'like', '%'.$filter.'%')
                ->orWhere('modulos.nome', 'like', '%'.$filter.'%')
                ->orWhere('cursos.nome', 'like', '%'.$filter.'%')
                ->orderBy('id', 'desc')->paginate(10);
            } else {
                $materiais = $materiais->paginate(10);
            }
    
            return view('materiais.index',compact('materiais', 'filter'))
                ->with('i', (request()->input('page', 1) - 1) * 10);            
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        unset($this->validationRules["arquivo"]);
        $validator = JsValidator::make($this->validationRules);

        $cursos = \App\Models\Curso::all()
            ->sortBy("nome");

        $material = new Material();
        return view('materiais.edit', compact('material', 'cursos'))->with([
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


        $caminho = $request->file('arquivo')->store('materiais');
        $requestData["arquivo"] = $caminho;
        
        $user = Material::create($requestData);

        return redirect()->route('materiais.index')
                        ->with('success','Material criado com sucesso.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $material = Material::find($id);
        return view('materiais.show',compact('material'));
    }

  
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        unset($this->validationRules["arquivo"]);
        $validator = JsValidator::make($this->validationRules);

        $cursos = \App\Models\Curso::all()
            ->sortBy("nome");

        $material = Material::find($id);
        return view('materiais.edit', compact('material', 'cursos'))->with([
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

        unset($this->validationRules["arquivo"]);
        $this->validate($request, $this->validationRules);

        $material = Material::find($id);
        $requestData = $request->all();

        if(isset($requestData->arquivo)){
            $caminho = $request->file('arquivo')->store('materiais');
            $requestData["arquivo"] = $caminho;
        }else{
            $requestData["arquivo"] = $material->arquivo;
        }

        $material->update($requestData);

        return redirect()->route('materiais.index')
                        ->with('success','Material alterado com sucesso.');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $material = Material::find($id);
        Storage::delete($material->arquivo);
        $material->delete();
        
        return redirect()->route('materiais.index')
                        ->with('success','Material excluído com sucesso.');
    }

    public function download($id){
        $material = Material::find($id);
        return Storage::download($material->arquivo, ($material->titulo . "." . pathinfo($material->arquivo, PATHINFO_EXTENSION)));
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

    public function aulas(Request $request){
        $modulo_id = $request->input('depdrop_all_params.modulo_id');

        $aulas = \App\Models\Aula::where('modulo_id', $modulo_id)
            ->select("id", "titulo as name")
            ->orderBy("titulo")
            ->get(['id', 'name']);

        $retorno["output"] = $aulas->toArray();
        $retorno["selected"] = "";

        return response()->json($retorno);
    }    
}