<div class="modal fade" id="create_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add New Batch</h6>
                <button time="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Batch Number<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="batchNo" placeholder="ICAP-01"
                                    value="{{ old('batchNo') }}">
                                <small id="batchNoError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Offer Date<span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="offerDate" placeholder="yyyy-mm-dd"
                                    value="{{ old('offerDate') }}">
                                <small id="offerDateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date<span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="startDate" placeholder="yyyy-mm-dd"
                                    value="{{ old('startDate') }}">
                                <small id="startDateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date<span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="endDate" placeholder="yyyy-mm-dd"
                                    value="{{ old('endDate') }}">
                                <small id="endDateError" class="text-danger"></small>
                            </div>

                            @if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin'))

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Course<span class="text-danger ml-1">*</span></label>
                                    <select id="course" class="form-select">
                                        <option value="">--- Select Course ---</option>
                                        @foreach ($courses as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->short_name }}-{{ $item->n_months }} Months - (
                                                {{ $item->branch->name }} )</option>
                                        @endforeach
                                    </select>
                                    <small id="courseError" class="text-danger"></small>
                                </div>
                            @else
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Course<span class="text-danger ml-1">*</span></label>
                                    <select id="course" class="form-select">
                                        <option value="">--- Select Course ---</option>
                                        @foreach ($courses as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->short_name }}-{{ $item->n_months }} Months</option>
                                        @endforeach
                                    </select>
                                    <small id="courseError" class="text-danger"></small>
                                </div>

                            @endif

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Shift<span class="text-danger ml-1">*</span></label>
                                <select id="shift" class="form-select">
                                    <option value="">--- Select Shift ---</option>
                                    @foreach ($shifts as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                <small id="shiftError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Fees<span class="text-danger ml-1">*</span></label>
                                <input type="number" class="form-control" id="fees" placeholder="Fees"
                                    value="{{ old('fees') }}">
                                <small id="feesError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Course Coordinator<span
                                        class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="coordinator"
                                    placeholder="Course Coordinator" value="{{ old('coordinator') }}">
                                <small id="coordinatorError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Course Advisor<span
                                        class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="advisor"
                                    placeholder="Course Advisor" value="{{ old('advisor') }}">
                                <small id="advisorError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Course Director<span
                                        class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="director"
                                    placeholder="Course Director" value="{{ old('director') }}">
                                <small id="directorError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lab Attendant<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="labAttendant"
                                    placeholder="Lab Attendant" value="{{ old('labAttendant') }}">
                                <small id="labAttendantError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Course Asset<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="courseAsset"
                                    placeholder="Course Asset" value="{{ old('courseAsset') }}">
                                <small id="courseAssetError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Cleaner<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="cleaner" placeholder="Cleaner"
                                    value="{{ old('cleaner') }}">
                                <small id="cleanerError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Guard<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="guard" placeholder="Guard"
                                    value="{{ old('guard') }}">
                                <small id="guardError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <img id="batchBanner" src="{{ asset('img/default.png') }}" alt="Banner"
                                    style="width: 80px" class="d-block">

                                <label class="form-label">Batch Banner<span class="text-danger ml-1">*</span></label>
                                <input id="banner"
                                    oninput="batchBanner.src=window.URL.createObjectURL(this.files[0])" type="file"
                                    class="form-control" required>
                                <small id="bannerError" class="text-danger"></small>
                            </div>

                            @if (auth()->user()->hasAnyRole(['Super Admin', 'Admin']))

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Instructors<span
                                            class="text-danger ml-1">*</span></label> <br>
                                    <select id="instructors" name="instructors[]" class="form-select" multiple
                                        style="width: 100%">
                                        @foreach ($instructors as $item)
                                            <option value="{{ $item->id }}">{{ $item->user->name }} (@foreach ($item->user->branches as $item)
                                                    {{ $item->name }}
                                                @endforeach)</option>
                                        @endforeach
                                    </select>
                                    <small id="instructorsError" class="text-danger"></small>
                                </div>
                            @else
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Instructors<span
                                            class="text-danger ml-1">*</span></label> <br>
                                    <select id="instructors" name="instructors[]" class="form-select" multiple
                                        style="width: 100%">
                                        @foreach ($instructors as $item)
                                            <option value="{{ $item->id }}">{{ $item->user->name }}</option>
                                        @endforeach
                                    </select>
                                    <small id="instructorsError" class="text-danger"></small>
                                </div>

                            @endif

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Gender<span class="text-danger ml-1">*</span></label> <br>
                                <select id="genders" name="genders[]" class="form-select" multiple
                                    style="width: 100%">
                                    @foreach ($genders as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                <small id="gendersError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Status<span class="text-danger ml-1">*</span></label>
                                <select id="status" class="form-select">
                                    <option value="">--- Select Status ---</option>
                                    @foreach ($batchStatuses as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                <small id="statusError" class="text-danger"></small>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button onclick="Save()" id="save-btn" class="btn btn-sm btn_green">Save Changes</button>
                    <button id="modal_close" class="btn btn-sm btn_dark" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $("#instructors").select2({
            placeholder: "Click here to select Instructors"
        });
        $("#genders").select2({
            placeholder: "Click here to select Genders"
        });

        async function Save() {
            try {

                let banner = document.getElementById('banner').files[0];
                const instructors = Array.from(document.getElementById('instructors').selectedOptions).map(option =>
                    option.value);
                const genders = Array.from(document.getElementById('genders').selectedOptions).map(option => option
                    .value);

                let formData = new FormData();
                formData.append('batch_no', $("#batchNo").val());
                formData.append('offer_date', $("#offerDate").val());
                formData.append('start_date', $("#startDate").val());
                formData.append('end_date', $("#endDate").val());
                formData.append('course_id', $("#course").val());
                formData.append('coordinator', $("#coordinator").val());
                formData.append('advisor', $("#advisor").val());
                formData.append('director', $("#director").val());
                formData.append('lab_attendant', $("#labAttendant").val());
                formData.append('course_asset', $("#courseAsset").val());
                formData.append('cleaner', $("#cleaner").val());
                formData.append('guard', $("#guard").val());
                formData.append('shift_id', $("#shift").val());
                formData.append('fees', $("#fees").val());
                formData.append('banner', banner);
                instructors.forEach((id) => formData.append('instructors[]', id));
                genders.forEach((id) => formData.append('genders[]', id));
                formData.append('batch_status_id', $("#status").val());

                const config = {
                    headers: {
                        'content-time': 'multipart/form-data'
                    }
                }

                let res = await axios.post('/batch-store', formData, config)

                if (res.status === 200) {
                    $("#modal_close").click();
                    document.getElementById("save-form").reset();
                    successToast(res.data['message']);
                    $('#batchNoError').text('');
                    $('#offerDateError').text('');
                    $('#startDateError').text('');
                    $('#endDateError').text('');
                    $('#courseError').text('');
                    $('#shiftError').text('');
                    $('#feesError').text('');
                    $('#coordinatorError').text('');
                    $('#advisorError').text('');
                    $('#directorError').text('');
                    $('#labAttendantError').text('');
                    $('#courseAssetError').text('');
                    $('#cleanerError').text('');
                    $('#guardError').text('');
                    $('#bannerError').text('');
                    $('#instructorsError').text('');
                    $('#gendersError').text('');
                    $('#statusError').text('');
                    await getList()
                } else {
                    errorToast(res.data['message']);
                }

            } catch (error) {
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    $('#batchNoError').text(errors.batch_no ? errors.batch_no[0] : '');
                    $('#offerDateError').text(errors.offer_date ? errors.offer_date[0] : '');
                    $('#startDateError').text(errors.start_date ? errors.start_date[0] : '');
                    $('#endDateError').text(errors.end_date ? errors.end_date[0] : '');
                    $('#courseError').text(errors.course_id ? errors.course_id[0] : '');
                    $('#shiftError').text(errors.shift_id ? errors.shift_id[0] : '');
                    $('#feesError').text(errors.fees ? errors.fees[0] : '');
                    $('#coordinatorError').text(errors.coordinator ? errors.coordinator[0] : '');
                    $('#advisorError').text(errors.advisor ? errors.advisor[0] : '');
                    $('#directorError').text(errors.director ? errors.director[0] : '');
                    $('#labAttendantError').text(errors.lab_attendant ? errors.lab_attendant[0] : '');
                    $('#courseAssetError').text(errors.course_asset ? errors.course_asset[0] : '');
                    $('#cleanerError').text(errors.cleaner ? errors.cleaner[0] : '');
                    $('#guardError').text(errors.guard ? errors.guard[0] : '');
                    $('#bannerError').text(errors.banner ? errors.banner[0] : '');
                    $('#instructorsError').text(errors.instructors ? errors.instructors[0] : '');
                    $('#gendersError').text(errors.genders ? errors.genders[0] : '');
                    $('#statusError').text(errors.batch_status_id ? errors.batch_status_id[0] : '');
                } else {
                    errorToast(error.response.data['message']);
                }
            }

        }
    </script>
@endpush
