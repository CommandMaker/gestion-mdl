<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        /** @var User $user */
        $user = User::findOrFail($data['id']);

        if (!$user->is_loggable) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not allowed to log in with this account',
            ], 403);
        }

        if ($user->password !== $data['code']) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 403);
        }

        Auth::login($user);

        return response()->json([
            'status' => 'ok',
        ]);
    }
}
