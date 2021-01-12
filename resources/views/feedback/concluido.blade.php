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
                        
                        <a href="{{ route('posts.show', ['post' => $curso->id]) }}" class="btn btn-danger pull-right"><i class="fa fa-users"></i> Fórum de discussão</a>
                    </div>
                </div>            
            <div>
                <div class="row mt-3">
                    <div class="col">
                        <h4>Obrigado por participar do nosso curso.</h4>
                        <p>Esperamos ter contribuído com o nosso propósito de apoiar famílias a vivenciarem a parentalidade pró ativa, promovendo o vínculo, a segurança e o respeito mútuo.</p>
                        <a class="btn btn-success" href="{{ route('certificado.download', ['curso' => $curso->id]) }}"><i class="fa fa-file" aria-hidden="true"></i>  CLIQUE PARA REALIZAR O DOWNLOAD DO SEU CERTIFICADO</a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection