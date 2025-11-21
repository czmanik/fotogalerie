<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;

class ContactForm extends Component
{
    // Proměnné formuláře
    public $name = '';
    public $email = '';
    public $body = '';

    // Stav odeslání (pro zobrazení "Děkujeme")
    public $success = false;

    // Pravidla pro validaci
    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'body' => 'required|min:10',
    ];

    public function submit()
    {
        $this->validate();

        // Uložení do databáze (uvidíš to pak v Adminu > Zprávy)
        Message::create([
            'name' => $this->name,
            'email' => $this->email,
            'body' => $this->body,
            'type' => 'question', // Výchozí typ pro kontakt
        ]);

        // Reset formuláře a zobrazení úspěchu
        $this->reset(['name', 'email', 'body']);
        $this->success = true;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}