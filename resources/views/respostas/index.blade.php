@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    <i class="fas fa-file-alt"></i> Gerenciar respostas
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                        <a href="{{ route('respostas.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Resposta</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12">


                    <form method="GET" action="{{ \Request::getRequestUri() }}">
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="questionario_id" class="small"><strong>Curso</strong></label>
                                <select id="curso_id" name="curso_id" class="form-control form-control-sm">
                                    <option value="">Todos</option>
                                    @foreach ($cursos as $curso)
                                        <option value="{{ $curso->id }}" {{ $curso_id == $curso->id ? 'selected' : '' }}>
                                            {{ $curso->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col">
                                <label for="questionario_id" class="small"><strong>Questionário</strong></label>
                                <select id="questionario_id" name="questionario_id" class="form-control form-control-sm">
                                    <option value="">Todos</option>
                                    @foreach ($questionarios as $questionario)
                                        <option value="{{ $questionario->id }}" {{ $questionario_id == $questionario->id ? 'selected' : '' }}>
                                            {{ $questionario->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col">
                                <label for="pergunta_id" class="small"><strong>Pergunta</strong></label>
                                <select id="pergunta_id" name="pergunta_id" class="form-control form-control-sm">
                                    <option value="">Todos</option>
                                    @foreach ($perguntas as $pergunta)
                                        <option value="{{ $pergunta->id }}" {{ $pergunta_id == $pergunta->id ? 'selected' : '' }}>
                                            {{ $pergunta->pergunta }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>                            
                            <div class="form-group col">
                                <label for="questionario_id" class="small"><strong>Palavra-chave</strong></label>
                                <input type="text" class="form-control form-control-sm" id="filter" name="filter"
                                        placeholder="Palavra-chave" value="{{ $filter }}">
                            </div>
                            <div class="form-group col">
                                <label for="questionario_id" class="small"><strong>&nbsp;</strong></label>
                                <div>
                                    <button type="submit" class="btn btn-sm btn-secondary mb-2">Filtrar</button>
                                    &nbsp;<a href="{{ route('respostas.index') }}" class="btn btn-sm btn-link mb-2">limpar</a>
                                </div>
                            </div>                            
                        </div>
                    </form>

                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-exclamation-circle fa-lg"></i> {{ $message }}
                </div>
            @endif

            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th>@sortablelink('curso_nome', 'Curso') / questionário / pergunta</th>
                    <th>@sortablelink('resposta', 'Resposta')</th>
                    <th>Ações</th>
                </tr>
                @forelse ($respostas as $resposta)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td class="small"><b>Curso:</b> {{ $resposta->pergunta->questionario->curso->nome }}<br />
                            <b>Questionario:</b> {{ $resposta->pergunta->questionario->nome }}<br />
                            <b> Pergunta:</b> {{ $resposta->pergunta->pergunta }}</td>
                        <td><a href="{{ route('respostas.edit', $resposta->id) }}">{{ $resposta->resposta }}</a></td>
                        <td nowrap>
                            <a class="btn btn-sm btn-primary" href="{{ route('respostas.edit', $resposta->id) }}"><i
                                    class="fas fa-edit"></i></a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['respostas.destroy', $resposta->id], 'style'
                            => 'display:inline']) !!}
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="6"><i class="fas fa-frown"></i> Nenhum registro encontrado.</td>
                </tr>                
                @endforelse
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-3">
            {!! $respostas->appends(request()->query())->links() !!}
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

        $("#pergunta_id").depdrop({
            url: '/respostas/perguntas',
            depends: ['questionario_id'],
            loadingText: 'Carregando...',
            placeholder: 'Escolha...',
            //initialize: true,
            //initDepends: ['curso_id'],
        });        

    </script>

@endsection
