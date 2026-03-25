<?php

namespace App\Http\Controllers;

// User model — trebamo ga da kreiramo/tražimo usera u bazi
use App\Models\User;

// Request — objekat koji sadrži sve što je klijent poslao (body, headers, params)
use Illuminate\Http\Request;

// Auth facade — Laravel-ov sistem za autentifikaciju, koristimo ga za provjeru kredencijala
use Illuminate\Support\Facades\Auth;

// Hash facade — hashuje password prije snimanja u bazu (bcrypt), nikad ne čuvaš plain text
use Illuminate\Support\Facades\Hash;

// ValidationException — bacamo ovu grešku kada login ne prođe, Laravel je automatski pretvara u 422 JSON response
use Illuminate\Validation\ValidationException;

// Socialite — paket za Google OAuth, upravlja cijelim OAuth flowom umjesto nas
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // ─── Registracija (email + password) ─────────────────────────────────────

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return response()->json($user, 201);
    }

    // ─── Login (email + password) ─────────────────────────────────────────────

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $request->session()->regenerate();

        return response()->json(Auth::user());
    }

    // ─── Logout ───────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    // ─── Trenutni ulogovani user ──────────────────────────────────────────────

    public function me(Request $request)
    {
        // $request->user() — Sanctum automatski dohvati usera iz tokena koji je stigao u headeru
        // Frontend poziva ovu rutu da provjeri je li token još validan i da dohvati podatke o useru
        return response()->json($request->user());
    }

    // ─── Google OAuth — Korak 1: Redirect na Google ───────────────────────────

    public function redirectToGoogle()
    {
        // stateless() — ne koristimo sesije (mi smo API, ne web app)
        // redirect() — Socialite gradi Google OAuth URL i preusmjeri browser korisnika na Google
        // Google će prikazati "Odaberi Google account" ekran
        return Socialite::driver('google')->stateless()->redirect();
    }

    // ─── Google OAuth — Korak 2: Google nas preusmjeri nazad ─────────────────

    public function handleGoogleCallback()
    {
        try {
            // Google je vratio "code" u URL parametru, Socialite ga razmijeni za user podatke
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            // Ako nešto pođe po krivu (user kliknuo Cancel, istekao token...)
            // preusmjeri na login stranicu sa greškom
            return redirect(env('FRONTEND_URL', 'http://localhost:3000') . '/login?error=google_failed');
        }

        // updateOrCreate — traži usera po google_id:
        // - ako postoji → ažuriraj ime, email, avatar
        // - ako ne postoji → kreiraj novog usera sa tim podacima
        // Ovo rješava i prvi login i svaki sljedeći login istog Google accounta
        $user = User::updateOrCreate(
            ['google_id' => $googleUser->getId()],   // uvjet pretrage
            [
                'name'   => $googleUser->getName(),   // ime sa Google profila
                'email'  => $googleUser->getEmail(),  // email sa Google profila
                'avatar' => $googleUser->getAvatar(), // profilna slika sa Google profila
            ]
        );

        Auth::login($user);

        request()->session()->regenerate();

        return redirect(env('FRONTEND_URL', 'http://localhost:3000') . '/auth/callback');
    }
}
