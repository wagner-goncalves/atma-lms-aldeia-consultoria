@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    @if(!isset($questionario->id) || intval($questionario->id) == 0)
                    <i class="fas fa-plus"></i> Novo questionário
                    @else
                    <i class="fas fa-edit"></i> Editar questionário
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
                        <a href="{{ route('questionarios.index') }}"
                            class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                                class="fas fa-chevron-left"></i> Voltar</a> 
                        @if(intval($questionario->id) > 0)
                            {!! Form::open(['method' => 'DELETE', 'route' =>
                            ['questionarios.destroy', $questionario->id], 'style' => 'display:inline']) !!}
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


            @if(!isset($questionario->id) || intval($questionario->id) == 0)
                {!! Form::open(['route' => 'questionarios.store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'edit-form']) !!}
            @else
                {!! Form::model($questionario, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'id' => 'edit-form',
                'route' => ['questionarios.update', isset($questionario->id) ? $questionario->id : 0]]) !!}
            @endif
            @csrf
            <div class="row">
                @php
                $curso_id = intval($questionario->id) == 0 ? 0 : $questionario->curso->id ;
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
                    <div class="form-group">
                        <strong>Nome:</strong>
                        {!! Form::text('nome', $questionario->nome, ['placeholder' => '', 'class' => 'form-control']) !!}
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

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! $validator->selector('#edit-form') !!}

@endsection
