<?php

    namespace App\Http\Controllers\Api\V1;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class AuthController extends Controller
    {

        public function login(Request $request): \Illuminate\Http\JsonResponse
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            $user = User::where('email', $request->email)->firstOrFail();

            $tokenResult = $user->createToken($request->userAgent());
            $token = $tokenResult->accessToken;
            $token->expires_at = now()->addDays(30);
            $token->save();

            return response()->json([
                'token' => $tokenResult->plainTextToken,
                'user' => $user,
            ]);
        }

        public function logout(Request $request)
        {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Logged out']);
        }

        // USER AUTH
        public function me(Request $request)
        {
            return response()->json($request->user());
        }


    }
