<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use JsValidator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    protected $validationRules = [
        'name' => 'required',
        'password' => 'required|same:confirm-password',
        'roles' => 'required',
        'empresa_id' => 'required|integer',
        'cpf' => 'required|unique:users,cpf|regex:/(^\d{3}\x2E\d{3}\x2E\d{3}\x2D\d{2}$)/',
        'email' => 'required|email|unique:users,email',
    ];

    public function __construct()
    {
        $this->middleware('role:Admin|Gestor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $filter = $request->query('filter');
        $empresa_id = $request->query('empresa_id');
        $users = User::sortable()->orderBy('created_at', 'desc');

        if(intval($empresa_id) > 0) $users->where('empresa_id', '=', intval($empresa_id));

        //Somente empresas que o gestor pode ver
        if ($user->hasRole('Gestor'))  $users->where('empresa_id', '=', $user->empresa_id);

        if (!empty($filter)) {
            $users->where(function ($query) use ($filter) {
                $query->where('name', 'like', '%' . $filter . '%')
                    ->orWhere('cpf', '=', $filter);
            });
        }

        $users = $users->paginate(10);

        $empresas = $this->empresasUsuario();

        return view('users.index', compact('users', 'empresas', 'empresa_id', 'filter'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    private function empresasUsuario()
    {
        $user = auth()->user();
        if ($user->hasRole('Admin')) {
            return \App\Models\Empresa::all()->sortBy("nome");
        } elseif ($user->hasRole('Gestor') && intval($user->empresa_id) > 0) {
            return \App\Models\Empresa::where("id", "=", $user->empresa_id)->get();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = [];
        $loggedUser = auth()->user();
        if ($loggedUser->hasRole('Admin')) $roles = Role::pluck('name', 'name')->all();
        elseif ($user->hasRole('Gestor')){
            $roles = Role::whereNotIn('name', ["Admin"])->pluck('name', 'name')->all();
        } 
        $empresas = $this->empresasUsuario();
        $this->validationRules["email"] = "required|email";
        $this->validationRules["cpf"] = "required|regex:/(^\d{3}\x2E\d{3}\x2E\d{3}\x2D\d{2}$)/";
        $validator = JsValidator::make($this->validationRules);
        
        return view('users.create', compact('roles', 'empresas'))->with([
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
        $this->validationRules['email'] = Rule::unique('users');
        $this->validationRules['cpf'] = Rule::unique('users', 'cpf');
        $this->validate($request, $this->validationRules);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['password_changet_at'] = '2000-01-01 00:00:01';

        $user = User::create($input);
        if (!$user->hasRole('Admin')) unset($request->input('roles')["Admin"]);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $loggedUser = auth()->user();
        $user = User::find($id);

        if ($loggedUser->hasRole('Gestor') && !$loggedUser->hasRole('Admin') && $user->empresa_id != $loggedUser->empresa_id){
            return redirect()->route('users.index')->with('error', 'Operação inválida.');
            //\App::abort(403, 'Ação não autorizada.');
        }

        $roles = [];
        if ($loggedUser->hasRole('Admin')) $roles = Role::pluck('name', 'name')->all();
        elseif ($loggedUser->hasRole('Gestor')){
            $roles = Role::whereNotIn('name', ["Admin"])->pluck('name', 'name')->all();
        } 

        $userRole = $user->roles->pluck('name', 'name')->all();
        $empresas = $this->empresasUsuario();

        $this->validationRules["email"] = "required|email";
        $this->validationRules["cpf"] = "required|regex:/(^\d{3}\x2E\d{3}\x2E\d{3}\x2D\d{2}$)/";        
        $validator = JsValidator::make($this->validationRules);

        return view('users.edit', compact('user', 'roles', 'empresas', 'userRole'))->with([
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

        $loggedUser = auth()->user();
        $input = $request->all();

        if ($loggedUser->hasRole('Gestor') && !$loggedUser->hasRole('Admin')  && $input["empresa_id"] != $loggedUser->empresa_id){
            return redirect()->route('users.index')
            ->with('error', 'Operação inválida.');
        }

        $this->validationRules['email'] = Rule::unique('users')->ignore($id);
        $this->validationRules['cpf'] = Rule::unique('users', 'cpf')->ignore($id); //'required|email|unique:users,email';
        unset($this->validationRules['password']);
        $this->validate($request, $this->validationRules);

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
            $input['password_changed_at'] = "2000-01-01 00:00:01";
        } else {
            $input = Arr::except($input, array('password'));
        }

        
        $user = User::find($id);
        
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        if (!$user->hasRole('Admin')) unset($request->input('roles')["Admin"]);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'Atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $loggedUser = auth()->user();
        $user = User::find($id);

        if ($loggedUser->hasRole('Gestor')  && !$loggedUser->hasRole('Admin') && $user->empresa_id != $loggedUser->empresa_id){
            return redirect()->route('users.index')
            ->with('error', 'Operação inválida.');
        }

        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function resetPassword($id){

    }
}
