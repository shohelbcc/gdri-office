@extends('layouts.app-home')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center mb-5">Experience Certificate</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Enter Certificate Number</h5>
                        <form id="certificateForm">
                            @csrf
                            <div class="mb-3">
                                <label for="certificate_number" class="form-label">Certificate Number</label>
                                <input type="text" class="form-control" id="certificate_number" name="certificate_number" required>
                            </div>
                            <button type="submit" class="btn btn-primary" id="searchBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                Get Certificate
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div id="certificateResult" class="d-none">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Experience Certificate</h5>
                            <div id="certificateContent"></div>
                        </div>
                    </div>
                </div>
                <div id="noCertificateFound" class="d-none">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <div class="text-warning mb-3">
                                <i class="fas fa-exclamation-triangle fa-3x"></i>
                            </div>
                            <h5 class="text-warning">No Certificate Found</h5>
                            <p class="text-muted">No certificate found with the provided certificate number. Please check the number and try again.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
    $('#certificateForm').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitBtn = $('#searchBtn');
        var spinner = submitBtn.find('.spinner-border');
        var certificateNumber = $('#certificate_number').val();
        
        // Show loading state
        submitBtn.prop('disabled', true);
        spinner.removeClass('d-none');
        submitBtn.text('Searching...');
        
        // Hide previous results
        $('#certificateResult').addClass('d-none');
        $('#noCertificateFound').addClass('d-none');
        
        $.ajax({
            url: "{{ route('show.experience.certificate') }}",
            method: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                certificate_number: certificateNumber
            },
            success: function(response) {
                console.log('Response:', response); // Debug log
                
                if (response.certificate) {
                    // Show certificate - Only PDF without navigation
                    var certificateHtml = `
                        <div class="certificate-info">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Certificate Number:</strong></div>
                                <div class="col-sm-8">${response.certificate.certificate_number}</div>
                            </div>
                            ${response.certificate.certificate ? `
                                <div class="text-center mb-3">
                                    <a href="${response.certificate.certificate}" target="_blank" class="btn btn-primary">
                                        <i class="fas fa-download"></i> Download Certificate
                                    </a>
                                </div>
                                <div class="pdf-viewer">
                                    <iframe src="${response.certificate.certificate}#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="600px" frameborder="0" style="border: 1px solid #ddd; border-radius: 8px;"></iframe>
                                </div>
                            ` : '<div class="alert alert-info text-center"><i class="fas fa-info-circle"></i> Certificate PDF is not available.</div>'}
                        </div>
                    `;
                    
                    $('#certificateContent').html(certificateHtml);
                    $('#certificateResult').removeClass('d-none');
                    
                    showTopRightNotification('Certificate found successfully!', 'success');
                } else {
                    $('#noCertificateFound').removeClass('d-none');
                    showTopRightNotification('No certificate found with this number', 'error');
                }
            },
            error: function(xhr) {
                console.log('Error Response:', xhr.responseJSON); // Debug log
                
                var errorMsg = 'An error occurred while searching for the certificate.';
                
                if (xhr.responseJSON?.errors?.certificate_number) {
                    errorMsg = xhr.responseJSON.errors.certificate_number[0];
                } else if (xhr.responseJSON?.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                
                $('#noCertificateFound').removeClass('d-none');
                showTopRightNotification(errorMsg, 'error');
            },
            complete: function() {
                // Reset button state
                submitBtn.prop('disabled', false);
                spinner.addClass('d-none');
                submitBtn.text('Get Certificate');
            }
        });
    });
});
</script>
@endpush
