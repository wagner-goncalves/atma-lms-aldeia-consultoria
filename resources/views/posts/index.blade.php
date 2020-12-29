@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">

                <div class="titulo-destaque">
                    <i class="fas fa-users"></i>
                    Fórum de discussão
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
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">
                        <h3>Postagens</h3>
                    </div>
                </div>

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <p><strong>Whoops!</strong> Temos alguns problemas.</p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($message = Session::get('success'))
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-exclamation-circle fa-lg"></i> {{ $message }}
                    </div>
                @endif

                <div class="row">
                    <div class="col-12 col-md-8 col-sm-12 mb-3">
                        <div class="mt-100">
                            <script>
                                $(document).ready(function() {
                                    $(document).on('click', ".reply-button", function() {
                                        var post_id = $(this).data('post_id');
                                        var possuiTextArea = $("#reply-post-" + post_id + " textarea")
                                            .length > 0;

                                        if (!possuiTextArea) {
                                            $("#reply-post-" + post_id).html("");
                                            $("#reply-post-" + post_id).append(
                                                '<textarea placeholder="Seu texto..." cols="50" rows="5" class="form-control mb-2" name="reply-textbox-' +
                                                post_id + '" id="reply-textbox-' + post_id +
                                                '"></textarea>');
                                            $("#reply-textbox-" + post_id).focus();
                                        } else {
                                            $("#reply-post").val($("#reply-textbox-" + post_id).val());
                                            $("#reply-post_id").val(post_id);
                                            $("#reply-form").submit();
                                        }

                                    });
                                });

                            </script>

                            {!! Form::open(['route' => ['posts.store', ['curso_id' => $curso->id]], 'method' => 'POST', 'id'
                            => 'reply-form']) !!}
                            {{ Form::hidden('post', '', ['id' => 'reply-post']) }}
                            {{ Form::hidden('post_id', '', ['id' => 'reply-post_id']) }}
                            {!! Form::close() !!}

                            @forelse ($posts as $post)

                                <div class="card mb-4">
                                    <div class="card-header">
                                        <div class="media flex-wrap w-100 align-items-center">
                                            <!--<img
                                                                        src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1574583246/AAA/2.jpg"
                                                                        class="d-block ui-w-40 rounded-circle" alt=""> -->
                                            <div class="media-body">
                                                <strong>{{ $post->user->name }}</strong>
                                                <div class="text-muted small">
                                                    {{ \Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans() }}
                                                </div>
                                            </div>
                                            <div class="text-muted small ml-3">
                                                <div>Matriculado em
                                                    <strong>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($post->user->created_at))->format('d/m/Y') }}</strong>
                                                </div>
                                                <div><strong>{{ $post->user->countPosts() }}</strong> postagens</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p> {!! $post->post !!} </p>

                                        @php
                                        $postsFilhos = $post->filhos()->orderBy("id", "desc");
                                        @endphp

                                        @foreach ($postsFilhos->get() as $postFilho)
                                            <div class="card mb-4 small">
                                                <div class="card-header p-2">
                                                    Respondido por: <strong>{{ $postFilho->user->name }}</strong>
                                                    <div class="text-muted small">
                                                        {{ \Carbon\Carbon::createFromTimeStamp(strtotime($postFilho->created_at))->diffForHumans() }}
                                                    </div>
                                                </div>
                                                    <div class="card-body p-2">
                                                        {{ $postFilho->post }}
                                                    </div>
                                                
                                            </div>
                                        @endforeach


                                        <div id="reply-post-{{ $post->id }}"></div>
                                        <button type="button" class="btn btn-primary btn-sm reply-button"
                                            data-post_id="{{ $post->id }}"><i class="fa fa-reply"></i>&nbsp; Responder</button>
                                        @role('Admin|Gestor')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['posts.destroy', $post->id], 'style'
                                        => 'display:inline']) !!}
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fas fa-trash"></i></button>
                                        {!! Form::close() !!}
                                        @endrole
                                    </div>
                                </div>




                            @empty
                                <div class="row mt-3">
                                    <div class="col">

                                        <div class="alert alert-danger" role="alert">
                                            Nenhuma mensagem postada para o curso.
                                        </div>

                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>


                    <div class="col-12 col-md-4 col-sm-12 mb-3">
                        <div class="card" style="width: 100%">
                            <div class="list-group">
                                <span class="list-group-item list-group-item-action flex-column align-items-start active">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Postar no fórum do curso</h5>
                                    </div>
                                </span>

                                {!! Form::open(['route' => ['posts.store', ['curso_id' => $curso->id]], 'method' => 'POST',
                                'enctype' => 'multipart/form-data', 'id' => 'edit-form']) !!}
                                <div class="card-body">
                                    <div class="form-group">
                                        {!! Form::textarea('post', null, ['placeholder' => 'Seu texto', 'class' =>
                                        'form-control', 'id' => 'descricao']) !!}
                                    </div>
                                    <div>
                                        <button type="submit"
                                            class="btn btn-success pr-4 pl-4 text-dark font-weight-bold text-uppercase">Postar</button>
                                    </div>
                                </div>
                                {!! Form::close() !!}

                            </div>
                        </div>
                    </div>



                </div>




                @if ($posts)
                    <div class="row mt-3">
                        <div class="col-lg-12 mb-3 text-right">
                            {!! $posts->appends(request()->query())->links() !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
