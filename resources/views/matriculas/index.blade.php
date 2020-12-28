@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left pb-3">
                <div class="titulo-destaque">
                    <i class="fas fa-file-signature"></i> Gerenciar matrículas
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                        <a href="{{ route('matriculas.create') }}" class="btn btn-success"><i class="fas fa-plus"></i>
                            Matricula</a>
                    </div>
                </div>
            </div>
            <form method="GET" action="{{ \Request::getRequestUri() }}" enctype='multipart/form-data'>
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="empresa_id" class="small"><strong>Empresa</strong></label>
                                <select id="empresa_id" name="empresa_id" class="form-control form-control-sm">
                                    <option value="">Todas</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id }}"
                                            {{ $empresa_id == $empresa->id ? 'selected' : '' }}>
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
                                    &nbsp;<a href="{{ route('matriculas.index') }}"
                                        class="btn btn-sm btn-link mb-2">limpar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    {!! Form::open(['route' => 'matriculas.importar', 'method' => 'post', 'enctype' =>
                    'multipart/form-data', 'id' => 'form-matricula']) !!}
                    <script>
                        $(document).ready(function() {
                            $('#form-matricula').on('submit', function(e) {

                                var empresa = parseInt($("#empresa_id").val());
                                var plano = parseInt($("#plano_id").val());
                                var curso = parseInt($("#curso_id").val());

                                console.log(empresa, plano, curso);

                                if (empresa > 0 && plano > 0 && curso > 0) {
                                    if ($("#arquivo_matricula").val() == '') {
                                        $('#mensagem_modal').html(
                                            "Escolha um arquivo para importação das matrículas.");
                                        $('#modal-mensagem').modal();
                                    } else {
                                        $("#empresa_id_matricula").val(empresa);
                                        $("#plano_id_matricula").val(plano);
                                        $("#curso_id_matricula").val(curso);
                                        $("#btn-importar:first i").removeClass("fa-file-import").addClass(
                                            "fa-spin fa-spinner");
                                        return;
                                    }
                                } else {
                                    $('#mensagem_modal').html(
                                        "Para importar alunos e matriculá-los, escolha obrigatoriamente: a Empresa, o Plano contratado e o Curso."
                                    );
                                    $('#modal-mensagem').modal();
                                }

                                e.preventDefault();

                            });
                        });

                    </script>

                    {!! Form::hidden('empresa_id', null, ['id' => 'empresa_id_matricula']) !!}
                    {!! Form::hidden('plano_id', null, ['id' => 'plano_id_matricula']) !!}
                    {!! Form::hidden('curso_id', null, ['id' => 'curso_id_matricula']) !!}

                    <div class="modal" tabindex="-1" role="dialog" id="modal-mensagem">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Atenção!</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p id="mensagem_modal"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body small">
                            <h5 class="card-title">Importar arquivo de matrículas</h5>
                            <p class="card-text">Obrigatóriamente, use os filtros acima para indicar em qual curso serão realizadas as matrículas importadas. Veja o <a href="{{ asset('docs/Exemplo_Importacao_Matriculas.xlsx') }}">exemplo</a> de arquivo de matrículas.</p>
                            <p class="card-text"><input name="arquivo" type="file" id="arquivo_matricula"></p>
                            <button id="btn-importar" type="submit" class="btn btn-sm btn-primary mb-2"><i
                                    class="fas fa-file-import fa-lg"></i> Importar</button>
                        </div>
                    </div>


                    {!! Form::close() !!}
                </div>

                <div class="col-lg-6 col-sm-6">
                    {!! Form::open(['route' => 'matriculas.exportar', 'method' => 'post', 'id' => 'form-exportar']) !!}
                    <script>
                        $(document).ready(function() {
                            $('#form-exportar').on('submit', function(e) {

                                var empresa = parseInt($("#empresa_id").val());
                                var plano = parseInt($("#plano_id").val());
                                var curso = parseInt($("#curso_id").val());

                                $("#empresa_id_exportar").val(empresa);
                                $("#plano_id_exportar").val(plano);
                                $("#curso_id_exportar").val(curso);

                                return;

                                //e.preventDefault();

                            });
                        });

                    </script>

                    {!! Form::hidden('empresa_id', null, ['id' => 'empresa_id_exportar']) !!}
                    {!! Form::hidden('plano_id', null, ['id' => 'plano_id_exportar']) !!}
                    {!! Form::hidden('curso_id', null, ['id' => 'curso_id_exportar']) !!}



                    <div class="card">
                        <div class="card-body small">
                            <h5 class="card-title">Exportar dados de alunos e matrículas</h5>
                            <p class="card-text">Opcionalmente, use os filtros acima para personalizar o relatório.</p>
                            <button id="btn-exportar" type="submit" class="btn btn-sm btn-primary mb-2"><i
                                    class="fas fa-file-excel fa-lg"></i> Exportar</button>
                        </div>
                    </div>



                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-12 col-sm-12">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-exclamation-circle fa-lg"></i> {{ $message }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <tr>
                            <th>#</th>
                            <th>@sortablelink('empresa_nome', 'Empresa') / @sortablelink('plano_nome', 'Plano') /
                                @sortablelink('curso_nome', 'Curso')</th>
                            <th>Matrícula</th>
                            <th>Aluno</th>
                            <th>@sortablelink('data_limite', 'Data limite')</th>
                            <th>@sortablelink('data_conclusao', 'Data de conclusão')</th>
                            <th>Ações</th>
                        </tr>
                        @forelse ($matriculas as $matricula)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td class="small"><b>Empresa:</b> {{ $matricula->empresa->nome }}<br />
                                    <b>Plano:</b> {{ $matricula->plano->nome }}<br />
                                    <b>Curso:</b> {{ $matricula->curso->nome }}
                                </td>
                                <td><a href="{{ route('matriculas.edit', $matricula->id) }}">{{ $matricula->id }}</a></td>
                                <td><a href="{{ route('matriculas.edit', $matricula->id) }}">{{ $matricula->user->name }}</a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($matricula->data_limite)->format('d/m/Y') }}</td>
                                <td>{{ empty($matricula->data_conclusao) ? 'Não concluído' : \Carbon\Carbon::parse($matricula->data_conclusao)->format('d/m/Y') }}
                                </td>
                                <td nowrap>
                                    <a class="btn btn-sm btn-primary" href="{{ route('matriculas.edit', $matricula->id) }}"><i
                                            class="fas fa-edit"></i></a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['matriculas.destroy', $matricula->id],
                                    'style' => 'display:inline']) !!}
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
