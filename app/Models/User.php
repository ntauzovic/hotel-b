<?php

namespace App\Models;

// HasFactory — omogućava kreiranje test podataka putem Factories (npr. UserFactory)
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Authenticatable — bazna klasa koja Useru daje sve što treba za login (provjera passworda, sesije itd.)
use Illuminate\Foundation\Auth\User as Authenticatable;

// Notifiable — omogućava slanje notifikacija useru (email, SMS, push) — Laravel built-in
use Illuminate\Notifications\Notifiable;

// HasApiTokens — dolazi iz Sanctum paketa, daje useru mogućnost da kreira/briše API tokene
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // Spajamo sve traits:
    // HasFactory     — za seedere i testove
    // Notifiable     — za notifikacije
    // HasApiTokens   — NOVO: bez ovoga Sanctum ne bi mogao kreirati tokene za ovog usera
    use HasFactory, Notifiable, HasApiTokens;

    // $fillable — lista polja koja se smiju mass-assign (npr. User::create([...]))
    // Bez ovoga Laravel blokira masovno upisivanje zbog sigurnosti
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id', // NOVO: Google OAuth ID — jedinstveni ID koji Google vraća za svakog korisnika
        'avatar',    // NOVO: URL profilne slike, Google je šalje automatski pri OAuth loginu
    ];

    // $hidden — ova polja se NIKAD ne vraćaju u JSON responsu (npr. GET /auth/me)
    // password i remember_token ne smiju nikad biti vidljivi klijentu
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // casts — govori Laravelu kako da tretira određena polja pri čitanju/pisanju
    protected function casts(): array
    {
        return [
            // email_verified_at se čuva kao string u bazi, a čita kao Carbon datetime objekat
            'email_verified_at' => 'datetime',

            // password se automatski hashuje kada se upiše (bcrypt) — nikad ne čuvaš plain text
            'password' => 'hashed',
        ];
    }
}
