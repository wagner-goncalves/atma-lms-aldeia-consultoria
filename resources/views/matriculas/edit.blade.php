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
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <strong>Tempo de acesso:</strong>
                                {!! Form::input('number', 'tempo_acesso', $matricula->tempo_acesso, ['placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <strong>Data limite do curso:</strong>
                                    {!! Form::text('data_limite', $matricula->data_limite, ['placeholder' => '', 'class' => 'form-control', 'id' =>
                                    'descricao']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <h4><i class="fas fa-user"></i> Dados do aluno</h4>
                    {!! Form::hidden('user_id', $matricula->user->id) !!}
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <strong>Nome:</strong>
                                {!! Form::text('name', $matricula->user->name, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <strong>E-mail:</strong>
                                    {!! Form::email('email', $matricula->user->email, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <strong>Telefone:</strong>
                                    {!! Form::text('phone', $matricula->user->phone, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>                
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <strong>Senha:</strong> <span class="small">Deixe o campo de senha vazio para não alterar a senha atual.</span>
                                {!! Form::password('password', array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
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
                    <button type="submit" class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                            class="fas fa-save"></i> Salvar</button>
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

    <script>
        $("#modulo_id").depdrop({
            url: '/matriculas/modulos',
            depends: ['empresa_id'],
            loadingText: 'Carregando...',
            placeholder: 'Escolha...',
            initialize: true,
            initDepends: ['empresa_id'],
        });

        $("#aula_id").depdrop({
            url: '/matriculas/aulas',
            depends: ['empresa_id', 'modulo_id'],
            loadingText: 'Carregando...',
            placeholder: 'Escolha...',
            initialize: false,
            initDepends: ['modulo_id'],
        });

    </script>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! $validator->selector('#edit-form') !!}

@endsection
