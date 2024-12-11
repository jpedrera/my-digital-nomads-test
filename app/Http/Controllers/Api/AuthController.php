<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->respondSuccess(
            ['token' => $user->createToken(config('app.name'))->plainTextToken],
            'User created successfully',
            JsonResponse::HTTP_CREATED
        );
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->firstOrFail();
            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw new ModelNotFoundException();
            }
        } catch (ModelNotFoundException $exception) {
            return $this->respondError('Invalid credentials', [], JsonResponse::HTTP_UNAUTHORIZED);
        } catch (\Exception $exception) {
            return $this->respondInternalError();
        }

        return $this->respondSuccess(
            ['token' => $user->createToken('YourAppName')->plainTextToken],
            'User logged in successfully',
            JsonResponse::HTTP_OK
        );
    }
}
