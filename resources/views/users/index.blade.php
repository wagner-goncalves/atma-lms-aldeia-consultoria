@extends('layouts.app')


@section('content')

<div class="row">
  <div class="col-lg-12 margin-tb">
      <div class="pull-left pb-3">
          <div class="titulo-destaque">
              <i class="fas fa-users"></i> Gerenciar usuários do sistema
          </div>
      </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12 mb-3">
      <div class="row">
          <div class="col-lg-6 col-sm-12">
              <div class="form-group">
                  <a href="{{ route('users.create') }}" class="btn btn-success rounded-pill pr-4 pl-4 text-dark font-weight-bold text-uppercase">Criar usuário</a>
              </div>  
          </div>

          <div class="col-lg-6 col-sm-12">

            <form class="form-inline" method="GET" action="{{\Request::getRequestUri()}}">
              <div class="form-group mb-2">
                <input type="text" class="form-control form-control-sm" id="filter" name="filter" placeholder="Nome" value="{{$filter}}">
              </div>
              <button type="submit" class="btn btn-sm btn-link mb-2">Filtrar</button>
            </form>                         

          </div>

      </div>

      @if ($message = Session::get('success'))
      <div class="alert alert-success" role="alert">
        <i class="fas fa-exclamation-circle fa-lg"></i> {{ $message }}
      </div>
      @endif


      <table class="table table-bordered">
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Papéis</th>
          <th width="280px">Ações</th>
        </tr>
      @foreach ($data as $key => $user)
        <tr>
          <td>{{ ++$i }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>
            @if(!empty($user->getRoleNames()))
              @foreach($user->getRoleNames() as $v)
                <label class="badge badge-success">{{ $v }}</label>
              @endforeach
            @endif
          </td>
          <td>
            <a class="btn btn-sm btn-primary" href="{{ route('users.edit',$user->id) }}"><i class="fas fa-edit"></i></a>
              {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                  <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
              {!! Form::close() !!}
          </td>
        </tr>
      @endforeach
      </table>


    </div>
  </div>

<div class="row">
  <div class="col-lg-12 mb-3">        
      {!! $data->appends(request()->query())->links() !!}    
  </div>
</div> 

@endsection