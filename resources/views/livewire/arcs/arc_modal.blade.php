<?php

use Livewire\Volt\Component;
use App\Models\Arc;

new class extends Component {

    protected $listeners = ['openArcModal' => 'openModal'];

    public $modalOpen = false;


    public $arcId = null;
    public $arcName;
    public $arcOrder;

    public function mount() {
        $this->resetForm();
    }

    public function resetForm() {
        $this->arcId = null;
        $this->arcOrder = Arc::max('order') + 1;
        $this->arcName = '';
    }

    public function openModal($arcId = null) {
        if ($arcId) {
           $arc=Arc::findOrFail($arcId);
            $this->arcId = $arc->id;
            $this->arcName = $arc->name;
            $this->arcOrder = $arc->order;
        } else {
            $this->resetForm();
        }

        $this->modalOpen = true;
    }

    public function saveArc() {
        $this->validate([
            'arcName' => ['required', 'string', 'max:255'],
            'arcOrder' => ['required', 'numeric', 'min:1'],
        ]);

        if ($this->arcId) {
            // Update existing arc
            $arc = Arc::findOrFail($this->arcId);
            $arc->update([
                'name' => $this->arcName,
                'order' => $this->arcOrder,
            ]);
        } else {
            // Create new arc
            Arc::create([
                'name' => $this->arcName,
                'order' => $this->arcOrder,
            ]);
        }

        $this->dispatch('arcsChanged');
        $this->resetForm();
        $this->modalOpen = false;
    }
};
?>

<div>
    <x-modal.card title="{{ $arcId ? 'Update Arc' : 'Create New Arc' }}" blur wire:model="modalOpen">
        <form wire:submit.prevent="saveArc">
            <x-input label="Name" placeholder="Arc name" wire:model="arcName" />
            <x-input 
                label="Order" 
                type="number" 
                placeholder="Arc order" 
                wire:model="arcOrder" 
                step="1" 
                min="1" 
            />   
            

            <div class="flex justify-end">
                <x-button flat label="Cancel" x-on:click="close" />
                <x-button primary label="Save" type="submit" />
            </div>
        </form>
    </x-modal.card>
</div>