@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <div class="titulo-destaque">
                    <i class="fa fa-stack-exchange" aria-hidden="true"></i> Feedback
                </div>
            </div>           
            <hr />
            <div class="row">
                <div class="col-12 col-md-8 col-sm-12">
                    <h1>{{ $curso->nome }}</h1>
                </div>
                <div class="col-12 col-md-4 col-sm-12 text-right">
                    <a href="{{ route('home') }}" class="btn btn-success"><i class="fas fa-chevron-left"></i> Voltar</a>
                    <button type="button" class="btn btn-danger"><i class="fa fa-users"></i> Fórum de discussão</button>
                </div>
            </div>
            <div>
                <div class="row mt-3">
                    <div class="col">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <p><strong>Whoops!</strong> Não foi possível prosseguir.</p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                {{ Form::open(['route' => ['feedback.store', $curso->id], 'id' => 'registrar-form']) }}
                @forelse ($perguntas as $pergunta)
                    @php
                    $respostas = $pergunta->respostas()->get();
                    @endphp
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-left">
                                <h3>{{ $pergunta->pergunta }}</h3>
                            </div>
                            <div>

                                <div class="pb-5 pt-3">
                                    @foreach ($respostas as $resposta)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="pergunta_id_{{ $pergunta->id }}"
                                                id="resposta_id_{{ $resposta->id }}" 
                                                {{ old('pergunta_id_'. $pergunta->id) == $resposta->id ? 'checked' : ''}}
                                                value="{{ $resposta->id }}">
                                            <label class="form-check-label" for="resposta_id_{{ $resposta->id }}">
                                                {{ $resposta->ordem }}) {{ $resposta->resposta }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @empty


                @endforelse

                @if (count($perguntas) > 0)
                <div class="row form-group">
                    <div class="col-sm-12 col-lg-4 col-xl-3 align-self-center">
                        {{ Form::submit('Responder', ['class' => 'btn btn-primary', 'id' => 'btn-responder']) }}
                    </div>
                </div>
                @endif
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection