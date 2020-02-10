<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Auth, DB, Route, Session, Hash};
use App\User;

class AuthController extends Controller
{
    
    private $client;

    public function __construct()
    {
        $this->client = DB::table('oauth_clients')->where('id', 2)->first();
    }

    protected function guard()
    {
        return Auth::guard('api');
    }

    public function login(Request $request)
    {
        // Add request parameters
        $request->request->add([
            'username'      => $request->username,
            'password'      => $request->password,
            'grant_type'    => 'password',
            'client_id'     => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope'         => '*'
        ]);

        $user = User::where('username', $request->username)->first();
        if($user) {
            if(!Hash::check($request->password, $user->password)) {
                $user = null;
            }
        }
        
        $getToken = Request::create('oauth/token', 'POST');

        $response = Route::dispatch($getToken);

        $responseJson = (object) json_decode($response->getContent());
        $responseJson->user_type = isset($user) ? $user->type : null;
        return response()->json($responseJson);

    }

    public function logout(Request $request) {
        if (!$this->guard()->check()) :
            return response(['message' => 'No active user session was found'], 404);
        endif;

        $request->user('api')->token()->delete();

        Session::flush();

        Session::regenerate();

        return response(['message' => 'User was logged out']);
    }

    public function refresh(Request $request)
    {
        // Add request parameters
        $request->request->add([
            'grant_type'    => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id'     => $this->client->id,
            'client_secret' => $this->client->secret
        ]);

        // Create request to refresh token
        $refreshToken = Request::create('oauth/token', 'POST');

        return Route::dispatch($refreshToken);
    }
}
