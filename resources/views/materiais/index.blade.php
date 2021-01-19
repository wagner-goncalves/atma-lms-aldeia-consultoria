@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    <i class="fas fa-file-alt"></i> Gerenciar materiais
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                        <a href="{{ route('materiais.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Material</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12">


                    <form method="GET" action="{{ \Request::getRequestUri() }}">
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="modulo_id" class="small"><strong>Curso</strong></label>
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
                                <label for="modulo_id" class="small"><strong>Módulo</strong></label>
                                <select id="modulo_id" name="modulo_id" class="form-control form-control-sm">
                                    <option value="">Todos</option>
                                    @foreach ($modulos as $modulo)
                                        <option value="{{ $modulo->id }}" {{ $modulo_id == $modulo->id ? 'selected' : '' }}>
                                            {{ $modulo->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col">
                                <label for="aula_id" class="small"><strong>Aula</strong></label>
                                <select id="aula_id" name="aula_id" class="form-control form-control-sm">
                                    <option value="">Todos</option>
                                    @foreach ($aulas as $aula)
                                        <option value="{{ $aula->id }}" {{ $aula_id == $aula->id ? 'selected' : '' }}>
                                            {{ $aula->titulo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>                            
                            <div class="form-group col">
                                <label for="modulo_id" class="small"><strong>Palavra-chave</strong></label>
                                <input type="text" class="form-control form-control-sm" id="filter" name="filter"
                                        placeholder="Palavra-chave" value="{{ $filter }}">
                            </div>
                            <div class="form-group col">
                                <label for="modulo_id" class="small"><strong>&nbsp;</strong></label>
                                <div>
                                    <button type="submit" class="btn btn-sm btn-secondary mb-2">Filtrar</button>
                                    &nbsp;<a href="{{ route('materiais.index') }}" class="btn btn-sm btn-link mb-2">limpar</a>
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
                    <th>@sortablelink('curso_nome', 'Curso') / modulo / aula</th>
                    <th>@sortablelink('titulo', 'Material')</th>
                    <th>@sortablelink('descricao', 'Descrição')</th>
                    <th>Ações</th>
                </tr>
                @forelse ($materiais as $material)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td class="small"><b>Curso:</b> 
                            @if($material->modulo)
                            {{ $material->modulo->curso->nome }}<br />
                            @endif
                            @if($material->modulo)
                            <b>Modulo:</b> {{ $material->modulo->nome }}<br />
                            @endif
                            @if($material->aula)
                            <b> Aula:</b> {{ $material->aula->titulo }}
                            @endif
                        </td>
                        <td><a href="{{ route('materiais.edit', $material->id) }}">{{ $material->titulo }}</a></td>
                        <td>{!! $material->descricao !!}</td>
                        <td nowrap>
                            <a class="btn btn-sm btn-primary" href="{{ route('materiais.edit', $material->id) }}"><i
                                    class="fas fa-edit"></i></a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['materiais.destroy', $material->id], 'style'
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
            {!! $materiais->appends(request()->query())->links() !!}
        </div>
    </div>

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
            //initialize: true,
            //initDepends: ['curso_id'],
        });

        $("#aula_id").depdrop({
            url: '/materiais/aulas',
            depends: ['modulo_id'],
            loadingText: 'Carregando...',
            placeholder: 'Escolha...',
            //initialize: true,
            //initDepends: ['curso_id'],
        });        

    </script>

@endsection
