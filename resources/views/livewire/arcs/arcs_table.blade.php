<?php

use App\Models\Arc;
use Livewire\Volt\Component;

new class extends Component {
    protected $listeners = [
        'arcsChanged' => 'refreshArcs'
    ];

    public $arcs;
    public function mount() {
        $this->refreshArcs();
    }
    public function refreshArcs() {
        $this->arcs = Arc::orderBy('order')->get();
    }
    public function deleteArc(Arc $arc) {
        $arc->delete();
        $this->refreshArcs();
    }
    
    public function createArc() {
        $this->dispatch('openArcModal');
    }
    public function editArc(Arc $arc) {
        $this->dispatch('openArcModal', $arc->id);
    }
}; ?>

<div>
    <x-button primary label="Add Arc" wire:click="createArc" />
    <table class="w-full divide-y divide-gray-200 m-2">
        <thead class="text-sm uppercase bg-gray-300 text-gray-800">
            <tr>
                <th>Arc Name</th>
                <th>Order</th>
                <th>Action</th>
            </tr>
           
        </thead>
        <tbody>
            @foreach ($arcs as $arc)
                <tr class="text-center">
                    <td>{{$arc->name}}</td>
                    <td>{{$arc->order}}</td>
                    <td>
                        <div class="flex justify-center gap-4">
                            <x-button primary label="Edit" wire:click="editArc({{$arc->id}})" />
                            <x-button negative label="Delete" wire:click="deleteArc({{$arc->id}})" />
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <livewire:arcs.arc_modal/>
</div>
