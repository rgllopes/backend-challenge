@extends('layouts.app')
@section('content')
<div class="container">

    <form action="{{ url('/user/'.$userDatas->id ) }}" method="post" enctype="multipart/form-data">

        @csrf
        {{ method_field('PUT') }}

        @include('user.form',['mode'=>'Editar'])

    </form>
</div>
@endsection
