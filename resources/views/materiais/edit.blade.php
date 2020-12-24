@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    @if(!isset($material->id) || intval($material->id) == 0)
                    <i class="fas fa-plus"></i> Novo material
                    @else
                    <i class="fas fa-edit"></i> Editar material
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
                        <a href="{{ route('materiais.index') }}"
                            class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                                class="fas fa-chevron-left"></i> Voltar</a> 
                        @if(intval($material->id) > 0)
                            {!! Form::open(['method' => 'DELETE', 'route' =>
                            ['materiais.destroy', $material->id], 'style' => 'display:inline']) !!}
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


            @if(!isset($material->id) || intval($material->id) == 0)
                {!! Form::open(['route' => 'materiais.store', 'method' => 'POST', 'id' => 'edit-form']) !!}
            @else
                {!! Form::model($material, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'id' => 'edit-form',
                'route' => ['materiais.update', isset($material->id) ? $material->id : 0]]) !!}
            @endif
            @csrf
            <div class="row">
                @php
                $curso_id = intval($material->id) == 0 ? 0 : $material->aula->modulo->curso->id ;
                @endphp

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="curso_id"><strong>Curso</strong></label>
                            <select id="curso_id" name="curso_id" class="form-control">
                                @foreach ($cursos as $curso)
                                    <option value="{{ $curso->id }}" {{ $curso_id == $curso->id ? 'selected' : '' }}>
                                        {{ $curso->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="modulo_id"><strong>Módulo</strong></label>
                            <select id="modulo_id" name="modulo_id" class="form-control">
                                @if($curso_id > 0)
                                <option value="{{ $material->aula->modulo->id }}" selected>
                                    {{ $material->aula->modulo->nome }}
                                </option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Aula:</strong>
                        <select id="aula_id" name="aula_id" class="form-control">
                            @if($curso_id > 0)
                            <option value="{{ $material->aula_id }}" selected>{{ $material->aula->titulo }}</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <strong>Nome:</strong>
                                {!! Form::text('titulo', $material->titulo, ['placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <strong>Arquivo:</strong>
                                <div>
                                    {!! Form::file('arquivo', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="mt-2">
                                    @if (!empty($material->arquivo))
                                        <a class="btn btn-secondary btn-sm"
                                            href="{{ route('materiais.download', ['id' => $material->id]) }}"><i
                                                class="fas fa-download"></i> Download</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Descrição:</strong>
                        {!! Form::textarea('descricao', $material->descricao, ['placeholder' => '', 'class' => 'form-control', 'id' =>
                        'descricao']) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Ordem de aparição:</strong>
                        {!! Form::input('number', 'ordem', $material->ordem, ['placeholder' => '', 'class' => 'form-control col-1']) !!}
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
        $("#modulo_id").depdrop({
            url: '/materiais/modulos',
            depends: ['curso_id'],
            loadingText: 'Carregando...',
            placeholder: 'Escolha...',
            initialize: true,
            initDepends: ['curso_id'],
        });

        $("#aula_id").depdrop({
            url: '/materiais/aulas',
            depends: ['curso_id', 'modulo_id'],
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
