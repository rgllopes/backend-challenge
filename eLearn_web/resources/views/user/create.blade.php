@extends('layouts.app')
@section('content')
<div class="container">

    <form action="{{ url('/user') }}" method="post" enctype="multipart/form-data">

        @csrf
        
        @include('user.form', ['mode'=>'Adicionar'])

    </form>
</div>
@endsection