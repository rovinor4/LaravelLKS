<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->token) {
            $token = $request->token;
            $user = User::where("remember_token", $token)->first();
            if ($user) {
                return $next($request);
            } else {
                return response()->json([
                    'log-out' => true,
                    'message' => "Invalid token"
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return response()->json([
                'log-out' => true,
                'message' => "Token are not there"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
