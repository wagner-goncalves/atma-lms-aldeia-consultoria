@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    <i class="fas fa-question-circle"></i> Gerenciar questionários
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                        <a href="{{ route('questionarios.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Questionário</a>
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
                                <label for="questionario_id" class="small"><strong>Palavra-chave</strong></label>
                                <input type="text" class="form-control form-control-sm" id="filter" name="filter"
                                        placeholder="Palavra-chave" value="{{ $filter }}">
                            </div>
                            <div class="form-group col">
                                <label for="questionario_id" class="small"><strong>&nbsp;</strong></label>
                                <div>
                                    <button type="submit" class="btn btn-sm btn-secondary mb-2">Filtrar</button>
                                    &nbsp;<a href="{{ route('questionarios.index') }}" class="btn btn-sm btn-link mb-2">limpar</a>
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

            @if ($message = Session::get('error'))
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle fa-lg"></i> {!! $message !!}
                </div>
            @endif                

            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th>@sortablelink('curso_nome', 'Curso')</th>
                    <th>@sortablelink('nome', 'nome')</th>
                    <th>Ações</th>
                </tr>
                @forelse ($questionarios as $questionario)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td class="small"><b>Curso:</b> {{ $questionario->curso->nome }}</td>
                        <td><a href="{{ route('questionarios.edit', $questionario->id) }}">{{ $questionario->nome }}</a></td>
                        <td nowrap>
                            <a class="btn btn-sm btn-primary" href="{{ route('questionarios.edit', $questionario->id) }}"><i
                                    class="fas fa-edit"></i></a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['questionarios.destroy', $questionario->id], 'style'
                            => 'display:inline']) !!}
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>

                            <a class="btn btn-sm btn-secondary" href="{{ route('perguntas.index', ['questionario_id' => $questionario->id, 'curso_id' => $questionario->curso->id]) }}">Perguntas <i
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
            {!! $questionarios->appends(request()->query())->links() !!}
        </div>
    </div>

@endsection
