<?php

namespace App\Livewire\Site;

use App\Models\Subscriber;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Newsletter extends Component
{
    #[Validate('required|email|max:150|unique:subscribers,email')]
    public string $email = '';

    public bool $subscribed = false;

    public function subscribe(): void
    {
        $this->validate();

        Subscriber::create(['email' => $this->email]);

        $this->reset('email');
        $this->subscribed = true;
    }

    public function render()
    {
        return view('livewire.site.newsletter');
    }
}
