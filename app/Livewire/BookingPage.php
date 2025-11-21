<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PhotoSlot;
use App\Models\Message;

class BookingPage extends Component
{
    public $selectedSlotId = null; // Který termín klient vybral
    
    // Data formuláře
    public $name = '';
    public $email = '';
    public $phone = '';
    public $body = '';
    
    public $success = false;

    protected $rules = [
        'selectedSlotId' => 'required|exists:photo_slots,id',
        'name' => 'required|min:3',
        'email' => 'required|email',
        'phone' => 'required',
        'body' => 'nullable',
    ];

    // Metoda pro výběr slotu (kliknutí na tlačítko s časem)
    public function selectSlot($slotId)
    {
        $this->selectedSlotId = $slotId;
    }

    public function submit()
    {
        $this->validate();

        // 1. Najít slot a zkontrolovat, zda je stále volný
        $slot = PhotoSlot::where('id', $this->selectedSlotId)->where('is_booked', false)->first();

        if (!$slot) {
            $this->addError('selectedSlotId', 'Tento termín byl před chvílí obsazen.');
            return;
        }

        // 2. Vytvořit zprávu (Objednávku)
        Message::create([
            'type' => 'order', // Typ objednávka
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'body' => $this->body,
            'photo_slot_id' => $slot->id,
        ]);

        // 3. Označit slot jako obsazený
        $slot->update(['is_booked' => true]);

        // 4. Hotovo
        $this->success = true;
    }

    public function render()
    {
        // Načteme pouze budoucí a volné termíny
        $slots = PhotoSlot::where('is_booked', false)
            ->where('start_at', '>', now())
            ->orderBy('start_at')
            ->get();

        return view('livewire.booking-page', [
            'slots' => $slots
        ])->layout('components.layout');
    }
}