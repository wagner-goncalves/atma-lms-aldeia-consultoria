@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    <i class="fas fa-file-import fa-lg"></i> Resultado da importação
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <a href="{{ route('matriculas.index') }}"
                            class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase"><i
                                class="fas fa-chevron-left"></i> Voltar</a> 
                    </div>
                </div>
            </div>
        </div>
    </div>            


    <div class="row">
        <div class="col-lg-12 mb-3">
            <strong><h4>Matrículas realizadas</h4></strong>
        </div>
        <div class="col-lg-12 mb-3">
            <table class="table table-bordered">
                <tr class="bg-success">
                    <th>Linha</th>
                    <th>Mensagem</th>
                </tr>
                @forelse ($matriculaParser->sucessos() as $log)
                    <tr>
                        <td>{{$log->linha}}</td>
                        <td>{{$log->mensagem}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6"><i class="fas fa-frown"></i> Nenhum registro.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12 mb-3">
            <strong><h4>Erros de importação</h4></strong>
        </div>
        <div class="col-lg-12 mb-3">
            <table class="table table-bordered">
                <tr class="bg-danger">
                    <th>Linha</th>
                    <th>Mensagem</th>
                </tr>
                @forelse ($matriculaParser->erros() as $log)
                    <tr>
                        <td>{{$log->linha}}</td>
                        <td>{{$log->mensagem}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6"><i class="fas fa-frown"></i> Nenhum registro.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-3">
            <strong><h4>Alertas</h4></strong>
        </div>
        <div class="col-lg-12 mb-3">
            <table class="table table-bordered">
                <tr class="bg-warning">
                    <th>Linha</th>
                    <th>Mensagem</th>
                </tr>
                @forelse ($matriculaParser->alertas() as $log)
                    <tr>
                        <td>{{$log->linha}}</td>
                        <td>{{$log->mensagem}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6"><i class="fas fa-frown"></i> Nenhum registro.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>    

@endsection
