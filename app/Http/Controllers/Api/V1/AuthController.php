<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Laravel\Sanctum\NewAccessToken;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated()))
            abort(401, __('auth.failed'));

        $user = User::where(
            Fortify::username(),
            $request->validated(Fortify::username())
        )->firstOrFail();

        return $this->getTokenResponse($user);
    }

    public function register(Request $request)
    {
        $user = (new CreateNewUser)->create($request->input());

        return $this->getTokenResponse($user);
    }

    protected function getTokenResponse(User $user)
    {
        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'user_id' => $user->id
        ], Response::HTTP_CREATED);
    }
}