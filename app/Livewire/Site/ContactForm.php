<?php

namespace App\Livewire\Site;

use App\Models\Message;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{
    #[Validate('required|string|max:100')]
    public string $name = '';

    #[Validate('required|email|max:150')]
    public string $email = '';

    #[Validate('required|string|max:200')]
    public string $subject = '';

    #[Validate('required|string|min:10|max:2000')]
    public string $body = '';

    public bool $sent = false;

    public function send(): void
    {
        $this->validate();

        Message::create([
            'name'    => $this->name,
            'email'   => $this->email,
            'subject' => $this->subject,
            'body'    => $this->body,
            'status'  => 'unread',
        ]);

        $this->reset(['name', 'email', 'subject', 'body']);
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.site.contact-form');
    }
}
