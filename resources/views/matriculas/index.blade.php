@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    <i class="fas fa-pencil-alt"></i> Gerenciar matrículas
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                        <a href="{{ route('matriculas.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Matricula</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12">


                    <form method="GET" action="{{ \Request::getRequestUri() }}">
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="empresa_id" class="small"><strong>Empresa</strong></label>
                                <select id="empresa_id" name="empresa_id" class="form-control form-control-sm">
                                    <option value="">Todas</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id }}" {{ $empresa_id == $empresa->id ? 'selected' : '' }}>
                                            {{ $empresa->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>   

                            <div class="form-group col">
                                <label for="plano_id" class="small"><strong>Plano</strong></label>
                                <select id="plano_id" name="plano_id" class="form-control form-control-sm">
                                    <option value="">Todos</option>
                                    @foreach ($planos as $plano)
                                        <option value="{{ $plano->id }}" {{ $plano_id == $plano->id ? 'selected' : '' }}>
                                            {{ $plano->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col">
                                <label for="curso_id" class="small"><strong>Curso</strong></label>
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
                                <label for="filter" class="small"><strong>Palavra-chave</strong></label>
                                <input type="text" class="form-control form-control-sm" id="filter" name="filter"
                                        placeholder="Palavra-chave" value="{{ $filter }}">
                            </div>
                            <div class="form-group col">
                                <label class="small"><strong>&nbsp;</strong></label>
                                <div>
                                    <button type="submit" class="btn btn-sm btn-secondary mb-2">Filtrar</button>
                                    &nbsp;<a href="{{ route('matriculas.index') }}" class="btn btn-sm btn-link mb-2">limpar</a>
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
                    <th>@sortablelink('empresa_nome', 'Empresa') / @sortablelink('plano_nome', 'Plano') / @sortablelink('curso_nome', 'Curso')</th>
                    <th>Matrícula</th>
                    <th>Aluno</th>
                    <th>Data limite</th>
                    <th>Data de conclusão</th>
                    <th>Ações</th>
                </tr>
                @forelse ($matriculas as $matricula)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td class="small"><b>Empresa:</b> {{ $matricula->empresa->nome }}<br />
                            <b>Plano:</b> {{ $matricula->plano->nome }}<br />
                            <b>Curso:</b> {{ $matricula->curso->nome }}</td>
                        <td><a href="{{ route('matriculas.edit', $matricula->id) }}">{{ $matricula->id }}</a></td>
                        <td>{{ $matricula->user->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($matricula->data_limite)->format('d/m/Y')}}</td>
                        <td>{{ empty($matricula->data_conclusao) ?: \Carbon\Carbon::parse($matricula->data_conclusao)->format('d/m/Y') }}</td>
                        <td nowrap>
                            <a class="btn btn-sm btn-primary" href="{{ route('matriculas.edit', $matricula->id) }}"><i
                                    class="fas fa-edit"></i></a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['matriculas.destroy', $matricula->id], 'style'
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
            {!! $matriculas->appends(request()->query())->links() !!}
        </div>
    </div>

    <link href="{{ asset('vendor/kartik-v/dependent-dropdown/css/dependent-dropdown.min.css') }}" media="all"
        rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{ asset('vendor/kartik-v/dependent-dropdown/js/dependent-dropdown.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('vendor/kartik-v/dependent-dropdown/js/locales/pt-BR.js') }}"></script>

    <script>

        $("#plano_id").depdrop({
            url: '/matriculas/planos',
            depends: ['empresa_id'],
            loadingText: 'Carregando...',
            placeholder: 'Escolha...',
            //initialize: true,
            //initDepends: ['curso_id'],
        });

        $("#curso_id").depdrop({
            url: '/matriculas/cursos',
            depends: ['plano_id'],
            loadingText: 'Carregando...',
            placeholder: 'Escolha...',
            //initialize: true,
            //initDepends: ['curso_id'],
        }); 
     

    </script>

@endsection
