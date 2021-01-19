@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    @if (!isset($modulo->id) || intval($modulo->id) == 0)
                        <i class="fas fa-plus"></i> Novo módulo
                    @else
                        <i class="fas fa-edit"></i> Editar módulo
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
                        <a href="{{ route('modulos.index') }}"
                            class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                                class="fas fa-chevron-left"></i> Voltar</a>
                        @if (intval($modulo->id) > 0)
                            {!! Form::open(['method' => 'DELETE', 'route' => ['modulos.destroy', $modulo->id], 'style' =>
                            'display:inline']) !!}
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


            @if (!isset($modulo->id) || intval($modulo->id) == 0)
                {!! Form::open(['route' => 'modulos.store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' =>
                'edit-form']) !!}
            @else
                {!! Form::model($modulo, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'id' => 'edit-form',
                'route' => ['modulos.update', isset($modulo->id) ? $modulo->id : 0]]) !!}
            @endif
            @csrf
            <div class="row">
                @php
                $curso_id = intval($modulo->id) == 0 ? 0 : $modulo->curso->id ;
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
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <strong>Nome:</strong>
                                {!! Form::text('nome', $modulo->nome, ['placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="form-group">
                                <strong>Ordem:</strong>
                                {!! Form::input('number', 'ordem', $modulo->ordem, ['placeholder' => '', 'class' =>
                                'form-control col-6']) !!}
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <strong>Módulo bônus?</strong>
                                <p>
                                    <input type="radio" id="modulo_padrao_0" name="modulo_padrao" value="0"
                                        {{ $modulo->modulo_padrao == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="modulo_padrao_0"> Sim </label>
                                    <input type="radio" id="modulo_padrao_1" name="modulo_padrao" value="1"
                                        {{ $modulo->modulo_padrao != 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="modulo_padrao_1"> Não </label>
                                </p>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Descrição:</strong>
                        {!! Form::textarea('descricao', $modulo->descricao, ['placeholder' => '', 'class' => 'form-control',
                        'id' => 'descricao']) !!}
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

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! $validator->selector('#edit-form') !!}

@endsection
