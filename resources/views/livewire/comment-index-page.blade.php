<div id="page" class="container">
    <x-session-message></x-session-message>
    <div class="row mb-3">
        <div class="col-md-12">
            <h1>Comments</h1>
            <p class="mb-0">Store useful bits of info as required</p>
        </div>
    </div>
    <div class="card card-body mb-3">
        <div class="row">
            <div class="col-md-12 mb-3">
                @forelse($comments as $comment)
                    <div class="border mb-3 mt-3 rounded">
                        <div class="d-flex flex-column comment-section">
                            <div class="p-2 bg-light">
                                <div class="d-flex flex-row justify-content-between align-items-start">
                                    <div class="d-flex flex-column justify-content-start ml-2">
                                        <span class="date text-black-50">{{ date('H:i d/m/Y', strtotime($comment->created_at)) }}</span>
                                    </div>
                                    <div>
                                        <button
                                            class="btn btn-outline-warning btn-sm me-1"
                                            @if((int)$edit === (int)$comment->id) wire:click="resetEdit()" @else wire:click="edit({{ $comment->id }})" @endif
                                        >
                                            <i class="fas fa-wrench"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm" wire:click="destroy({{ $comment->id }})">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    @if((int)$edit === (int)$comment->id)
                                        <textarea
                                            class="form-control mb-3"
                                            rows="3"
                                            wire:model.lazy="comments.{{ $loop->index }}.description"
                                            wire:change="update('comments.{{ $loop->index }}.description')"
                                        ></textarea>
                                    @else
                                        <?php echo $comment->description; ?>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <span class="fst-italic">There are no comments yet.</span>
                @endforelse
            </div>
            <x-error></x-error>
            <div class="col-md-12">
                <label>New Comment</label>
                <textarea class="form-control mb-3" rows="3" wire:model="description"></textarea>
                <div class="text-end">
                    <button class="btn btn-outline-success" wire:click="store()">
                        Add Comment
                        <i class="fas fa-comment ms-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
