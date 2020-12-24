<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use App\Imports\MatriculasImport;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use JsValidator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Facades\DB;

class MatriculaController extends Controller
{

    protected $validationRules = [
        'user_id' => 'required|integer',
        'curso_id' => 'required|integer',
        'empresa_id' => 'required|integer',
        'plano_id' => 'required|integer',
        'tempo_acesso' => 'required|integer',
        'data_limite' => 'required|regex:/\d{2}\/\d{2}\/\d{4}/',
        'cpf' => 'required|regex:/(^\d{3}\x2E\d{3}\x2E\d{3}\x2D\d{2}$)/',
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|same:confirm-password',
        'tempo_acesso' => 'required|integer',
        //'data_conclusao' => 'required',
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
        $requestData = $request->all();

        $filter = $request->query('filter');
        $empresa_id = $request->query('empresa_id');
        $plano_id = $request->query('plano_id');
        $curso_id = $request->query('curso_id');
        $matriculas = "";

        $matriculas = Matricula::sortable()
            ->join("cursos", "matriculas.curso_id", "=", "cursos.id")
            ->join("planos_has_cursos", "planos_has_cursos.curso_id", "=", "cursos.id")
            ->join("planos", "planos_has_cursos.plano_id", "=", "planos.id")
            ->join("planos_has_empresas", "planos_has_empresas.plano_id", "=", "planos.id")
            ->join("empresas", "planos_has_empresas.empresa_id", "=", "empresas.id")
            ->orderBy('matriculas.id', 'desc')
            ->select("matriculas.*", "cursos.nome as curso_nome", "planos.nome as plano_nome", "empresas.nome as empresa_nome");

        if (!empty($filter)) {
            $matriculas = $matriculas
                ->where(function ($query) use ($filter) {
                    $query->where('matriculas.id', '=', '%' . intval($filter) . '%')
                        ->orWhere('empresas.nome', 'like', '%' . $filter . '%')
                        ->orWhere('planos.nome', 'like', '%' . $filter . '%')
                        ->orWhere('cursos.nome', 'like', '%' . $filter . '%');
                })
                ->paginate(10);
        } else {
            $matriculas = $matriculas->paginate(10);
        }

        //Filtros
        $empresas = $this->empresasUsuario();
        $planos = intval($empresa_id) > 0 ? \App\Models\Empresa::find($empresa_id)->planos()->get() : [];
        $cursos = intval($plano_id) > 0 ? \App\Models\Plano::find($plano_id)->cursos()->get() : [];

        return view('matriculas.index', compact('matriculas', 'cursos', 'curso_id', 'planos', 'plano_id', 'empresas', 'empresa_id', 'filter'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    private function empresasUsuario(){
        $user = auth()->user();
        if($user->hasRole('Admin')) return \App\Models\Empresa::all()->sortBy("nome");
        elseif($user->hasRole('Gestor') && intval($user->empresa_id) > 0){
            return \App\Models\Empresa::where("id", "=", $user->empresa_id);
        }
    }


    private function validaCabecalhos($excel, $cabecalhosMatricula){
        $valid = true;
        foreach($excel as $headings){
            foreach($headings as $sheets){
                for($i = 0 ; $i < count($cabecalhosMatricula); $i++){
                    if(!in_array($sheets[$i], $cabecalhosMatricula)){
                        $valid = false;
                        break;
                    } 
                }
            }
        }
        return $valid;
    }

    private function parseArquivo($caminho, $cabecalhosMatricula){
        $excelHeadings = (new HeadingRowImport)->toArray($caminho);
        if($this->validaCabecalhos($excelHeadings, $cabecalhosMatricula)){
            return Excel::toArray(new MatriculasImport, $caminho);
        }else{
            return false;
        }
    }

    public function importar(Request $request)
    {
        $logs = [];
        $loggedUser = auth()->user();
        $cabecalhosMatricula = ["cpf", "name", "email", "phone"];

        //Validar
        //Somente ADM está liberado para alterar todos as matrículas
        //Gestor só altera matrículas e usuários da sua empresa

        if ($request->hasFile('arquivo')) {
            $caminho = $request->file('arquivo')->store('matriculas');
            $excel = $this->parseArquivo($caminho, $cabecalhosMatricula);
            if($excel){
                foreach($excel[0] as $linha){
                    DB::beginTransaction();
                    try{
                        //Validar de CPF já existe, email já existe
                        //Matricular (EMPRESA)
                        //Valida se já excedeu limite de matrículas

        //$logs = $this->parseMatricula($linha);

                        $requestData = $request->all();

                        //Cria usuário
                        if($linha["cpf"] != "" && $linha["name"] != "" && $linha["email"] != ""){
                            $linha["password"] = Hash::make(substr(str_replace(".", "", $linha["cpf"]), 0, 6));

                            if($loggedUser->hasRole('Admin')) $linha["empresa_id"] = $requestData["empresa_id"]; //Administrador pode escolher quaquer empresa
                            else $linha["empresa_id"] =  $loggedUser->empresa_id;

                            $user = \App\Models\User::create($linha);
                            $user->assignRole("Aluno");

                            //Cria matrícula
                            $plano = \App\Models\Plano::find(intval($requestData["plano_id"]));
                            $requestData["user_id"] = $user->id;
                            $requestData["tempo_acesso"] = $plano->cursos()->find($requestData["curso_id"])->pivot->tempo_acesso;
                            $data_conclusao = new \Carbon\Carbon();
                            $requestData["data_conclusao"] = $data_conclusao->addDays(intval($requestData["tempo_acesso"]))->toDateTimeString();
                            $matricula = \App\Models\Matricula::create($requestData);      
                        }

                        DB::commit();
                    }catch(\Exception $e){
                        throw new \Exception($e);
                        DB::rollBack();
                    }
                }
            }else{

            }
            dd("LOGS");
            //return view('matriculas.logs.importacao', compact('logs'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        unset($this->validationRules["user_id"]);
        $validator = JsValidator::make($this->validationRules);

        $empresas = $this->empresasUsuario();

        $matricula = new Matricula();
        $user = new \App\Models\User();

        return view('matriculas.edit', compact('matricula', 'user', 'empresas'))->with([
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
        $requestData = $request->all();
        unset($this->validationRules["user_id"]);

        $this->validate($request, $this->validationRules);

        $requestData["data_limite"] = \Carbon\Carbon::createFromFormat('d/m/Y', $requestData["data_limite"])->format('Y-m-d 23:59:59');

        $user = \App\Models\User::create($requestData);
        $user->assignRole("Aluno");
        $requestData["user_id"] = $user->id;
        $matricula = Matricula::create($requestData);

        if (isset($requestData["continuar"])) {
            return redirect()->route('matriculas.create')->with('success', 'Matricula anterior criada com sucesso.');
        } else {
            return redirect()->route('matriculas.index')->with('success', 'Matricula criada com sucesso.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $matricula = Matricula::find($id);
        return view('matriculas.show', compact('matricula'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $this->validationRules["email"] = 'required|email';
        $this->validationRules["password"] = 'same:confirm-password';

        $validator = JsValidator::make($this->validationRules);

        $empresas = $this->empresasUsuario();

        $matricula = Matricula::find($id);
        $user = $matricula->user;
        return view('matriculas.edit', compact('matricula', 'user', 'empresas'))->with([
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

        //Validar
        //Somente ADM está liberado para alterar todos as matrículas
        //Gestor só altera matrículas e usuários da sua empresa

        $this->validationRules["email"] = 'required|email';
        $this->validationRules["password"] = 'same:confirm-password';

        $this->validate($request, $this->validationRules);

        $requestData = $request->all();
        $requestData["data_limite"] = \Carbon\Carbon::createFromFormat('d/m/Y', $requestData["data_limite"])->format('Y-m-d 23:59:59');

        $matricula = Matricula::find($id);
        $matricula->update($requestData);

        //Usuário
        if (!empty($requestData['password'])) {
            $requestData['password'] = Hash::make($requestData['password']);
        } else {
            $requestData = Arr::except($requestData, array('password'));
        }

        $user = \App\Models\User::find($requestData['user_id']);
        $user->update($requestData);
        //DB::table('model_has_roles')->where('model_id',$user_id)->delete();
        $user->assignRole("Aluno");

        return redirect()->route('matriculas.index')
            ->with('success', 'Matrícula alterada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $matricula = Matricula::find($id);
        Storage::delete($matricula->arquivo);
        $matricula->delete();

        return redirect()->route('matriculas.index')
            ->with('success', 'Matricula excluído com sucesso.');
    }

    public function download($id)
    {
        $matricula = Matricula::find($id);
        return Storage::download($matricula->arquivo, ($matricula->titulo . "." . pathinfo($matricula->arquivo, PATHINFO_EXTENSION)));
    }

    public function planos(Request $request)
    {
        $empresa_id = $request->input('depdrop_all_params.empresa_id');
        $empresa = \App\Models\Empresa::find($empresa_id);
        $planos = !is_object($empresa) ? null : $empresa->planos()->select("id", "nome as name")
            ->orderBy("nome")
            ->get(['id', 'name']);

        $retorno["output"] = !is_object($planos)? [] : $planos->toArray();
        $retorno["selected"] = "";

        return response()->json($retorno);
    }

    public function cursos(Request $request)
    {
        $plano_id = $request->input('depdrop_all_params.plano_id');
        $plano = \App\Models\Plano::find($plano_id);
        $cursos = !is_object($plano) ? null : $plano->cursos()->select("id", "nome as name")
            ->orderBy("nome")
            ->get(['id', 'name']);

        $retorno["output"] = !is_object($cursos)? [] : $cursos->toArray();
        $retorno["selected"] = "";

        return response()->json($retorno);
    }
}
