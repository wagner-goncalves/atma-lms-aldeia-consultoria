@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    @if(!isset($matricula->id) || intval($matricula->id) == 0)
                    <i class="fas fa-plus"></i> Nova matrícula
                    @else
                    <i class="fas fa-edit"></i> Editar matrícula
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <a href="{{ route('matriculas.index') }}"
                            class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                                class="fas fa-chevron-left"></i> Voltar</a> 
                        @if(intval($matricula->id) > 0)
                            {!! Form::open(['method' => 'DELETE', 'route' =>
                            ['matriculas.destroy', $matricula->id], 'style' => 'display:inline']) !!}
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            </div>

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <p><strong>Whoops!</strong> Temos alguns problemas.</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-exclamation-circle fa-lg"></i> {{ $message }}
                </div>
            @endif            

            @if(!isset($matricula->id) || intval($matricula->id) == 0)
                {!! Form::open(['route' => 'matriculas.store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'edit-form']) !!}
            @else
                {!! Form::model($matricula, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'id' => 'edit-form',
                'route' => ['matriculas.update', isset($matricula->id) ? $matricula->id : 0]]) !!}
            @endif
            @csrf
            <div class="row">
                @php
                $empresa_id = intval($matricula->id) == 0 ? 0 : $matricula->empresa_id ;
                @endphp

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="empresa_id"><strong>Empresa</strong></label>
                            <select id="empresa_id" name="empresa_id" class="form-control">
                                <option value="">Escolha... </option>
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id }}" {{ $empresa_id == $empresa->id ? 'selected' : '' }}>
                                        {{ $empresa->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="plano_id"><strong>Plano</strong></label>
                            <select id="plano_id" name="plano_id" class="form-control">
                                @if($empresa_id > 0)
                                <option value="{{ $matricula->plano_id }}" selected>
                                    {{ $matricula->plano->nome }}
                                </option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Curso:</strong>
                        <select id="curso_id" name="curso_id" class="form-control">
                            @if($empresa_id > 0)
                            <option value="{{ $matricula->curso_id }}" selected>{{ $matricula->curso->nome }}</option>
                            @endif
                        </select>
                    </div>
                </div>
                @if(isset($matricula->id) && intval($matricula->id) > 0)
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <strong>Dias de acesso:</strong>
                                {!! Form::input('number', 'tempo_acesso', $matricula->tempo_acesso, ['placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <strong>Data limite do curso:</strong>
                                    {!! Form::text('data_limite', \Carbon\Carbon::parse($matricula->data_limite)->format('d/m/Y'), ['placeholder' => '', 'class' => 'form-control data_limite', 'id' =>
                                    'descricao']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <h4><i class="fas fa-user"></i> Dados do @if(!isset($matricula->id) || intval($matricula->id) == 0) novo @endif aluno</h4>
                    {!! Form::hidden('user_id', $user->id) !!}
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <strong>Nome:</strong>
                                {!! Form::text('name', $user->name, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <strong>E-mail:</strong>
                                    {!! Form::email('email', $user->email, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <strong>Telefone:</strong>
                                    {!! Form::text('phone', $user->phone, array('placeholder' => '','class' => 'form-control phone')) !!}
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>                
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">

                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <strong>CPF:</strong>
                                    {!! Form::text('cpf', $user->cpf, array('placeholder' => '','class' => 'form-control cpf')) !!}
                                </div>
                            </div>
                        </div>    

                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <strong>Senha:</strong> 
                                @if(isset($matricula->id) && intval($matricula->id) > 0)
                                <span class="small">Deixe o campo de senha vazio para não alterar a senha atual.</span>
                                @endif
                                {!! Form::password('password', array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <strong>Confirma senha:</strong>
                                    {!! Form::password('confirm-password', array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>                      
                    </div>
                </div>       
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <button name="sair" value="sair" type="submit" class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                            class="fas fa-save"></i> Salvar e sair</button>

                    @if(!isset($matricula->id) || intval($matricula->id) == 0)
                        <button name="continuar" value="continuar" type="submit" class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                            class="fas fa-save"></i> Salvar e continuar</button>
                    @endif
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>


        <link href="{{ asset('vendor/kartik-v/dependent-dropdown/css/dependent-dropdown.min.css') }}" media="all"
            rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="{{ asset('vendor/kartik-v/dependent-dropdown/js/dependent-dropdown.min.js') }}">
        </script>
        <script type="text/javascript" src="{{ asset('vendor/kartik-v/dependent-dropdown/js/locales/pt-BR.js') }}"></script>

        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>

        <script>
            $("#plano_id").depdrop({
                url: '/matriculas/planos',
                depends: ['empresa_id'],
                loadingText: 'Carregando...',
                placeholder: 'Escolha...',
                initialize: false,
                initDepends: ['empresa_id'],
            });

            $("#curso_id").depdrop({
                url: '/matriculas/cursos',
                depends: ['empresa_id', 'plano_id'],
                loadingText: 'Carregando...',
                placeholder: 'Escolha...',
                initialize: false,
                initDepends: ['modulo_id'],
            });

            $(document).ready(function(){
                $("input.phone")
                .mask("(99) 9999-9999?9")
                .focusout(function (event) {  
                    var target, phone, element;  
                    target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
                    phone = target.value.replace(/\D/g, '');
                    element = $(target);  
                    element.unmask();  
                    if(phone.length > 10) {  
                        element.mask("(99) 99999-999?9");  
                    } else {  
                        element.mask("(99) 9999-9999?9");  
                    }  
                });
                $("input.data_limite").mask("99/99/9999");
                $("input.cpf").mask("999.999.999-99")
            });
        </script>
        
        <!-- Laravel Javascript Validation -->
        <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
        {!! $validator->selector('#edit-form') !!}

@endsection
