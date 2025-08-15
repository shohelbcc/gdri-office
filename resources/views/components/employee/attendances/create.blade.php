<div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add New Attendance</h6>
                <button time="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <input type="hidden" id="user_id" name="user_id" value="{{ Auth::id() }}">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ Auth::user()->name }}" readonly>
                            <small id="nameError" class="text-danger"></small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Date <span class="text-danger">*</span></label>
                            <input type="date" id="date" name="date" class="form-control"
                                value="{{ now()->format('Y-m-d') }}" readonly required>
                            <small id="dateError" class="text-danger"></small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Location <span class="text-danger">*</span></label>
                            <input type="text" id="location" name="location" class="form-control"
                                value="{{ old('location') }}" required>
                            <small id="locationError" class="text-danger"></small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Check In Time <span class="text-danger">*</span></label>
                            <input type="time" id="check_in" name="check_in" class="form-control"
                                value="{{ now()->format('H:i') }}" readonly required>
                            <small id="check_inError" class="text-danger"></small>
                        </div>

                        {{-- Late check-in (hidden until after 9am) --}}
                        <div id="lateCheckInWrapper" class="mb-3 d-none">
                            <label>Why late (check in) <span class="text-danger">*</span></label>
                            <textarea id="late_check_in" name="late_check_in" class="form-control"></textarea>
                            <small id="late_check_inError" class="text-danger"></small>
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button id="modal_close" class="btn btn-sm btn_dark" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="button" onclick="Save()" id="save-btn" class="btn btn-sm btn_green">Save
                        Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#late_check_in').summernote({ height: 100 });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const now = new Date();

            // Show “Why late (check in)” after 9am
            if (now.getHours() >= 9) {
                const wrapperIn = document.getElementById('lateCheckInWrapper');
                const taIn = document.getElementById('late_check_in');
                wrapperIn.classList.remove('d-none');
                taIn.required = true;
            }

        });
        // Why late chick in end

        async function Save() {
            try {

                let formData = new FormData();
                formData.append('user_id', $("#user_id").val());
                formData.append('date', $("#date").val());
                formData.append('location', $("#location").val());
                formData.append('check_in', $("#check_in").val());

                let isEmpty = $('#late_check_in').summernote('isEmpty');
                let lateHtml = isEmpty ? '' : $('#late_check_in').summernote('code');

                formData.append('late_check_in', lateHtml);

                let res = await axios.post('/attendance/store', formData)

                if (res.status === 200) {
                    $("#modal_close").click();
                    document.getElementById("save-form").reset();
                    successToast(res.data['message']);
                    $('#user_idError').text('');
                    $('#dateError').text('');
                    $('#locationError').text('');
                    $('#check_inError').text('');
                    $('#late_check_inError').text('');
                    await getList()
                } else {
                    errorToast(res.data.message || 'Unknown response status');
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#user_idError').text(errors.user_id ? errors.user_id?.[0] : '');
                    $('#dateError').text(errors.date ? errors.date?.[0] : '');
                    $('#locationError').text(errors.location ? errors.location[0] : '');
                    $('#check_inError').text(errors.check_in ? errors.check_in[0] : '');
                    $('#late_check_inError').text(errors.late_check_in ? errors.late_check_in[0] : '');
                } else {
                    errorToast(error.response.data['message'] || `Server returned ${error.response.status}`);
                }
            }

        }
    </script>
@endpush