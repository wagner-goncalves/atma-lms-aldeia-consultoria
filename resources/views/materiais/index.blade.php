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
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <a href="{{ route('materiais.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Material</a>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <form class="form-inline" method="GET" action="{{ \Request::getRequestUri() }}">
                        <div class="form-group mb-2">
                            <input type="text" class="form-control form-control-sm" id="filter" name="filter"
                                placeholder="Palavra-chave" value="{{ $filter }}">
                        </div>
                        <button type="submit" class="btn btn-sm btn-link mb-2">Filtrar</button>
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
                    <th width="280px">Ações</th>
                </tr>
                @forelse ($materiais as $material)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td class="small"><b>Curso:</b> {{ $material->aula->modulo->curso->nome }}<br />
                            <b>Modulo:</b> {{ $material->aula->modulo->nome }}<br />
                            <b> Aula:</b> {{ $material->aula->titulo }}</td>
                        <td><a href="{{ route('materiais.edit', $material->id) }}">{{ $material->titulo }}</a></td>
                        <td>{!! $material->descricao !!}</td>
                        <td>
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

@endsection
