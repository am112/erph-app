<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Form;

class LoginForm extends Form
{
    #[Rule('required')]
    public $username = '';
 
    #[Rule('required')]
    public $password = '';

    public $remember = false;

    public function authenticate(){
        $this->validate();
    
        if (!Auth::attempt(['username' => $this->username, 'password' => $this->password], $this->remember)) {
            $this->reset('password');
            $this->addError('username', trans('auth.failed'));
            return;
        }
        
        event(new Login(auth()->guard('web'), User::where('username', $this->username)->first(), $this->remember));
        return redirect()->intended('/dashboard');
    }
}
