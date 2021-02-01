@extends('layouts.home')
@inject('Str', 'Illuminate\Support\Str')

@section('content')

    <div class="mb-4">
        <img class="img-fluid" style="width:100%" src="{{ asset('images/banner-curso.png') }}" />
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                @role('Aluno')
                <div>
                    @forelse ($cursos as $curso)
                        <div class="row mb-2">
                            <!-- <div class="col-9">
                                <h1>{{ $curso->nome }}</h1>
                            </div>
                        -->
                            <div class="col-12 text-right">
                                <a href="{{ route('posts.show', ['post' => $curso->id]) }}" class="btn btn-danger pull-right"><i
                                        class="fa fa-users"></i> Fórum de
                                    discussão</a>
                            </div>
                        </div>

                        @php
                        $percentualConclusao = $curso->percentualConclusao();
                        $feedbackRespondido = $curso->feedbackRespondido();
                        $matricula = $curso->matricula();
                        $ultimaAulaVisualizada = $curso->ultimaAulaVisualizada();
                        $tempoRestanteCurso = $curso->tempoRestanteCurso();
                        $ultimaOrdemVisualizada = empty($ultimaAulaVisualizada) ? 0 : $ultimaAulaVisualizada->ordem;
                        @endphp

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="progress" style="height: 30px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $percentualConclusao }}%" aria-valuenow="{{ $percentualConclusao }}"
                                        aria-valuemin="0" aria-valuemax="100">{{ $percentualConclusao }}%</div>
                                </div>
                            </div>
                            <div class="col-12">
                                @if ($tempoRestanteCurso >= 0)
                                    Você tem {{ $tempoRestanteCurso }} {{ Str::plural('dia', $tempoRestanteCurso) }} para
                                    concluir o
                                    curso.
                                @else
                                    <div class="alert alert-danger mt-3" role="alert">
                                        <div class="media">
                                            <i class="fa fa-2x fa-info-circle"></i>
                                            <div class="media-body ml-3 mt-1">
                                                <b>O prazo para visualização das aulas expirou em
                                                    {{ \Carbon\Carbon::parse($matricula->data_limite)->format('d/m/Y') }}</b>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <hr />
                        <div class="pull-left">
                            <div class="titulo-destaque">
                                <i class="fas fa-chalkboard-teacher"></i>
                                Confira a trilha de aprendizado.
                            </div>
                        </div>

                        <p>{!! $curso->descricao !!}</p>

                        @forelse ($curso->modulos as $modulo)

                            <div class="row no-gutters mb-4">
                                <div class="col-md-4 p-3 mb-2 bg-info-aldeia text-white">
                                    @if($modulo->modulo_padrao == 1)
                                    <h3 class="font-weight-bold">Módulo {{ $modulo->ordem }}</h3>
                                    <h5>{{ $modulo->nome }}</h5>
                                    @else
                                    <h3 class="font-weight-bold">{{ $modulo->nome }}</h3>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <div class="media mb-3">
                                            <i class="fa fa-2x fa-fw fa-clock"></i>
                                            <div class="media-body ml-3">
                                                @php
                                                $carga = $modulo->cargaHoraria();
                                                @endphp
                                                <b>{{ $carga }} {{ Str::plural('hora', $carga) }}</b>
                                            </div>
                                        </div>

                                        @php
                                        $materiais = $modulo->materiais()->get();
                                        @endphp  

                                        @if (count($materiais) > 1)                                      
                                        <div class="media mb-3">
                                            <i class="fa fa-2x fa-fw fa-download"></i>
                                            <div class="media-body ml-3">
                                                @foreach($materiais as $material)
                                                <div>
                                                    <a class="btn btn-sm btn-link" href="{{ route('materiais.download', ['id' => $material->id]) }}">{{$material->titulo}}</a>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>  
                                        @endif                                      

                                        <div class="media mb-4">
                                            <i class="fa fa-2x fa-fw fa-clipboard"></i>
                                            <div class="media-body ml-3">
                                                {!! $modulo->descricao !!}
                                            </div>
                                        </div>

                                        <table class="table table-striped table-sm table-hover">
                                            <tbody>
                                                @forelse ($modulo->aulas as $aula)
                                                    <tr>
                                                        <td class="pl-2">
                                                            @php
                                                            $linkAberto = ($tempoRestanteCurso >=0 && $aula->ordem <=
                                                                intval($ultimaOrdemVisualizada) + 1); @endphp @if ($linkAberto)
                                                                @if ($aula->ordem <= $ultimaOrdemVisualizada)
                                                                    <i class="fa fa-fw fa-check text-success"></i>
                                                                @elseif ($aula->ordem == intval($ultimaOrdemVisualizada) + 1)
                                                                    <i class="fa fa-fw fa-lock-open text-success"></i>
                                                                @endif
                                                                <i class="fa fa-fw fa-video"></i> <a
                                                                    href="{{ route('aula', ['curso' => $curso->id, 'page' => $aula->ordem]) }}">{{ $aula->titulo }}</a>
                                                                <span class="badge badge-secondary">{{ $aula->carga_horaria }}
                                                                    {{ Str::plural('minuto', $aula->carga_horaria) }}</span>
                                                            @else
                                                                @if ($tempoRestanteCurso < 0 && $aula->ordem <= $ultimaOrdemVisualizada)
                                                                    <i class="fa fa-fw fa-check text-success"></i>
                                                                @else
                                                                    <i class="fa fa-fw fa-lock text-danger"></i> <i
                                                                        class="fa fa-video"></i>
                                                                @endif
                                                                {{ $aula->titulo }} <span
                                                                    class="badge badge-secondary">{{ $aula->carga_horaria }}
                                                                    {{ Str::plural('minuto',  $aula->carga_horaria) }}</span> 
                                                                @endif
                                                        </td>
                                                        @if ($linkAberto)
                                                            <td class="text-right">
                                                                @php
                                                                $materiais = $aula->materiais()->get();
                                                                @endphp

                                                                @if (count($materiais) > 1)
                                                                    <a class="btn btn-sm btn-primary"
                                                                        href="{{ route('aula', ['curso' => $curso->id, 'page' => $aula->ordem]) }}"><i
                                                                            class="fas fa-download" aria-hidden="true"></i> <i
                                                                            class="fas fa-ellipsis-h" aria-hidden="true"></i> </a>
                                                                @elseif(count($materiais) == 1)
                                                                    <a class="btn btn-sm btn-primary"
                                                                        href="{{ route('materiais.download', ['id' => $materiais[0]->id]) }}"><i
                                                                            class="fas fa-download" aria-hidden="true"></i></a>
                                                                @endif

                                                            </td>
                                                        @else
                                                            <td class="text-right">&nbsp;</td>
                                                        @endif
                                                    </tr>
                                                @empty
                                                    <p>Nenhuma aula.</p>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>Nenhum módulo.</p>
                        @endforelse


                        <div class="row no-gutters mb-4">
                            <div class="col-md-4 p-3 mb-2 bg-secondary text-white">
                                <h3 class="font-weight-bold">Feedback do curso</h3>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="media mb-3">
                                        <i class="fa fa-2x fa-stack-exchange" aria-hidden="true"></i>
                                        <div class="media-body ml-3">
                                            Ajude-nos a melhorar nossos treinamentos e aulas. O feedback será liberado após a
                                            visualização de todos os vídeos.
                                        </div>
                                    </div>
                                    <table class="table table-striped table-sm table-hover mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="pl-2">
                                                    @if ($percentualConclusao != 100)
                                                        <i class="fa fa-fw fa-lock text-danger" aria-hidden="true"></i>
                                                        <i class="fa fa-clipboard-check" aria-hidden="true"></i> Responder
                                                        feedback
                                                    @else

                                                        @if ($feedbackRespondido)
                                                            <i class="fa fa-fw fa-check text-success"></i>
                                                            <i class="fa fa-clipboard-check" aria-hidden="true"></i>
                                                            Feedback respondido
                                                        @else
                                                            <i class="fa fa-fw fa-lock-open text-success"></i>
                                                            <i class="fa fa-clipboard-check" aria-hidden="true"></i>
                                                            <a href="{{ route('feedback', ['curso' => $curso->id]) }}">Responder
                                                                feedback</a>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                        <div class="row no-gutters mb-4">
                            <div class="col-md-4 p-3 mb-2 bg-success text-white">
                                <h3 class="font-weight-bold">Emitir certificado</h3>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="media mb-3">
                                        <i class="fa fa-2x fa-file-signature" aria-hidden="true"></i>
                                        <div class="media-body ml-3">
                                            O certificado será liberado após a visualização de todos os vídeos e conclusão do
                                            feedback.
                                        </div>
                                    </div>
                                    <table class="table table-striped table-sm table-hover mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="pl-2">
                                                    @if ($feedbackRespondido)
                                                        <i class="fa fa-fw fa-lock-open text-success"></i>
                                                        <i class="fa fa-file" aria-hidden="true"></i>
                                                        <a href="{{ route('certificado.download', ['curso' => $curso->id]) }}">Emitir
                                                            certificado</a>
                                                    @else
                                                        <i class="fa fa-fw fa-lock text-danger" aria-hidden="true"></i>
                                                        <i class="fa fa-file" aria-hidden="true"></i> Emitir certificado
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    @if ($feedbackRespondido)
                                                    <a class="btn btn-sm btn-primary"
                                                        href="{{ route('certificado.download', ['curso' => $curso->id]) }}"><i
                                                            class="fas fa-download" aria-hidden="true"></i></a>
                                                    </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Nenhum curso.</p>
                    @endforelse
                </div>
                @endrole


                <div class="row my-3">
                    
                    @role('Gestor')
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-user"></i>
                                    Você é gestor da plataforma.</h5>
                                <p class="card-text">Olá. Seja bem vindo a plataforma do curso <strong>PROGRAMA CORPORATIVO
                                        GESTANTES E FUTUROS
                                        PAIS</strong>.</p>
                                <p class="card-text">O seu perfil de usuário te possibilita realizar o cadastro dos
                                    colaboradores da sua empresa que terão
                                    acesso ao curso. </p>
                                <p class="card-text">Você pode realizar este cadastro acessando a opção <strong>USUÁRIOS no
                                        menu superior desta
                                        página</strong>. Este cadastro pode ser realizado de forma individualizada ou
                                    através de
                                    importação de uma planilha EXCEL com todos os colaboradores a serem cadastrados no
                                    curso.</p>
                                <p class="card-text">Consulte a equipe da Aldeia Consultoria para obter mais informações
                                    sobre este procedimento.</p>

                            </div>
                        </div>
                    </div>
                    @endrole
                    @role('Admin')
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-users"></i>
                                    Você é administrador da plataforma.</h5>
                                <p class="card-text">Você está logado como administrador da plataforma e possui acesso
                                    irrestrito a todas as
                                    funcionalidades do sistema.</p>
                            </div>
                        </div>
                    </div>
                    @endrole                    
                </div>





            </div>
        </div>
    </div>
@endsection
