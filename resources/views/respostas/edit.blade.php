@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    @if (!isset($resposta->id) || intval($resposta->id) == 0)
                        <i class="fas fa-plus"></i> Nova opção de resposta
                    @else
                        <i class="fas fa-edit"></i> Editar opção de resposta
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
                        <a href="{{ route('respostas.index') }}"
                            class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                                class="fas fa-chevron-left"></i> Voltar</a>
                        @if (intval($resposta->id) > 0)
                            {!! Form::open(['method' => 'DELETE', 'route' => ['respostas.destroy', $resposta->id], 'style'
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


            @if (!isset($resposta->id) || intval($resposta->id) == 0)
                {!! Form::open(['route' => 'respostas.store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id'
                => 'edit-form']) !!}
            @else
                {!! Form::model($resposta, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'id' => 'edit-form',
                'route' => ['respostas.update', isset($resposta->id) ? $resposta->id : 0]]) !!}
            @endif
            @csrf
            <div class="row">
                @php
                $curso_id = intval($resposta->id) == 0 ? 0 : $resposta->pergunta->questionario->curso->id ;
                @endphp

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="curso_id"><strong>Curso</strong></label>
                            <select id="curso_id" name="curso_id" class="form-control">
                                <option value="">Escolha...</option>
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
                                    <option value="{{ $resposta->pergunta->questionario->id }}" selected>
                                        {{ $resposta->pergunta->questionario->nome }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Pergunta:</strong>
                        <select id="pergunta_id" name="pergunta_id" class="form-control">
                            @if ($curso_id > 0)
                                <option value="{{ $resposta->pergunta_id }}" selected>{{ $resposta->pergunta->titulo }}
                                </option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">

                    <div class="form-group">
                        <strong>Resposta:</strong>
                        {!! Form::text('resposta', $resposta->titulo, ['placeholder' => '', 'class' => 'form-control']) !!}
                    </div>

                </div>

                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Letra da resposta (A, B etc):</strong>
                        {!! Form::text('ordem', $resposta->ordem, ['placeholder' => '', 'class' => 'form-control'])
                        !!}
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

    <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea#descricao',
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'bold italic | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat'
        });

    </script>

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
            initialize: true,
            initDepends: ['curso_id'],
        });

        $("#pergunta_id").depdrop({
            url: '/respostas/perguntas',
            depends: ['curso_id', 'questionario_id'],
            loadingText: 'Carregando...',
            placeholder: 'Escolha...',
            initialize: false,
            initDepends: ['questionario_id'],
        });

    </script>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! $validator->selector('#edit-form') !!}

@endsection
