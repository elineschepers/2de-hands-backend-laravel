<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        // User must have verified their email address
        if (!$request->user()->hasVerifiedEmail()) {
            auth()->logout();

            return response()->json([
                'message' => __('auth.verify_email'),
            ], 403);
        }

        // User must not have been banned
        if ($request->user()->isBanned()) {
            auth()->logout();

            return response()->json([
                'message' => __('auth.banned'),
            ], 403);
        }

        $request->session()->regenerate();

        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
