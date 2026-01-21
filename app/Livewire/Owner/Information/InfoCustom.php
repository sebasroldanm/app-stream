<?php

namespace App\Livewire\Owner\Information;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Owner;
use App\Models\OwnerInfoType;
use App\Models\OwnerInfoSource;
use App\Models\OwnerCustomInfo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class InfoCustom extends Component
{
    use WithFileUploads;

    public Owner $owner;
    
    public $info_type_id = '';
    public $source_id = '';
    public $data_value;

    public function mount(Owner $owner)
    {
        $this->owner = $owner;
    }

    public function getSelectedTypeModelProperty()
    {
        if (!$this->info_type_id) {
            return null;
        }
        return OwnerInfoType::find($this->info_type_id);
    }

    public function updatedInfoTypeId()
    {
        $this->reset('data_value');
    }

    protected function rules()
    {
        $rules = [
            'info_type_id' => 'required|exists:owner_info_types,id',
            'source_id' => 'nullable|exists:owner_info_sources,id',
        ];

        $type = $this->selectedTypeModel;

        if ($type) {
            if ($type->data_type === 'url') {
                $rules['data_value'] = 'required|url';
            } elseif ($type->data_type === 'number') {
                $rules['data_value'] = 'required|numeric';
            } elseif ($type->data_type === 'file') {
                // Adjust max size as needed, e.g., 2MB
                $rules['data_value'] = 'required|file|max:10240'; 
            } else {
                $rules['data_value'] = 'required|string';
            }
        }

        return $rules;
    }

    public function render()
    {
        $types = OwnerInfoType::where('is_active', true)->get();
        $sources = OwnerInfoSource::all();

        // 1. Get IDs of groups the current owner belongs to
        $groupIds = $this->owner->relations()->pluck('owner_relation_group_id');

        // 2. If in groups, find all owner IDs in those groups
        if ($groupIds->isNotEmpty()) {
            $relatedOwnerIds = \App\Models\OwnerRelation::whereIn('owner_relation_group_id', $groupIds)
                ->pluck('owner_id')
                ->unique();
        } else {
            // Fallback: just the current owner
            $relatedOwnerIds = collect([$this->owner->id]);
        }

        // 3. Fetch Custom Info for ALL related owners
        $customInfos = OwnerCustomInfo::whereIn('owner_id', $relatedOwnerIds)
            ->with(['type', 'source', 'owner']) // eager load owner for display/logic
            ->get();

        return view('livewire.owner.information.info-custom', compact('types', 'sources', 'customInfos'));
    }

    public function save()
    {
        $this->validate();

        $valueToStore = $this->data_value;
        $type = $this->selectedTypeModel;

        if ($type && $type->data_type === 'file') {
            $user = Auth::user();
            $username = $user->username ?? 'default';
            // Store in specific path: storage/app/public/customer/{username}/uploads
            $path = $this->data_value->storeAs(
                "customer/{$username}/uploads", 
                $this->data_value->getClientOriginalName(), 
                'public'
            );
            $valueToStore = $path;
        }

        OwnerCustomInfo::create([
            'owner_id' => $this->owner->id,
            'info_type_id' => $this->info_type_id,
            'source_id' => $this->source_id ?: null,
            'data_info' => ['value' => $valueToStore],
        ]);

        if ($type && $type->data_type === 'file') {
            if (!$this->owner->isMediaCustom) {
                $this->owner->isMediaCustom = true;
                $this->owner->save();
            }
        } else {
            if (!$this->owner->isInfoCustom) {
                $this->owner->isInfoCustom = true;
                $this->owner->save();
            }
        }

        $this->reset(['info_type_id', 'source_id', 'data_value']);
    }

    public function delete($id)
    {
        $info = OwnerCustomInfo::findOrFail($id);
        
        // Ensure the info belongs to the current owner DO NOT ALLOW deleting other's info
        if ($info->owner_id === $this->owner->id) {
            // Optional: Delete file from storage if it exists
            if ($info->type && $info->type->data_type === 'file') {
                 if (isset($info->data_info['value'])) {
                     Storage::disk('public')->delete($info->data_info['value']);
                 }
            }
            $info->delete();
        }
    }
}
