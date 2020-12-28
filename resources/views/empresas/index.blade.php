@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    <i class="fas fa-building"></i> Gerenciar empresas
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                        <a href="{{ route('empresas.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Empresa</a>
                    </div>
                </div>
            </div>            
            <div class="row">                
                <div class="col-lg-12 col-sm-12">
                    <form method="GET" action="{{ \Request::getRequestUri() }}">
                        <div class="form-row">
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
                                <label for="empresa_id" class="small"><strong>Palavra-chave</strong></label>
                                <input type="text" class="form-control form-control-sm" id="filter" name="filter"
                                        placeholder="Palavra-chave" value="{{ $filter }}">
                            </div>
                            <div class="form-group col">
                                <label for="empresa_id" class="small"><strong>&nbsp;</strong></label>
                                <div>
                                    <button type="submit" class="btn btn-sm btn-secondary mb-2">Filtrar</button>
                                    &nbsp;<a href="{{ route('empresas.index') }}" class="btn btn-sm btn-link mb-2">limpar</a>
                                    
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
                    
                    <th>@sortablelink('nome', 'Empresa')</th>
                    <th>Planos</th>
                    <th>@sortablelink('descricao', 'Descrição')</th>
                    <th>Ações</th>
                </tr>

                @forelse ($empresas as $empresa)
                    @php
                        $planos = $empresa->planos()->get();
                    @endphp                
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td><a href="{{ route('empresas.edit', $empresa->id) }}">{{ $empresa->nome }}</a></td>
                        <td class="small"><b>Planos:</b> 
                            @foreach ($planos as $plano)
                                {{$plano->nome}} 
                            @endforeach
                        </td>
                        
                        <td>{!! $empresa->descricao !!}</td>
                        <td nowrap>
                            <a class="btn btn-sm btn-primary" href="{{ route('empresas.edit', $empresa->id) }}"><i
                                    class="fas fa-edit"></i></a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['empresas.destroy', $empresa->id], 'style'
                            => 'display:inline']) !!}
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
  
                            {!! Form::close() !!}
                            <a class="btn btn-sm btn-secondary" href="{{ route('matriculas.index', ['empresa_id' => $empresa->id]) }}">Matrículas <i
                                class="fas fa-arrow-right"></i></a>
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
            {!! $empresas->appends(request()->query())->links() !!}
        </div>
    </div>

@endsection