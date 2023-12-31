<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserStateController extends Controller
{
	public function login(UserLoginRequest $request): JsonResponse
	{
		$data = $request->validated();

		$login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

		if ($login_type === 'email') {
			$user = User::firstWhere('email', $data['login']);
		} elseif ($login_type === 'name') {
			$user = User::firstWhere('name', $data['login']);
		}

		if (!isset($user)) {
			return response()->json(['message' => 'Username or Password is incorrect.'], 401);
		}

		if ($user->email_verified_at === null) {
			$user->sendEmailVerificationMail();

			return response()->json(['message' => 'Email is not verified. New verification Email was sent.'], 401);
		}

		if (auth()->validate(['id' => $user->id, 'password' => ($data['password'])])) {
			Auth::loginUsingId($user->id, $request->remember);

			request()->session()->regenerate();

			return response()->json(['user' => auth()->user()], 201);
		}

		return response()->json(['message' => 'Username or Password is incorrect.'], 401);
	}

	public function logout(): JsonResponse
	{
		auth()->guard('web')->logout();
		request()->session()->invalidate();
		request()->session()->regenerateToken();

		return response()->json(['message' => 'User logged out successfully'], 201);
	}

	public function userInfo(): JsonResponse
	{
		return response()->json(auth()->user(), 201);
	}
}
