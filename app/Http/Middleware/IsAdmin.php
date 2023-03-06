<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->token){
            $token = $request->token;
            $user = User::where("remember_token",$token)->where("is_admin",true)->first();
            if($user){
                return $next($request);
            }else{
                return response()->json([
                'log-out' => true,
                'message' => "Only admin can access"
            ], Response::HTTP_FORBIDDEN);
            }
        }else{
              return response()->json([
                'log-out' => true,
                'message' => "Only admin can access"
            ], Response::HTTP_FORBIDDEN);
        }

    }
}
