@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">

                <div class="titulo-destaque">
                    <i class="fas fa-video"></i>
                    Assistir aula
                </div>

            </div>
            <hr />
            <div>
                <div class="row">
                    <div class="col-12 col-md-8 col-sm-12">
                        <h1>{{ $curso->nome }}</h1>
                    </div>
                    <div class="col-12 col-md-4 col-sm-12 text-right">
                        <a href="{{ route('home') }}" class="btn btn-success"><i class="fas fa-chevron-left"></i> Voltar</a>
                        <button type="button" class="btn btn-danger"><i class="fa fa-users"></i> Fórum de discussão</button>
                    </div>
                </div>

                @forelse ($aulas as $aula)
                    <div class="row">
                        <div class="col-12">
                            <h3>Módulo {{ $aula->modulo->ordem }} - Aula: {{ $aula->titulo }}</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-8 col-sm-12 mb-3">
                            <div class="embed-responsive embed-responsive-16by9">
                                {!! $aula->link !!}
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-sm-12 mb-3">
                            <div class="card" style="width: 100%">
                                <div class="list-group">
                                    <span class="list-group-item list-group-item-action flex-column align-items-start active">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">Materiais da aula</h5>
                                        </div>
                                    </span>
                                    @forelse ($aula->materiais as $material)
                                        <a href="{{ route('materiais.download', ['id' => $material->id]) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">{{$material->titulo}}</h5>
                                                <small class="text-muted"><i class="fas fa-download"></i></small>
                                            </div>
                                            @if (!empty($material->descricao))
                                            <p class="mb-1">{!!$material->descricao!!}</p>
                                            @endif
                                        </a>
                                    @empty
                                        <span class="list-group-item list-group-item-action flex-column align-items-start">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">Nenhum material para esta aula.</h5>
                                            </div>
                                        </span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                <div class="row mt-3">
                    <div class="col">
                    @error('alunoMatriculado')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>                    
                    @enderror

                    @error('cursoNoPrazo')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>                    
                    @enderror
                    
                    @error('aulaCorreta')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>                    
                    @enderror                    
                    </div>
                </div>
                @endforelse

                @if($aulas)
                <div class="row mt-3">
                    <div class="col-lg-12 mb-3 text-right">
                        {!! $aulas->appends(request()->query())->links() !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
