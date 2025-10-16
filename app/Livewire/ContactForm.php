<?php

namespace App\Livewire;

use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';

    public string $email = '';

    public string $subject = '';

    public string $message = '';

    public bool $submitted = false;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'subject.required' => 'Please enter a subject for your message.',
            'message.required' => 'Please enter your message.',
            'message.max' => 'Your message must not exceed 2000 characters.',
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        Mail::to(config('mail.contact_address'))->send(
            new ContactMail(
                name: $validated['name'],
                email: $validated['email'],
                contactSubject: $validated['subject'],
                contactMessage: $validated['message'],
            )
        );

        $this->submitted = true;

        $this->reset(['name', 'email', 'subject', 'message']);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
