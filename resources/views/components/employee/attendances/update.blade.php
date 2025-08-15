<div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Attendance</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_form">
                    <div class="container">
                        <div class="row">

                            <input type="hidden" id="updateId">

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" id="nameUpdate" name="nameUpdate" class="form-control" readonly>
                                    <small id="nameUpdateError" class="text-danger"></small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Date <span class="text-danger">*</span></label>
                                    <input type="date" id="dateUpdate" name="dateUpdate" class="form-control" readonly>
                                    <small id="dateUpdateError" class="text-danger"></small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Location <span class="text-danger">*</span></label>
                                    <input type="text" id="locationUpdate" name="locationUpdate" class="form-control"
                                        value="{{ old('locationUpdate') }}" required>
                                    <small id="locationUpdateError" class="text-danger"></small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Check In <span class="text-danger">*</span></label>
                                    <input type="time" id="check_inUpdate" name="check_inUpdate" class="form-control"
                                        value="{{ old('check_inUpdate') }}" readonly>
                                    <small id="check_inUpdateError" class="text-danger"></small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Check Oute Time <span class="text-danger">*</span></label>
                                    <input type="time" id="check_out" name="check_out" class="form-control"
                                        value="{{ now()->format('H:i') }}" readonly required>
                                    <small id="check_outError" class="text-danger"></small>
                                </div>

                                {{-- Late check-Out (hidden until after 17am) --}}
                                <div id="lateCheckOutWrapper" class="mb-3 d-none">
                                    <label>Why late (check Out) <span class="text-danger">*</span></label>
                                    <textarea id="late_check_out" name="late_check_out" class="form-control"></textarea>
                                    <small id="late_check_outError" class="text-danger"></small>
                                </div>                                

                                
                                <div class="mb-3">
                                    <label>Work Summery <span class="text-danger">*</span></label>
                                    <textarea id="note" name="note" class="form-control" required></textarea>
                                    <small id="noteError" class="text-danger"></small>
                                </div>

                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button id="update_modal_close" class="btn btn-sm btn_dark" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button onclick="Update()" id="update-btn" class="btn btn-sm btn_green">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>




@push('scripts')
    <script>

        $(document).ready(function () {
            $('#late_check_out, #note').summernote({ height: 100 });
        });

        // Why late chick out start
        document.addEventListener('DOMContentLoaded', () => {
            const now = new Date();

            // Show “Why late (check in)” after 9am
            if (now.getHours() >= 17) {
                const wrapperIn = document.getElementById('lateCheckOutWrapper');
                const taIn = document.getElementById('late_check_out');
                wrapperIn.classList.remove('d-none');
                taIn.required = true;
            }

        });
        // Why late chick out end

        async function FillUpUpdateForm(id) {
            try {

                $('#updateId').val(id);
                let res = await axios.post("/attendance/by-id", { id: id })
                let row = res.data.row;

                $('#nameUpdate').val(row.user.name);
                $('#dateUpdate').val(row.date);
                $('#locationUpdate').val(row.location);
                $('#check_inUpdate').val(row.check_in);

                if (row.check_out) {
                    $('#check_out').val(row.check_out);
                }
                if (row.late_check_out) {
                    $('#late_check_out').val(row.late_check_out);
                }
                if (row.note) {
                    $('#note').val(row.note);
                }
            } catch (e) {
                errorToast(e.response.data['message']);
            }
        }

        async function Update() {
            try {
                let formData = new FormData();
                formData.append('check_out', $("#check_out").val());
                formData.append('location', $("#locationUpdate").val());

                // Late Check Out
                let isEmptyLateCheckOut = $('#late_check_out').summernote('isEmpty');
                let lateCheckOutHtml = isEmptyLateCheckOut ? '' : $('#late_check_out').summernote('code');
                formData.append('late_check_out', lateCheckOutHtml);

                // Note
                let isEmptyNote = $('#note').summernote('isEmpty');
                let noteHtml = isEmptyNote ? '' : $('#note').summernote('code');
                formData.append('note', noteHtml);

                formData.append('updateId', $('#updateId').val())

                let res = await axios.post('/attendance/update', formData)

                if (res.status === 200) {
                    $("#update_modal_close").click();
                    document.getElementById("update_form").reset();
                    successToast(res.data['message']);
                    $('#locationUpdateError').text('');
                    $('#check_outError').text('');
                    $('#late_check_outError').text('');
                    $('#noteError').text('');
                    await getList();
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#locationUpdateError').text(errors.location ? errors.location[0] : '');
                    $('#check_outError').text(errors.check_out ? errors.check_out[0] : '');
                    $('#late_check_outError').text(errors.late_check_out ? errors.late_check_out[0] : '');
                    $('#noteError').text(errors.note ? errors.note[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }


        }

    </script>

@endpush