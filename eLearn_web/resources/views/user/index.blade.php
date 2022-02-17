@extends('layouts.app')
@section('content')
<div class="container">


@if(Session::has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('message') }}
    </div>
@endif    

<a href="{{ url('user/create') }}" class="btn btn-info">Adicionar usuário</a>
<br>
<br>
    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Acesso</th>
                <th>Avatar</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
                @foreach ( $user as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->msisdn }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->access_level }}</td>
                        <td><img class="img-thumbnil img-fluid" style="border-radius: 50%" src="{{ asset('storage').'/'.$u->avatar }}" width="50" alt=""></td>
                        <td>
                        <a href="{{ url('/user/'.$u->id.'/edit') }}" class="btn btn-warning">Editar</a>            
                        
                        |
                        
                        <form action="{{ url('/user/'.$u->id) }}" class="d-inline" method="post">
                            @csrf
                            {{ method_field('DELETE') }}
                            <input type="submit" class="btn btn-danger" onclick="return confirm('Deseja deletar o registro?')" value="Deletar">
                        </form>
                        
                        </td>
                    </tr>
                @endforeach
            
                <tr>
                    <td scope="row"></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
    </table>
    {{-- { !! $u->links() !! } --}}
</div>
@endsection