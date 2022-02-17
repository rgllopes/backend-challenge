<?php

// Developer: Reginaldo Lopes
// Data de implantação: 16/02/2022
// Todos comentarios em portugues para melhor avaliação
// Utilizado validators nas próprias funções de store e update por não se tratar de uma validação muito extensa
// Comentado require de avatar por não ser item obrigatório de projeto
// **Para guardar a foto necessario rodar o comando: php artisan storage:link**

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $datas['user'] = User::all();
        return view('user.index', $datas);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        // Validação de campos do formulário
        $fields =[
            'name'          => 'required|string|min:5',
            'msisdn'        => 'required|string|unique:users,msisdn',
            'email'         => 'required|email|unique:users,email',
            'access_level'  => 'required',
            'avatar'        => 'max:10000|mimes:jpeg,png,jpg',
            'password'      => 'required|min:5'
            
        ];
        // Mensagens de feed back ao usuário em caso de falha de validação
        $message=[
            'name.required'         => 'O nome é obrigatório.',
            'name.min'              => 'O nome deve conter ao menos :min caracteres.',
            'access_level.required' => 'Necessário escolher um tipo de acesso.',
            'msisdn.required'       => 'O telefone é obrigatório.',
            'msisdn.unique'         => 'Este número de telefone já esta cadastrado.',
            'email.required'        => 'o email é obrigatório.',
            'email.unique'          => 'Email ja cadastrado.',
            'email'                 => 'O email deve conter um endereço válido.',
            'avatar.max'            => 'O tamanho do arquivo não pode ser superior a 10MB.',
            'password.required'     => 'A senha não pode estar vazia.',
            'password.min'          => 'A senha deve ter no mínimo :min caracteres.',
            'mimes'                 => 'Sua foto deve ter o formato :mimes.'
            //'avatar.required'    => 'A foto é obrigatória',
        ];

        // Verifica validação e mensagens de erro
        $this->validate($request, $fields, $message);

        // Elimina dado de @csrf do front
        $datasUser = request()->except('_token');

        // Verifica se existe arquivo de foto para store
        if($request->hasFile('avatar')) {
            $datasUser['avatar']=$request->file('avatar')->store('uploads', 'public');
        }

        // Insere usuários na base de dados
        $userSaved = User::insert($datasUser);
        dd($datasUser);

        // Redireciona e feed back a front end
        return redirect('user')->with('message', 'Usuário adicionado com éxito!');
    }

    public function show(UserController $user)
    {
        //
    }

    public function edit($user)
    {
        // Envia dados de usuário para o front para edição
        $userDatas = User::findOrFail($user);
        return view('user.edit', compact('userDatas'));
    }

    public function update(Request $request, $user)
    {
        // Validação do dados do front
        $fields =[
            'name'          => 'required|string|min:5',
            'msisdn'        => 'required|string',
            'email'         => 'required|email|',
            'access_level'  => 'required',
            'avatar'        => 'max:10000|mimes:jpeg,png,jpg',
            
        ];
        // Mensagens de feed back ao usuário em caso de falha de validação
        $message=[
            'name.required'         => 'O nome é obrigatório',
            'access_level.required' => 'Necessário escolher um tipo de acesso',
            'msisdn.required'       => 'O telefone é obrigatório',
            'email.required'        => 'o email é obrigatório',
            'email'                 => 'O email deve conter um endereço válido',
            //'avatar.required'    => 'A foto é obrigatória',
            'max'                   => 'O tamanho do arquivo não pode ser superior a 10MB',
            'min'                   => 'O nome deve conter ao menos :min caracteres',
            'mimes'                 => 'Sua foto deve ter o formato :mimes'
        ];

        // Verifica validação e mensagens de erro
        $this->validate($request, $fields, $message);

        // Elimina dados de @csrf e método do front
        $datasUser = request()->except(['_token', '_method']);

        // Tratamento do dado de foto recebida
        if($request->hasFile('avatar')) {
            $userDatas = User::findOrFail($user);
            //Deletar foto antiga antes de adicionar a nova
            Storage::delete('public/'.$userDatas->avatar);
            $datasUser['avatar']=$request->file('avatar')->store('uploads', 'public');
        }

        // Atualiza dados de usuário
        User::where('id','=', $user)->update($datasUser);
        $userDatas = User::findOrFail($user);
        
        // Redireciona e feed back a front end
        return redirect('user')->with('message', 'Usuário alterado com éxito!');
    }

    public function destroy($user)
    {
        // Procura usuário na base de dados
        $userDatas = User::findOrFail($user);
        
        // Remove arquivo de foto se existir
        if(Storage::delete('public/'.$userDatas->avatar)) {
             User::destroy($user);
        }

        // Redireciona e feed back a front end
        return redirect('user')->with('message', 'Usuário removido com éxito!');
    }
}
