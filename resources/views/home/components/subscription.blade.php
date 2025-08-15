<div id="subscribe" class="shadow">
    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Subscribe
    </button>
</div>

<!-- Modal -->
<form id="subscriptionForm" action="{{ route('subscription.store') }}" method="post">
    @csrf

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Subscribe to get updates</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" placeholder="Enter your email to subscribe" 
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="subscribeBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@push('styles')
<style>
    #subscribe {
        position: fixed;
        top: 50%;
        left: 95%;
        z-index: 999999;
        transform: rotate(90deg);
    }
</style>
@endpush

@push('scripts')
<script>
// Create top-right notification container
if (!$('#topRightNotifications').length) {
    $('body').append('<div id="topRightNotifications" style="position: fixed; top: 20px; right: 20px; z-index: 99999; width: 350px;"></div>');
}

function showTopRightNotification(message, type = 'success') {
    var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    var icon = type === 'success' ? '✓' : '✗';
    
    var notification = $('<div class="alert ' + alertClass + ' alert-dismissible fade show shadow-lg" role="alert" style="margin-bottom: 10px; border-radius: 8px;">' +
        '<strong>' + icon + '</strong> ' + message +
        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
    
    $('#topRightNotifications').prepend(notification);
    
    // Auto remove after 5 seconds
    setTimeout(function() {
        notification.alert('close');
    }, 5000);
}

$(document).ready(function() {
    $('#subscriptionForm').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitBtn = $('#subscribeBtn');
        var spinner = submitBtn.find('.spinner-border');
        var alertContainer = $('#alertContainer');
        
        // Show loading state
        submitBtn.prop('disabled', true);
        spinner.removeClass('d-none');
        submitBtn.text('Subscribing...');
        alertContainer.empty();
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                // Show modal success message
                alertContainer.html('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                    'Thank you! You have been successfully subscribed to our newsletter.' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                
                // Show top-right notification
                showTopRightNotification('Successfully subscribed to GDRI newsletter!', 'success');
                
                // Reset form
                form[0].reset();
                
                // Auto close modal after 2 seconds
                setTimeout(function() {
                    $('#exampleModal').modal('hide');
                }, 2000);
            },
            error: function(xhr) {
                var errors = xhr.responseJSON?.errors || {};
                var errorMsg = 'An error occurred. Please try again.';
                
                if (errors.email) {
                    errorMsg = errors.email[0];
                } else if (xhr.responseJSON?.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                
                // Show modal error message
                alertContainer.html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                    errorMsg +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                
                // Show top-right notification
                showTopRightNotification(errorMsg, 'error');
            },
            complete: function() {
                // Reset button state
                submitBtn.prop('disabled', false);
                spinner.addClass('d-none');
                submitBtn.text('Subscribe');
            }
        });
    });
    
    // Clear alerts when modal is closed
    $('#exampleModal').on('hidden.bs.modal', function() {
        $('#alertContainer').empty();
        $('#subscriptionForm')[0].reset();
    });
});
</script>
@endpush