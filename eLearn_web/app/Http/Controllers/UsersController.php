<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 

    public function index(Request $request)
    {
        $data = [
            'count_user'    => User::latest()->count(),
            'menu'          => 'menu.v_menu_admin',
            'content'       => 'content.view_user',
            'title'         => 'Tabela Usuários'
        ];

        if ($request->ajax()) {
            $q_user = User::select('*')->where('access_level','!=', 0)->orderByDesc('created_at');
            return Datatables::of($q_user)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = '<div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="btn btn-sm btn-icon btn-outline-success btn-circle mr-2 edit editUser"><i class=" fi-rr-edit"></i></div>';
                        $btn = $btn.' <div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Deletar" class="btn btn-sm btn-icon btn-outline-danger btn-circle mr-2 deleteUser"><i class="fi-rr-trash"></i></div>';
 
                         return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('layouts.v_template',$data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        User::updateOrCreate(['id' => $request->user_id],
                [
                 'name'         => $request->name,
                 'msisdn'       => $request->msisdn,
                 'email'        => $request->email,
                 'access_level' => $request->access_level,
                 'password'     => Hash::make($request->password),
                 //'password'     => $request->password,
                ]);        

        return response()->json(['success'=>'Usuário adicionado com successo!']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $User = User::find($id);
        return response()->json($User);

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        if($id != 1) {
            User::find($id)->delete();
            return response()->json(['successo'=>'Usuário deletado!']);
        } else {
            return response()->json(['negado'=>'Usuário administrador não pode ser deletado!']);
        }
        
    }
}
