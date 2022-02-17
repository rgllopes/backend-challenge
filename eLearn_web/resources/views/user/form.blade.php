
<h1> {{ $mode }}</h1>

@if(count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ( $errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <label for="Name">Nome</label>
    <input type="text" class="form-control" name='name' 
    value='{{ isset($userDatas->name) ? $userDatas->name : old('name') }}' id='name'>
    <br>
</div>

<div class="form-group">
    <label for="msisdn">Telefone</label>
    <input type="text" class="form-control" name='msisdn' 
    value='{{ isset($userDatas->msisdn) ? $userDatas->msisdn : old('msisdn')}}' id='msisdn'>
    <br>
</div>

<div class="form-group">
    <label for="email">E-mail</label>
    <input type="text" class="form-control" name='email' 
    value='{{ isset($userDatas->email) ? $userDatas->email : old('email') }}' id='email'>
    <br>
</div>

<div class="form-group">
    <label for="access_level">Acesso</label>
    <select type='text' class="form-control" name="access_level" value='' id='access_level'>
        <option></option>
        <option value="pro">pro</option>
        <option value="premium">premium</option>
    </select>
     <br>
</div>

<div class="form-group">
    @if(Request::path() === 'user/create')
    <label for="password">Senha</label>
    <input type="password" class="form-control" name='password' 
    value='{{ isset($userDatas->password) ? $userDatas->password : '' }}' id='password'>
    @endif
    <br>
</div>

<div class="form-group">
    <label for="avatar">Avatar </label>
    @if(isset($userDatas->avatar))
    <img src="{{ asset('storage').'/'.$userDatas->avatar }}" class="img-thumbnil img-fluid" style="border-radius: 50%" width="50" alt="">
    @endif
    <br>
    <input type="file" class="form-control" name="avatar" value='' id="avatar">
</div>
<br>
    <input class="btn btn-success" type="submit" value='{{$mode}}'>

