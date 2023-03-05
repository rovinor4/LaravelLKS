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
        if($request->token && $request->email){
            $token = $request->token;
            $email = $request->email;
            $user = User::where("email",$email)->where("remember_token",$token)->firstOrFail();
            if($user->count() >= 1){
                return $next($request);
            }else{
                return response()->json([
                    'log-out' => true,
                    'status-code' => Response::HTTP_INTERNAL_SERVER_ERROR
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }else{
            return response()->json([
                'log-out' => true,
                'status-code' => "Token and email are not there"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
