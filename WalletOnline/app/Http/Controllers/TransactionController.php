<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    //

    public function sendArgent(Request $request)
    {
        $sender = User::where('email', $request->sender)->first();
        $recever = User::where('email', $request->recever)->first();

        if (!$sender) {
            return response()->json([
                'error' => 'sender not found'
            ]);
        }
        if (!$recever) {
            return response()->json([
                'error' => 'recever not found'
            ]);
        }

        $senderWallet = $sender->wallet;
        $receverWallet = $recever->wallet;

        if ($senderWallet->argent < $request->montant) {
            return response()->json([
                'error' => 'ma3andekch dak montant'
            ]);
        }

        DB::beginTransaction();
        try {
            $senderWallet->argent -= $request->montant;
            $senderWallet->save();

            $receverWallet->argent += $request->montant;
            $receverWallet->save();

            $transaction = Transaction::create([
                'sender_id' => $sender->id,
                'recever_id' => $recever->id,
                'montant' => $request->montant,
                'status' => 'completed',
                'date' => now(),
            ]);

            DB::commit();
            return response()->json([
                'saved transaction ' => ' transaction completed ',
                'transaction' => $transaction
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'transaction failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
