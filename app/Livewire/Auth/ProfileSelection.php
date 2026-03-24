<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class ProfileSelection extends Component
{
    public $newProfileName = '';
    public $isKids = false;

    public function selectProfile($id)
    {
        $profile = Profile::where('user_id', Auth::id())->findOrFail($id);
        $profile->touch('last_active_at');
        
        session(['active_profile_id' => $profile->id]);
        session(['active_profile_name' => $profile->name]);
        session(['is_kids_mode' => $profile->is_kids]);

        return redirect()->route('home');
    }

    public function addProfile()
    {
        try {
            $this->validate([
                'newProfileName' => 'required|min:2'
            ]);

            $user = Auth::user();
            
            if (!$user) {
                \Illuminate\Support\Facades\Log::error('ProfileSelection: User not found in session');
                return;
            }

            if ($user->profiles()->count() >= 5) {
                session()->flash('error', 'Maksimal 5 profil per akun.');
                return;
            }

            Profile::create([
                'user_id' => $user->id,
                'name' => $this->newProfileName,
                'is_kids' => $this->isKids
            ]);

            $this->newProfileName = '';
            $this->isKids = false;
            $this->dispatch('profile-added');
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('ProfileSelection Error: ' . $e->getMessage());
            $this->addError('newProfileName', 'Gagal membuat profil: ' . $e->getMessage());
        }
    }

    public function deleteProfile($id)
    {
        Profile::where('user_id', Auth::id())->findOrFail($id)->delete();
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        $user = Auth::user();
        $profiles = $user->profiles()->latest('last_active_at')->get();
        return view('livewire.auth.profile-selection', compact('profiles'));
    }
}
