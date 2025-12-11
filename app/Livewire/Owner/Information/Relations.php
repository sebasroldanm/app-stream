<?php

namespace App\Livewire\Owner\Information;

use App\Models\Owner;
use App\Models\OwnerRelation;
use App\Models\OwnerRelationGroup;
use Livewire\Component;

class Relations extends Component
{
    public Owner $owner;
    
    // Search
    public $search = '';
    public $searchResults = [];
    public $related_owner_id;

    // Form (Group Attributes)
    public $verified = false;
    public $description = '';
    public $relationAttributes = ''; // JSON string
    
    // State
    public $groupId = null;
    public $isEditingGroup = false;

    protected $rules = [
        'related_owner_id' => 'required|exists:owners,id',
        'verified' => 'boolean',
        'description' => 'nullable|string|max:1000',
        'relationAttributes' => 'nullable|json',
    ];

    public function mount()
    {
        $this->loadGroupData();
    }

    public function loadGroupData()
    {
        $group = $this->owner->relation_group; // using the accessor
        if ($group) {
            $this->groupId = $group->id;
            $this->verified = $group->verified;
            $this->description = $group->description;
            $this->relationAttributes = $group->attributes ? json_encode($group->attributes) : '';
        } else {
            $this->groupId = null;
            $this->reset(['verified', 'description', 'relationAttributes']);
        }
    }

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

    public function save()
    {
        // Validation: required related_owner_id only if we are NOT just updating group details?
        // Actually, let's split. 
        // 1. Add new relation.
        // 2. Update group details.
        
        // If related_owner_id is present, we are trying to add/merge.
        if ($this->related_owner_id) {
            $this->validate([
                'related_owner_id' => 'required|exists:owners,id',
            ]);
            $this->handleAddRelation();
        } elseif ($this->groupId) {
            // Just updating group details
            $this->validate([
                'verified' => 'boolean',
                'description' => 'nullable|string|max:1000',
                'relationAttributes' => 'nullable|json',
            ]);
            $this->handleUpdateGroup();
        }
    }

    public function handleUpdateGroup()
    {
        $group = OwnerRelationGroup::find($this->groupId);
        if ($group) {
            $group->update([
                'verified' => $this->verified,
                'description' => $this->description,
                'attributes' => $this->relationAttributes ? json_decode($this->relationAttributes, true) : null,
            ]);
            $this->dispatch('alert', ['type' => 'success', 'message' => 'Detalles del grupo actualizados.']);
        }
    }

    public function handleAddRelation()
    {
        $targetOwner = Owner::find($this->related_owner_id);
        if (!$targetOwner) return;

        // My Group
        $myGroup = $this->owner->relation_group;
        // Target Group
        $targetGroup = $targetOwner->relation_group;

        if ($myGroup && $targetGroup) {
            if ($myGroup->id === $targetGroup->id) {
                $this->addError('related_owner_id', 'Este owner ya está en el grupo.');
                return;
            }
            // Merge: Move target members to my group
            foreach ($targetGroup->relations as $relation) {
                $relation->update(['owner_relation_group_id' => $myGroup->id]);
            }
            $targetGroup->delete(); // Delete empty group
            $msg = 'Grupos fusionados correctamente.';

        } elseif ($myGroup) {
            // Add Target to My Group
            OwnerRelation::create([
                'owner_id' => $targetOwner->id,
                'owner_relation_group_id' => $myGroup->id,
            ]);
            $msg = 'Owner agregado al grupo.';

        } elseif ($targetGroup) {
            // Add Me to Target Group
            OwnerRelation::create([
                'owner_id' => $this->owner->id,
                'owner_relation_group_id' => $targetGroup->id,
            ]);
            $this->loadGroupData(); // Refresh my state to match new group
            $msg = 'Te has unido al grupo del owner.';

        } else {
            // Create New Group
            $newGroup = OwnerRelationGroup::create([
                'verified' => $this->verified,
                'description' => $this->description,
                'attributes' => $this->relationAttributes ? json_decode($this->relationAttributes, true) : null,
            ]);
            
            // Add both
            OwnerRelation::create(['owner_id' => $this->owner->id, 'owner_relation_group_id' => $newGroup->id]);
            OwnerRelation::create(['owner_id' => $targetOwner->id, 'owner_relation_group_id' => $newGroup->id]);
            
            $this->groupId = $newGroup->id;
            $msg = 'Nuevo grupo de relación creado.';
        }

        $this->reset(['search', 'searchResults', 'related_owner_id']);
        $this->dispatch('alert', ['type' => 'success', 'message' => $msg]);
    }

    public function createNewGroup() {
         // Logic to start a fresh group just for myself? Usually implicit when adding someone.
         // Unused for now.
    }

    public function removeMember($relationId)
    {
        $relation = OwnerRelation::find($relationId);
        if ($relation && $relation->owner_relation_group_id == $this->groupId) {
             $relation->delete();
             
             // If group has only 1 member left (me), maybe dissolve it? 
             // Or keep it. Let's keep strict "same person" logic -> if only 1, it's not a pair.
             // But maybe I wanted to keep the "Description" for myself?
             // For now, simple delete.
             
             $this->dispatch('alert', ['type' => 'success', 'message' => 'Miembro eliminado del grupo.']);
        }
    }

    public function render()
    {
        $group = null;
        $members = collect();

        if ($this->groupId) {
            $group = OwnerRelationGroup::find($this->groupId);
            if ($group) {
                // Get members excluding myself if desired, OR show all including myself?
                // Usually "Related Owners" implies others.
                $members = $group->relations()->with('owner')->where('owner_id', '!=', $this->owner->id)->get();
            }
        }

        return view('livewire.owner.information.relations', [
            'group' => $group,
            'members' => $members
        ]);
    }
}
