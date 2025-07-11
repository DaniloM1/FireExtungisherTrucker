<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('kontakt');
    }

    public function sendMessage(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Slanje maila (podesi po potrebi)
//        Mail::send('emails.contact', $data, function($message) use ($data) {
//            $message->to('info@inzenjertim.com')
//                ->subject('Nova poruka sa sajta: ' . $data['subject'])
//                ->replyTo($data['email'], $data['name']);
//        });

        return redirect()->route('contact')->with('success', 'Vaša poruka je uspešno poslata. Hvala vam!');
    }
}
