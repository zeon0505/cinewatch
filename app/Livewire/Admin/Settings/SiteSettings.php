<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\Movie;

class SiteSettings extends Component
{
    public $site_name = 'CINEWATCH';
    public $site_description = 'Streaming Website Movie';
    public $maintenance_mode = false;
    public $featured_film_ids = [];

    public function mount()
    {
        if (Storage::disk('local')->exists('settings.json')) {
            $settings = json_decode(Storage::disk('local')->get('settings.json'), true);
            $this->site_name = $settings['site_name'] ?? 'CINEWATCH';
            $this->site_description = $settings['site_description'] ?? 'Streaming Website Movie';
            $this->maintenance_mode = $settings['maintenance_mode'] ?? false;
            $this->featured_film_ids = $settings['featured_film_ids'] ?? [];
        }
    }

    public function save()
    {
        $settings = [
            'site_name' => $this->site_name,
            'site_description' => $this->site_description,
            'maintenance_mode' => $this->maintenance_mode,
            'featured_film_ids' => $this->featured_film_ids,
        ];

        Storage::disk('local')->put('settings.json', json_encode($settings, JSON_PRETTY_PRINT));

        session()->flash('message', 'Pengaturan situs berhasil diperbarui.');
    }

    public function render()
    {
        $movies = Movie::orderBy('title')->get();
        return view('livewire.admin.settings.site-settings', [
            'movies' => $movies
        ])->layout('admin.dashboard-layout');
    }
}
