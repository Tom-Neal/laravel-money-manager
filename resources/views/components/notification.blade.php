<div class="row">
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1000">
            <div id="toaster" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <span id="texts"></span>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        window.addEventListener('notify', function(event) {
            document.getElementById(`texts`).innerText = event.detail.message; // Set toast message
            document.getElementById(`toaster`).className = event.detail.type ?
                `toast align-items-center text-white border-0 bg-${event.detail.type}` :
                `toast align-items-center text-white border-0 bg-info`; // Set toast type (or use default)
            const toaster = new bootstrap.Toast(document.getElementById(`toaster`), {});
            toaster.show();
        });
    });
</script>
