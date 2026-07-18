<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm(Request $request)
    {
        if (Auth::check()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $turnstileError = $this->validateTurnstile($request);
        if ($turnstileError !== true) {
            return redirect()->route('login')->withErrors(['turnstile' => $turnstileError]);
        }

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            $request->session()->forget('url.intended');

            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->route('login')->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ]);
    }

    private function validateTurnstile(Request $request): true|string
    {
        $token = $request->input('cf-turnstile-response');
        $secret = config('services.turnstile.secret_key');

        if (!$token || !$secret) {
            return true;
        }

        $ch = curl_init('https://challenges.cloudflare.com/turnstile/v0/siteverify');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'secret' => $secret,
                'response' => $token,
                'remoteip' => $request->ip(),
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5,
        ]);
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (!($result['success'] ?? false)) {
            return 'Verifikasi keamanan gagal. Silakan refresh halaman dan coba lagi.';
        }

        return true;
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::guard()->logout();
        Auth::shouldUse(config('auth.defaults.guard'));
        Auth::forgetUser();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::flush();

        $response = redirect('/')->with('status', 'Berhasil logout.');

        $cookieNames = [
            'remember_web',
            'remember_web_' . config('auth.defaults.guard'),
        ];

        foreach ($cookieNames as $cookieName) {
            $response->headers->clearCookie($cookieName);
            Cookie::queue(Cookie::forget($cookieName));
        }

        return $response;
    }
}
