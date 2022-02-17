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
        User::insert($datasUser);
        $lastRecord = User::orderBy('id', 'DESC')->first();

        // Verifica se api esta on line
        $result = (new ApiController)->store($lastRecord, $datasUser);
        $statusCodeApi = $result->getStatusCode();

        // Verifica se foi possível registrar usuário na api
        if($statusCodeApi === 200){
            // Redireciona e feed back a front end se registro bem sucedido
            return redirect('user')->with('message', 'Usuário adicionado com éxito!');

        } else {
            // Se api não responde, deleta registro do banco local e informa usuário
            $this->destroyApi($lastRecord);
            return redirect('user')->with('message', 'Usuário não pode ser cadastrado, tente novamente mais tarde!');
        }
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

        // Verifica se ocorreu alteração no nível de acesso
        $userAccessDB = User::findOrFail($user);
        $statusCodeApi = 0;
        if($userAccessDB->access_level != $request->access_level) {
            
            if($request->access_level === 'pro'){
                $result = (new ApiController)->downgrade($userAccessDB->id);
                $statusCodeApi = $result->getStatusCode();
            } else {
                $result = (new ApiController)->upgrade($userAccessDB->id);
                $statusCodeApi = $result->getStatusCode();
            }
        }

        // Verifica se foi possível registrar usuário na api
        if($statusCodeApi === 200) {
            // Atualiza dados de usuário
            User::where('id','=', $user)->update($datasUser);
            $userDatas = User::findOrFail($user);
            
            // Redireciona e feed back a front end se registro bem sucedido
            return redirect('user')->with('message', 'Usuário alterado com éxito!');

        } else {
            // Se api não responde, deleta registro do banco local e informa usuário
            return redirect('user')->with('message', 'Usuário não pode ser alterado, tente novamente mais tarde!');
        }
        
        // Redireciona e feed back a front end
        return redirect('user')->with('message', 'Usuário alterado com éxito!');
    }

    public function destroyApi($lastRecord) {
        // Procura usuário na base de dados e apaga se api estiver off line
        User::findOrFail($lastRecord);
    }

    public function destroy($user)
    {
        
        // Procura usuário na base de dados
        $userDatas = User::findOrFail($user);
        // Verifica se a solicitação de remoção é diferente do administrador
        if($user != 1) {
            // Remove arquivo de foto se existir
            if(Storage::delete('public/'.$userDatas->avatar)) {
                User::destroy($user);
            }
            
            // Deleta usuário
            User::destroy($user);

            // Redireciona e feed back a front end
            return redirect('user')->with('message', 'Usuário removido com éxito!');
        } else {
            // Informa que usuário administrador não pode ser removido
            return redirect('user')->with('message', 'Usuário administrador não pode ser removido!');
        }
        
    }
}
