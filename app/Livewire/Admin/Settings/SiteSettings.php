<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;

class SiteSettings extends Component
{
    public $site_name = 'CINEWATCH';
    public $site_description = 'Streaming Website Movie';
    public $maintenance_mode = false;

    public function save()
    {
        session()->flash('message', 'Pengaturan situs berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.settings.site-settings')
            ->layout('admin.dashboard-layout');
    }
}
