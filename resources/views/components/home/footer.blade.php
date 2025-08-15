<!-- Footer Start -->
<div class="container-fluid bg-dark text-light footer pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-md-4">
                <h4 class="text-white mb-4">Get In Touch</h4>
                <p class="mb-2"><i class="fa fa-building me-3"></i>{{ getBranchFirst()->name }}</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>{{ getBranchFirst()->phone }}</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>{{ getBranchFirst()->email }}</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>{{ getBranchFirst()->location }}</p>
            </div>
            <div class="col-md-4">
                <h4 class="text-white mb-4">Legal</h4>
                <div class="privacy">
                    <a class="btn btn-link" href="{{ route('privacy.policy') }}">Privacy Policy</a>
                    <a class="btn btn-link" href="{{ route('terms.condition') }}">Terms & Conditions</a>
                    <a class="btn btn-link" href="{{ route('license') }}">License</a>
                </div>
                <div class="socials" id="socials">
                    @php $social = getAllSocial(); @endphp
                    @if ($social)
                        @if (!empty($social['facebook']))
                            <a class="{{ $social['facebook'] }}" href="{{ $social['facebook'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if (!empty($social['twitter']))
                            <a class="{{ $social['twitter'] }}" href="{{ $social['twitter'] }}" target="_blank"><i class="fab fa-twitter"></i></a>
                        @endif
                        @if (!empty($social['linkedin']))
                            <a class="{{ $social['linkedin'] }}" href="{{ $social['linkedin'] }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        @endif
                        @if (!empty($social['instagram']))
                            <a class="{{ $social['instagram'] }}" href="{{ $social['instagram'] }}" target="_blank"><i class="fab fa-instagram"></i></a>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <h4 class="text-white mb-4">Newsletter</h4>
                <form id="footerSubscriptionForm" action="{{ route('subscription.store') }}" method="post">
                    @csrf
                    @method('POST')

                    <div class="mx-auto mb-3" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" name="email" type="email"
                            placeholder="Type your email" id="footerEmail" required>
                    </div>
                    <button type="submit" class="btn btn-primary py-2 top-0 end-0 me-2 w-100" id="footerSubscribeBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                        Subscribe
                    </button>

                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">GDRI</a>, All Rights Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    Developed By <a class="border-bottom text-primary" href="https://mshohel.com">Shohel Rana</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

@push('scripts')
<script>
// Create top-right notification container if not exists
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
    $('#footerSubscriptionForm').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitBtn = $('#footerSubscribeBtn');
        var spinner = submitBtn.find('.spinner-border');
        var emailInput = $('#footerEmail');
        
        // Show loading state
        submitBtn.prop('disabled', true);
        spinner.removeClass('d-none');
        submitBtn.text('Subscribing...');
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                // Show top-right success notification
                showTopRightNotification('Successfully subscribed to GDRI newsletter!', 'success');
                
                // Reset form
                form[0].reset();
                emailInput.removeClass('is-invalid');
            },
            error: function(xhr) {
                var errors = xhr.responseJSON?.errors || {};
                var errorMsg = 'An error occurred. Please try again.';
                
                if (errors.email) {
                    errorMsg = errors.email[0];
                    emailInput.addClass('is-invalid');
                } else if (xhr.responseJSON?.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                
                // Show top-right error notification
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
});
</script>
@endpush