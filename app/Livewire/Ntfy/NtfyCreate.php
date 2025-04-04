<?php

namespace App\Livewire\Ntfy;

use App\Models;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class NtfyCreate extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $user_id;
    public $users = [];
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

    public function mount()
    {
        $this->users = Models\User::actived()->orderBy('doo', 'asc')->get();
        $this->user_id = Facades\Auth::user()->id;
    }

    public function save()
    {
        // dd($this->image);
        $this->validate();
        if (!empty($this->image)) {
            Facades\Storage::put('public/ntfy-image', $this->image);
            $this->image = $this->image->store('ntfy-image');
        }
        Models\NTFY\Ntfy::create($this->all());
        $this->reset();
        $this->alert('success', 'เพิ่มรายการเรียบร้อย !',[
            'timer' => 3000,
            'closeButton' => true,
           ]);
        return redirect()->route('ntfy-lists');
    }


    public function render()
    {
        return view('livewire.ntfy.ntfy-create');
    }
}
