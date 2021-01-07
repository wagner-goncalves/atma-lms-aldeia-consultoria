@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    @if (!isset($plano->id) || intval($plano->id) == 0)
                        <i class="fas fa-plus"></i> Nova plano
                    @else
                        <i class="fas fa-edit"></i> Editar plano
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
                        <a href="{{ route('planos.index') }}"
                            class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                                class="fas fa-chevron-left"></i> Voltar</a>
                        @if (intval($plano->id) > 0)
                            {!! Form::open(['method' => 'DELETE', 'route' => ['planos.destroy', $plano->id], 'style' =>
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


            @if (!isset($plano->id) || intval($plano->id) == 0)
                {!! Form::open(['route' => 'planos.store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' =>
                'edit-form']) !!}
            @else
                {!! Form::model($plano, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'id' => 'edit-form',
                'route' => ['planos.update', isset($plano->id) ? $plano->id : 0]]) !!}
            @endif
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <strong>Nome:</strong>
                                {!! Form::text('nome', $plano->nome, ['placeholder' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <strong>Empresas:</strong>
                                {!! Form::select('empresa_id[]', $empresas, $planoEmpresas, ['class' => 'form-control',
                                'multiple']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Descrição:</strong>
                        {!! Form::textarea('descricao', $plano->descricao, ['placeholder' => '', 'class' => 'form-control',
                        'id' => 'descricao']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">

                    <div class="form-group">
                        <strong>Plano x Curso</strong>
                        <table class="table table-bordered table-sm small">
                            <tr>
                                <th>Curso</th>
                                <th>Quantidade de alunos</th>
                                <th>Tempo de acesso (dias)</th>
                            </tr>

                            @forelse ($cursos as $curso)
                                @php
                                $plano_pivot = $plano->cursos()->find($curso->id);
                                @endphp
                                <tr>
                                    <td>{{ $curso->nome }}
                                        {!! Form::hidden('curso_id[]', $curso->id) !!}
                                    </td>
                                    <td class="small">{!! Form::number('usuarios[]', (is_object($plano_pivot) ? $plano_pivot->pivot->usuarios : ""),
                                        ['placeholder' => '', 'class' => 'form-control text-right']) !!}</td>
                                    <td>{!! Form::number('tempo_acesso[]', (is_object($plano_pivot) ? $plano_pivot->pivot->tempo_acesso : ""), ['placeholder' =>
                                        '', 'class' => 'form-control text-right']) !!}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"><i class="fas fa-frown"></i> Nenhum curso vinculado ao plano encontrado.
                                    </td>
                                </tr>
                            @endforelse
                        </table>
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
