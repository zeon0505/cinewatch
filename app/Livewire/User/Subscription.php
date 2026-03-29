<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
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
            $response = Http::withoutVerifying()
                ->withBasicAuth($serverKey, '')
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
        if (!Auth::check()) {
            session()->flash('error', 'Silakan Login terlebih dahulu untuk mengecek status.');
            return;
        }

        $transactions = Transaction::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($transactions->isEmpty()) {
            session()->flash('error', 'Tidak ada transaksi pending.');
            return;
        }

        $serverKey = config('services.midtrans.server_key');
        $isProduction = config('services.midtrans.is_production');
        
        $hasCheckedAtLeastOneRealTransaction = false;
        $lastStatusMsg = 'Semua transaksi pending.';

        foreach ($transactions as $transaction) {
            $url = $isProduction
                ? "https://api.midtrans.com/v2/{$transaction->external_id}/status"
                : "https://api.sandbox.midtrans.com/v2/{$transaction->external_id}/status";

            try {
                $response = Http::withoutVerifying()->withBasicAuth($serverKey, '')->get($url);
                $json = $response->json();
                
                if ($response->successful() && isset($json['transaction_status'])) {
                    $status = $json['transaction_status'];
                    $hasCheckedAtLeastOneRealTransaction = true;
                    $lastStatusMsg = 'Status terakhir: ' . strtoupper($status);
                    
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
                        return; // Stop checking once we find a paid one
                    }
                } elseif (isset($json['status_message']) && strpos(strtolower($json['status_message']), 'not exist') !== false) {
                    continue; // Midtrans doesn't know this one yet, try next
                } else {
                    $msg = isset($json['status_message']) ? $json['status_message'] : 'Respons tidak valid dari Midtrans';
                    $lastStatusMsg = "Gagal (Midtrans): " . $msg;
                }
            } catch (\Exception $e) {
                // Ignore exception and continue checking others
                $lastStatusMsg = 'Error: ' . $e->getMessage();
            }
        }
        
        session()->flash('error', $hasCheckedAtLeastOneRealTransaction ? $lastStatusMsg : "Belum ada pembayaran yang selesai di Midtrans.");
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        if (Auth::check()) {
            Log::info('VIP_PAGE_ACCESS', [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'is_vip' => Auth::user()->is_vip,
                'vip_until' => Auth::user()->vip_until,
                'session_profile' => session('active_profile_name')
            ]);
        }
        return view('livewire.user.subscription');
    }
}
