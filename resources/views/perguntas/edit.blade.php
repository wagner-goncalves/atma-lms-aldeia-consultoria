@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    @if (!isset($pergunta->id) || intval($pergunta->id) == 0)
                        <i class="fas fa-plus"></i> Nova pergunta
                    @else
                        <i class="fas fa-edit"></i> Editar pergunta
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
                        <a href="{{ route('perguntas.index') }}"
                            class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                                class="fas fa-chevron-left"></i> Voltar</a>
                        @if (intval($pergunta->id) > 0)
                            {!! Form::open(['method' => 'DELETE', 'route' => ['perguntas.destroy', $pergunta->id], 'style'
                            => 'display:inline']) !!}
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


            @if (!isset($pergunta->id) || intval($pergunta->id) == 0)
                {!! Form::open(['route' => 'perguntas.store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id'
                => 'edit-form']) !!}
            @else
                {!! Form::model($pergunta, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'id' => 'edit-form',
                'route' => ['perguntas.update', isset($pergunta->id) ? $pergunta->id : 0]]) !!}
            @endif
            @csrf
            <div class="row">
                @php
                $curso_id = intval($pergunta->id) == 0 ? 0 : $pergunta->questionario->curso->id ;
                @endphp

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="curso_id"><strong>Curso</strong></label>
                            <select id="curso_id" name="curso_id" class="form-control">
                                <option value="">Escolha</option>
                                @foreach ($cursos as $curso)
                                    <option value="{{ $curso->id }}" {{ $curso_id == $curso->id ? 'selected' : '' }}>
                                        {{ $curso->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="questionario_id"><strong>Questionário</strong></label>
                            <select id="questionario_id" name="questionario_id" class="form-control">
                                @if ($curso_id > 0)
                                    <option value="{{ $pergunta->questionario->id }}" selected>
                                        {{ $pergunta->questionario->nome }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Pergunta:</strong>
                        {!! Form::text('pergunta', $pergunta->pergunta, ['placeholder' => '', 'class' => 'form-control'])
                        !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Número da questão:</strong>
                        {!! Form::input('number', 'ordem', $pergunta->ordem, ['placeholder' => '', 'class' => 'form-control
                        col-12']) !!}
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
        $("#questionario_id").depdrop({
            url: '/respostas/questionarios',
            depends: ['curso_id'],
            loadingText: 'Carregando...',
            placeholder: 'Escolha...',
            //initialize: true,
            //initDepends: ['curso_id'],
        });

    </script>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! $validator->selector('#edit-form') !!}

@endsection
