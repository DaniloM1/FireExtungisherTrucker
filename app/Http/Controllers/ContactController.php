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
        
        // Promeni ključeve u novi niz, sa 'msg' umesto 'message'
        $mailData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'subject' => $data['subject'],
            'msg' => $data['message'],  // promenjeno ime polja
        ];
        
        Mail::send('emails.contact', $mailData, function($message) use ($mailData) {
            $message->to('danilomilanovic123@gmail.com')
                ->subject('Nova poruka sa sajta: ' . $mailData['subject'])
                ->replyTo($mailData['email'], $mailData['name']);
        });
        

        return redirect()->route('contact')->with('success', 'Vaša poruka je uspešno poslata. Hvala vam!');
    }
}
