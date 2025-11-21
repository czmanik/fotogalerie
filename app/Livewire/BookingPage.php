<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PhotoSlot;
use App\Models\Message;
use Carbon\Carbon;

class BookingPage extends Component
{
    public $selectedSlotId = null;
    
    // Data formuláře
    public $name = '';
    public $email = '';
    public $phone = '';
    public $body = '';
    
    public $success = false;
    
    // Pagination
    public $limit = 10; // Kolik termínů načíst na začátku

    protected $rules = [
        'selectedSlotId' => 'required|exists:photo_slots,id',
        'name' => 'required|min:3',
        'email' => 'required|email',
        'phone' => 'required',
        'body' => 'nullable',
    ];

    public function selectSlot($slotId)
    {
        $this->selectedSlotId = $slotId;
    }
    
    public function loadMore()
    {
        $this->limit += 15; // Načíst dalších 15
    }

    public function submit()
    {
        $this->validate();

        // Kontrola, zda je slot stále 'free'
        $slot = PhotoSlot::where('id', $this->selectedSlotId)->where('status', 'free')->first();

        if (!$slot) {
            $this->addError('selectedSlotId', 'Tento termín byl právě obsazen někým jiným.');
            return;
        }

        // Vytvoření objednávky
        Message::create([
            'type' => 'order',
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'body' => $this->body,
            'photo_slot_id' => $slot->id,
        ]);

        // Změna statusu na 'pending' (Předobjednáno)
        $slot->update(['status' => 'pending']);

        $this->success = true;
    }

    public function render()
    {
        // Načteme termíny (i obsazené, abychom je viděli šedě)
        $slots = PhotoSlot::where('start_at', '>', now())
            ->orderBy('start_at')
            ->take($this->limit)
            ->get();
            
        // Zjistíme, jestli existují další termíny (pro zobrazení tlačítka)
        $hasMore = PhotoSlot::where('start_at', '>', now())->count() > $this->limit;

        // Seskupíme je podle měsíce (např. "Listopad 2025")
        $groupedSlots = $slots->groupBy(function($val) {
            return Carbon::parse($val->start_at)->translatedFormat('F Y'); 
        });

        return view('livewire.booking-page', [
            'groupedSlots' => $groupedSlots,
            'hasMore' => $hasMore
        ])->layout('components.layout');
    }
}