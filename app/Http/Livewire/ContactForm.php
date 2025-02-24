<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $subject;
    public $message;

    protected $rules = [
        'name' => 'required|string|max:55',
        'email' => 'required|email|max:150',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ];

    public function submit(): void
    {
        $this->validate();

        $content = [
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ];

        Mail::to(config('app.email_contact'))->queue(new ContactUsMail($content));

        session()->flash('success', 'Your message has been sent successfully.');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.contact-form')->layout('layouts.guest');
    }
}
