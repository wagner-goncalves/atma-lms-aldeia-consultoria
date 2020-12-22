@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    <i class="fas fa-file-alt"></i> Gerenciar módulos
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <a href="{{ route('modulos.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Modulo</a>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <form class="form-inline" method="GET" action="{{ \Request::getRequestUri() }}">
                        <div class="form-group mb-2">
                            <input type="text" class="form-control form-control-sm" id="filter" name="filter"
                                placeholder="Palavra-chave" value="{{ $filter }}">
                        </div>
                        &nbsp;<button type="submit" class="btn btn-sm btn-secondary mb-2">Filtrar</button>
                        &nbsp;<a href="{{ route('modulos.index') }}" class="btn btn-sm btn-link mb-2">limpar</a>
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
                    <th>@sortablelink('curso_nome', 'Curso')</th>
                    <th>@sortablelink('titulo', 'nome')</th>
                    <th>@sortablelink('descricao', 'Descrição')</th>
                    <th>Ações</th>
                </tr>
                @forelse ($modulos as $modulo)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td class="small"><b>Curso:</b> {{ $modulo->curso->nome }}</td>
                        <td><a href="{{ route('modulos.edit', $modulo->id) }}">{{ $modulo->nome }}</a></td>
                        <td>{!! $modulo->descricao !!}</td>
                        <td nowrap>
                            <a class="btn btn-sm btn-primary" href="{{ route('modulos.edit', $modulo->id) }}"><i
                                    class="fas fa-edit"></i></a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['modulos.destroy', $modulo->id], 'style'
                            => 'display:inline']) !!}
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>

                            <a class="btn btn-sm btn-secondary" href="{{ route('aulas.index', ['modulo_id' => $modulo->id, 'curso_id' => $modulo->curso->id]) }}">Aulas <i
                                class="fas fa-arrow-right"></i></a>
  
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
            {!! $modulos->appends(request()->query())->links() !!}
        </div>
    </div>

@endsection
