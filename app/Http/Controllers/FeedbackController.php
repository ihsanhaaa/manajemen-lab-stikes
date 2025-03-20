<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'feedback' => 'required|string|max:500',
        ]);

        // Kirim email ke admin
        Mail::raw($request->feedback, function ($message) {
            $message->to('ih.haryansyah@gmail.com')
                    ->subject('Saran dari Pengguna');
        });

        return response()->json(['message' => 'Terima kasih atas sarannya!']);
    }
}
