<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

class Subscription extends Component
{
    public $snapToken;

    public function checkout($amount)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $orderId = 'CINE-' . time() . '-' . $user->id . '-' . Str::random(4);

        $serverKey = config('services.midtrans.server_key');
        $isProduction = config('services.midtrans.is_production');
        $url = $isProduction 
            ? 'https://app.midtrans.com/snap/v1/transactions' 
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'callbacks' => [
                'finish' => route('dashboard'),
                'error' => route('subscription'),
                'pending' => route('dashboard'),
            ]
        ];

        try {
            $response = Http::withBasicAuth($serverKey, '')
                ->post($url, $params);

            if ($response->successful()) {
                $this->snapToken = $response->json()['token'];

                // Create pending transaction
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'external_id' => $orderId,
                    'amount' => (int) $amount,
                    'status' => 'pending',
                    'snap_token' => $this->snapToken,
                ]);

                if (!$transaction) {
                    throw new \Exception("Gagal mencatat transaksi ke database.");
                }

                $this->dispatch('show-payment', token: $this->snapToken);
            } else {
                throw new \Exception($response->body());
            }

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function checkStatus()
    {
        if (!Auth::check()) return;

        $transaction = Transaction::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$transaction) {
            session()->flash('error', 'Tidak ada transaksi pending.');
            return;
        }

        $serverKey = config('services.midtrans.server_key');
        $url = config('services.midtrans.is_production')
            ? "https://api.midtrans.com/v2/{$transaction->external_id}/status"
            : "https://api.sandbox.midtrans.com/v2/{$transaction->external_id}/status";

        try {
            $response = Http::withBasicAuth($serverKey, '')->get($url);
            
            if ($response->successful()) {
                $status = $response->json()['transaction_status'];
                
                if (in_array($status, ['capture', 'settlement'])) {
                    $user = Auth::user();
                    $currentVipUntil = ($user->vip_until && $user->vip_until->isFuture()) 
                        ? $user->vip_until 
                        : now();

                    $user->update([
                        'is_vip' => true,
                        'vip_until' => $currentVipUntil->addDays(30)
                    ]);

                    $transaction->update(['status' => 'settlement']);
                    session()->flash('success', 'Selamat! VIP Berhasil diaktifkan secara manual.');
                } else {
                    session()->flash('error', 'Status di Midtrans masih: ' . strtoupper($status));
                }
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal cek status: ' . $e->getMessage());
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.user.subscription');
    }
}
