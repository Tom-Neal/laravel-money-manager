<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;

class CommentIndexPage extends Component
{

    public string $description = '';

    public function rules(): array
    {
        return [
            'description' => ['required', 'string'],
        ];
    }

    public function render()
    {
        return view('livewire.comment-index-page');
    }

    public function store()
    {
        $this->validateOnly('description');
        auth()->user()->comments()->create([
            'description' => $this->description
        ]);
        $this->description = '';
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'success', 'message' => 'Comment Added']
        );
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        $this->dispatchBrowserEvent(
            'notify', ['type' => 'danger', 'message' => 'Comment Removed']
        );
    }

}
