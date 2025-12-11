<?php

namespace App\Livewire\Owner\Information;

use App\Models\Owner;
use App\Models\OwnerRelation;
use Livewire\Component;

class Relations extends Component
{
    public Owner $owner;
    
    // Search
    public $search = '';
    public $searchResults = [];
    public $related_owner_id;

    // Form
    public $verified = false;
    public $description = '';
    public $relationAttributes = ''; // JSON string
    public $editingRelationId = null;

    protected $rules = [
        'related_owner_id' => 'required|exists:owners,id',
        'verified' => 'boolean',
        'description' => 'nullable|string|max:1000',
        'relationAttributes' => 'nullable|json',
    ];

    public function updatedSearch()
    {
        if (strlen($this->search) < 2) {
            $this->searchResults = [];
            return;
        }

        $this->searchResults = Owner::where('id', '!=', $this->owner->id)
            ->where('username', 'like', '%' . $this->search . '%')
            ->limit(5)
            ->get();
    }

    public function selectOwner($id)
    {
        $this->related_owner_id = $id;
        $owner = Owner::find($id);
        if ($owner) {
            $this->search = $owner->username;
            $this->searchResults = [];
        }
    }

    public function edit($id)
    {
        $relation = OwnerRelation::find($id);
        if (!$relation) return;

        $this->editingRelationId = $id;
        $this->related_owner_id = $relation->related_owner_id;
        $this->verified = $relation->verified;
        $this->description = $relation->description;
        $this->relationAttributes = $relation->attributes ? json_encode($relation->attributes) : '';
        
        $this->search = $relation->relatedOwner->username ?? '';
        $this->searchResults = [];
    }

    public function cancelEdit()
    {
        $this->reset(['search', 'searchResults', 'related_owner_id', 'verified', 'description', 'relationAttributes', 'editingRelationId']);
    }

    public function save()
    {
        $this->validate();

        if ($this->editingRelationId) {
            $relation = OwnerRelation::find($this->editingRelationId);
            $relation->update([
                'related_owner_id' => $this->related_owner_id,
                'verified' => $this->verified,
                'description' => $this->description,
                'attributes' => $this->relationAttributes ? json_decode($this->relationAttributes, true) : null,
            ]);
            $message = 'Relación actualizada correctamente.';
        } else {
            // Check if relation already exists
            $exists = OwnerRelation::where('owner_id', $this->owner->id)
                ->where('related_owner_id', $this->related_owner_id)
                ->exists();

            if ($exists) {
                $this->addError('related_owner_id', 'Esta relación ya existe.');
                return;
            }

            OwnerRelation::create([
                'owner_id' => $this->owner->id,
                'related_owner_id' => $this->related_owner_id,
                'verified' => $this->verified,
                'description' => $this->description,
                'attributes' => $this->relationAttributes ? json_decode($this->relationAttributes, true) : null,
            ]);
            if ($this->verified) {
                OwnerRelation::create([
                    'owner_id' => $this->related_owner_id,
                    'related_owner_id' => $this->owner->id,
                    'verified' => true,
                    'description' => $this->description,
                    'attributes' => $this->relationAttributes ? json_decode($this->relationAttributes, true) : null,
                ]);
            }
            $message = 'Relación creada correctamente.';
        }

        $this->reset(['search', 'searchResults', 'related_owner_id', 'verified', 'description', 'relationAttributes', 'editingRelationId']);
        $this->dispatch('alert', ['type' => 'success', 'message' => $message]);
    }

    public function delete($id)
    {
        OwnerRelation::destroy($id);
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Relación eliminada.']);
    }

    public function render()
    {
        $relations = $this->owner->relations()->with('relatedOwner')->get();
        return view('livewire.owner.information.relations', [
            'relations' => $relations
        ]);
    }
}
