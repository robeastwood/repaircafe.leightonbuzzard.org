<?php

declare(strict_types=1);

use App\Livewire\ContactForm;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

test('contact form can be rendered', function () {
    $response = $this->get('/contact');

    $response->assertSuccessful();
    $response->assertSeeLivewire(ContactForm::class);
});

test('contact form submits successfully with valid data', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message.')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('submitted', true)
        ->assertSet('name', '')
        ->assertSet('email', '')
        ->assertSet('subject', '')
        ->assertSet('message', '');

    Mail::assertSent(ContactMail::class, function ($mail) {
        return $mail->hasTo(config('mail.contact_address'))
            && $mail->name === 'John Doe'
            && $mail->email === 'john@example.com'
            && $mail->contactSubject === 'Test Subject'
            && $mail->contactMessage === 'This is a test message.';
    });
});

test('contact form requires name field', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message.')
        ->call('submit')
        ->assertHasErrors(['name' => 'required'])
        ->assertSet('submitted', false);

    Mail::assertNothingSent();
});

test('contact form requires email field', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message.')
        ->call('submit')
        ->assertHasErrors(['email' => 'required'])
        ->assertSet('submitted', false);

    Mail::assertNothingSent();
});

test('contact form requires valid email format', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'not-an-email')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message.')
        ->call('submit')
        ->assertHasErrors(['email' => 'email'])
        ->assertSet('submitted', false);

    Mail::assertNothingSent();
});

test('contact form requires subject field', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('message', 'This is a test message.')
        ->call('submit')
        ->assertHasErrors(['subject' => 'required'])
        ->assertSet('submitted', false);

    Mail::assertNothingSent();
});

test('contact form requires message field', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->call('submit')
        ->assertHasErrors(['message' => 'required'])
        ->assertSet('submitted', false);

    Mail::assertNothingSent();
});

test('contact form validates name max length', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', str_repeat('a', 256))
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message.')
        ->call('submit')
        ->assertHasErrors(['name' => 'max'])
        ->assertSet('submitted', false);

    Mail::assertNothingSent();
});

test('contact form validates email max length', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', str_repeat('a', 245).'@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message.')
        ->call('submit')
        ->assertHasErrors(['email' => 'max'])
        ->assertSet('submitted', false);

    Mail::assertNothingSent();
});

test('contact form validates subject max length', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', str_repeat('a', 256))
        ->set('message', 'This is a test message.')
        ->call('submit')
        ->assertHasErrors(['subject' => 'max'])
        ->assertSet('submitted', false);

    Mail::assertNothingSent();
});

test('contact form validates message max length', function () {
    Mail::fake();

    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', str_repeat('a', 2001))
        ->call('submit')
        ->assertHasErrors(['message' => 'max'])
        ->assertSet('submitted', false);

    Mail::assertNothingSent();
});

test('contact email renders correctly', function () {
    $mailable = new ContactMail(
        name: 'John Doe',
        email: 'john@example.com',
        contactSubject: 'Test Subject',
        contactMessage: 'This is a test message.',
    );

    $mailable->assertSeeInHtml('John Doe');
    $mailable->assertSeeInHtml('john@example.com');
    $mailable->assertSeeInHtml('Test Subject');
    $mailable->assertSeeInHtml('This is a test message.');
    $mailable->assertSeeInHtml('New Contact Form Submission');
});
