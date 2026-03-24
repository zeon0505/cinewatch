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

        $serverKey = env('MIDTRANS_SERVER_KEY');
        $isProduction = env('MIDTRANS_IS_PRODUCTION', false);
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
                Transaction::create([
                    'user_id' => $user->id,
                    'external_id' => $orderId,
                    'amount' => $amount,
                    'status' => 'pending',
                    'snap_token' => $this->snapToken,
                ]);

                $this->dispatch('show-payment', token: $this->snapToken);
            } else {
                throw new \Exception($response->body());
            }

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.user.subscription');
    }
}
