<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class Login extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/admin');
            }
            
            return redirect()->route('profiles');
        }

        $this->addError('email', 'Email atau password salah.');
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.auth.login');
    }
}
