<div class="card card-body mb-3">
    <div class="row">
        <div class="col-md-12 mb-3">
            <div
                wire:ignore
                x-data
                x-init="
                    FilePond.setOptions({
                        allowMultiple: true,
                        maxFiles: 5,
                        server: {
                            process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                                @this.upload('files', file, load, error, progress)
                            },
                            revert: (filename, load) => {
                                @this.removeUpload('files', filename, load)
                            },
                        },
                        labelFileProcessingComplete: 'File ready',
                        labelIdle: 'Drag & drop your files or click to browse (max 5 at a time)',
                        maxFileSize: {{ config('media-library.max_file_size') }}
                    });
                    FilePond.create($refs.input);
                "
            >
                <input type="file" x-ref="input">
                <script>
                    document.addEventListener("DOMContentLoaded", function(event) {
                        const inputElement = document.querySelector('input[type="file"]');
                        FilePond.registerPlugin(FilePondPluginFileValidateSize);
                        const pond = FilePond.create(inputElement);
                        window.addEventListener('reset-files', function(event) {
                            pond.removeFiles();
                        });
                    });
                </script>
            </div>
        </div>
        <div class="col-md-12 text-end d-flex justify-content-between">
            @if(count($files) > 0)
                <span class="fst-italic fw-bold text-danger">
                    Please note, selected files will only be uploaded after clicking "Upload New Files"
                </span>
            @else
                <span></span>
            @endif
            <button
                class="btn btn-outline-success border-success border-3 fw-bold"
                wire:click="storeMedia"
                @if(count($files) === 0) disabled @endif
            >
                Upload New Files
                <i class="fas fa-upload ms-1"></i>
            </button>
        </div>
    </div>
</div>
