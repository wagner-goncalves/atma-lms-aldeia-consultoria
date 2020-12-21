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
            <div>
                <div class="row">
                    <div class="col-12 col-md-9 col-sm-12">
                        <h1>{{$curso->nome}}</h1>
                    </div>
                </div>
                <hr />

                <div class="row mt-3">
                    <div class="col">
                        Agradecemos o seu feedback!
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection