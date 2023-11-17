<?php

namespace App\Livewire\Ntfy;

use Livewire\Component;
use App\Models;
use Illuminate\Support\Facades;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Masmerise\Toaster\Toaster;

class NtfyEdit extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $dataId;
    public $user_id;
    public $users = [];
    public $photo;
    public $body;
    public $is_active = true;
    public $passenger = [];

    #[Rule('required|min:5|max:255')]
    public $title;

    #[Rule('nullable|image')]
    public $image;

    #[Rule('required')]
    public $published_at;

    protected $messages = [
        'title.required' => 'กรุณาป้อนข้อมูล',
        'title.min:5' => 'กรุณาป้อนข้อมูลน้อยเกินไป',
        'title.max:255' => 'กรุณาป้อนข้อมูลมากเกินไป',
        'image.image' => 'กรุณาใส่ไฟล์ประเภทไฟล์ภาพ',
        'published_at.required' => 'กรุณาป้อนข้อมูล',
    ];

    public function mount($id)
    {
        $ntfy = Models\NTFY\Ntfy::findOrFail($id);
        $this->title = $ntfy->title;
        $this->body = $ntfy->body;
        $this->passenger = $ntfy->passenger;
        $this->photo = $ntfy->image;
        $this->published_at = $ntfy->published_at;
        $this->user_id = $ntfy->user_id;
        $this->dataId = $id;
        $this->users = Models\User::actived()->orderBy('doo', 'asc')->get();
    }

    public function save()
    {
        $this->validate();
        if (!empty($this->image)) {
            Facades\Storage::put('public/ntfy-image', $this->image);
            $this->image = $this->image->store('ntfy-image');
        }else{
            $this->image = $this->photo;
        }
        Models\NTFY\Ntfy::find($this->dataId)->update($this->all());
        $this->reset();
        $this->alert('warning', 'แก้ไขรายการเรียบร้อย !',[
            'timer' => 3000,
            'closeButton' => true,
           ]);
        return redirect()->route('ntfy-lists');
    }

    public function render()
    {
        return view('livewire.ntfy.ntfy-edit');
    }
}
