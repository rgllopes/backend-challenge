<?php
// service-id = qualifica
// app-users-group-id = 20
// host homologação = https://api.staging.mlearn.mobi/
// endpoint store POST = {host}/integrator/{service-id}/users
// endpoint request user GET = {host}/integrator/{service-id}/users
// endpoint edit PUT = {host}/integrator/{service-id}/users/{user-id}
// endpoint upgrade PUT = {host}/integrator/{service-id}/users/{user-id}/upgrade
// endpoint downgrade PUT = {host}/integrator/{service-id}/users/{user-id}/downgrade
// endpoint delete DELETE = {host}/integrator/{service-id}/users/{user-id}

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function index($user) {

        $endPoint = '/integrator/qualifica/users?external_id='.$user;

        $headers = [
            'Authorization'         => 'Bearer', env('TOKEN_MLEARN'),
            'service-id'            => 'qualifica',
            'app-users-group-id'    => '20'
        ];
        
        $response = Http::withHeaders($headers)->get(env('BASE_URI_MLEARN').$endPoint);

        $statusCode = $response->status();
        return response()->json([
            'response'  => $response->getBody(), 
            'status'    => true
        ], $statusCode);
    }

    public function store($lastRecord, $datasUser) {

        $endPoint = '/integrator/qualifica/users';

        $headers = [
            'Authorization'         => 'Bearer', env('TOKEN_MLEARN'),
            'service-id'            => 'qualifica',
            'app-users-group-id'    => '20'
        ];

        $postInput = [
            'msisdn'        => $datasUser->msisdn,
            'name'          => $datasUser->name,
            'access_level'  => $datasUser->access_level,
            'password'      => $datasUser->password,
            'external_id'   => $lastRecord
        ];

        $response = Http::withHeaders($headers)->post(env('BASE_URI_MLEARN').$endPoint, $postInput);

        $statusCode = $response->status();
        return response()->json([
            'response'  => $response->getBody(),
            'status'    => true
        ], $statusCode);
    }

    public function upgrade($user) {
        $endPoint = '/integrator/qualifica/users/'.$user.'/upgrade';

        $headers = [
            'Authorization'         => 'Bearer', env('TOKEN_MLEARN'),
            'service-id'            => 'qualifica',
            'app-users-group-id'    => '20'
        ];
        
        $response = Http::withHeaders($headers)->get(env('BASE_URI_MLEARN').$endPoint);

        $statusCode = $response->status();
        return response()->json([
            'response'  => $response->getBody(), 
            'status'    => true
        ], $statusCode);
    }

    public function downgrade($user) {
        $endPoint = '/integrator/qualifica/users/'.$user.'/downgrade';

        $headers = [
            'Authorization'         => 'Bearer', env('TOKEN_MLEARN'),
            'service-id'            => 'qualifica',
            'app-users-group-id'    => '20'
        ];
        
        $response = Http::withHeaders($headers)->get(env('BASE_URI_MLEARN').$endPoint);

        $statusCode = $response->status();
        return response()->json([
            'response'  => $response->getBody(), 
            'status'    => true
        ], $statusCode);
    }
}
