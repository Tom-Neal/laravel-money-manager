<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;

class CommentIndexPage extends Component
{

    public $comments;
    public string $description = '';
    public ?int $edit = NULL;

    public function rules(): array
    {
        return [
            'comments.*.description' => ['required', 'string'],
            'description'            => ['required', 'string'],
        ];
    }

    public function render()
    {
        $this->comments = auth()->user()->comments;
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

    public function edit(Comment $comment)
    {
        $this->edit = $comment->id;
    }

    public function resetEdit()
    {
        $this->edit = NULL;
    }

    public function update($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->comments->each->save();
        $this->dispatchBrowserEvent(
            'notify', ['message' => 'Comment Updated']
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
