<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionTokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json([
                'status' => 'unauthorized',
                'message' => 'Invalid Token',
            ], 401);
        }

        $user = User::where('subscription_token', $token)->first();

        if (!$user) {
            return response()->json([
                'status' => 'unauthorized',
                'message' => 'Invalid Token.',
            ], 401);
        }

        $request->merge(['authenticated_user' => $user]);
        return $next($request);
    }
}
