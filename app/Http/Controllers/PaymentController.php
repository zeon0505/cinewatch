<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;

class PaymentController extends Controller
{
    public function webhook(Request $request)
    {
        $data = $request->all();

        try {
            $orderId = $data['order_id'] ?? null;
            $transactionStatus = $data['transaction_status'] ?? null;
            $type = $data['payment_type'] ?? null;
            $fraud = $data['fraud_status'] ?? null;

            if (!$orderId) {
                return response()->json(['message' => 'Invalid data'], 400);
            }

            $dbTransaction = Transaction::where('external_id', $orderId)->first();

            if (!$dbTransaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Simple Security: Verify signature_key (optional but recommended)
            // $signature = hash('sha512', $orderId . $data['status_code'] . $data['gross_amount'] . env('MIDTRANS_SERVER_KEY'));
            // if($signature !== $data['signature_key']) ...

            if ($transactionStatus == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $dbTransaction->update(['status' => 'challenge']);
                    } else {
                        $this->setVip($dbTransaction);
                    }
                }
            } else if ($transactionStatus == 'settlement') {
                $this->setVip($dbTransaction);
            } else if ($transactionStatus == 'pending') {
                $dbTransaction->update(['status' => 'pending']);
            } else if ($transactionStatus == 'deny') {
                $dbTransaction->update(['status' => 'denied']);
            } else if ($transactionStatus == 'expire') {
                $dbTransaction->update(['status' => 'expired']);
            } else if ($transactionStatus == 'cancel') {
                $dbTransaction->update(['status' => 'cancelled']);
            }

            return response()->json(['message' => 'OK']);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    private function setVip($transaction)
    {
        $transaction->update(['status' => 'settlement']);
        
        $user = User::find($transaction->user_id);
        if ($user) {
            $user->update([
                'is_vip' => true,
                'vip_until' => now()->addDays(30)
            ]);
        }
    }
}
