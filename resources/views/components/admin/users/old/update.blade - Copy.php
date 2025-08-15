<div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Class</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_form">
                    <div class="container">
                        <div class="row">

                            <input type="hidden" id="updateId">
                            <input type="hidden" id="filePath">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Batch Number<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="batchNoUpdate" placeholder="ICAP-01">
                                <small id="batchNoUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Offer Date<span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="offerDateUpdate" placeholder="yyyy-mm-dd">
                                <small id="offerDateUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date<span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="startDateUpdate" placeholder="yyyy-mm-dd">
                                <small id="startDateUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date<span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="endDateUpdate" placeholder="yyyy-mm-dd">
                                <small id="endDateUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Course<span class="text-danger ml-1">*</span></label>
                                <select id="courseUpdate" class="form-select">
                                    <option value="">--- Select Course ---</option>
                                    @foreach ($courses as $item)
                                        <option value="{{$item->id}}">{{$item->short_name}} - {{$item->n_months}} Months</option>
                                    @endforeach
                                </select>
                                <small id="courseUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Shift<span class="text-danger ml-1">*</span></label>
                                <select id="shiftUpdate" class="form-select">
                                    <option value="">--- Select Shift ---</option>
                                    @foreach ($shifts as $item)
                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                    @endforeach
                                </select>
                                <small id="shiftUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Fees<span class="text-danger ml-1">*</span></label>
                                <input type="number" class="form-control" id="feesUpdate" placeholder="Fees" value="{{ old('fees') }}">
                                <small id="feesUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Course Coordinator<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="coordinatorUpdate" placeholder="Course Coordinator">
                                <small id="coordinatorUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Course Advisor<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="advisorUpdate" placeholder="Course Advisor">
                                <small id="advisorUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Course Director<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="directorUpdate" placeholder="Course Director">
                                <small id="directorUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lab Attendant<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="labAttendantUpdate" placeholder="Lab Attendant">
                                <small id="labAttendantUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Course Asset<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="courseAssetUpdate" placeholder="Course Asset">
                                <small id="courseAssetUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Cleaner<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="c" placeholder="Cleaner">
                                <small id="courseAssetUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Guard<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="guardUpdate" placeholder="Guard">
                                <small id="guardUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <img id="oldBanner" src="{{ asset('img/default.png') }}" alt="Banner" style="width: 80px" class="d-block">

                                <label class="form-label">Batch Banner<span class="text-danger ml-1">*</span></label>
                                <input id="bannerUpdate" oninput="oldBanner.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" required>
                                <small id="bannerUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Instructors<span class="text-danger ml-1">*</span></label>
                                <select id="instructorsUpdate" name="instructorsUpdate[]" multiple style="width: 100%">

                                </select>
                                <small id="instructorsUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Genders<span class="text-danger ml-1">*</span></label>
                                <select id="gendersUpdate" name="gendersUpdate[]" class="form-select" multiple style="width: 100%">

                                </select>
                                <small id="gendersUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Status<span class="text-danger ml-1">*</span></label>
                                <select id="statusUpdate" class="form-select">
                                    <option value="">--- Select Status ---</option>
                                    @foreach ($batchStatuses as $item)
                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                    @endforeach
                                </select>
                                <small id="statusUpdateError" class="text-danger"></small>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button onclick="Update()" id="update-btn" class="btn btn-sm btn_green">Update</button>
                    <button id="update_modal_close" class="btn btn-sm btn_dark" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>




@push('scripts')
<script>

    $("#instructorsUpdate").select2();
    $("#gendersUpdate").select2();

    async function FillUpUpdateForm(id,filePath){
        try {

            $('#updateId').val(id);
            $('#filePath').val(filePath);
            document.getElementById('oldBanner').src = filePath;

            let res = await axios.post("/batch-by-id",{id:id})

            $('#batchNoUpdate').val(res.data.row.batch_no);
            $('#offerDateUpdate').val(res.data.row.offer_date);
            $('#startDateUpdate').val(res.data.row.start_date);
            $('#endDateUpdate').val(res.data.row.end_date);
            $('#coordinatorUpdate').val(res.data.row.coordinator);
            $('#advisorUpdate').val(res.data.row.advisor);
            $('#directorUpdate').val(res.data.row.director);
            $('#labAttendantUpdate').val(res.data.row.lab_attendant);
            $('#courseAssetUpdate').val(res.data.row.course_asset);
            $('#cleanerUpdate').val(res.data.row.cleaner);
            $('#guardUpdate').val(res.data.row.guard);
            $('#feesUpdate').val(res.data.row.fees);

            $('#shiftUpdate').val(res.data.shift.id);
            $('#courseUpdate').val(res.data.course.id);
            $('#statusUpdate').val(res.data.batchStatus.id);


            // Initialize an array to store instructor IDs
            let instructorIds = [];

            // Populate the instructorIds array
            res.data.batch.instructors.forEach(instructor => {
                instructorIds.push(instructor.id);
            });

            // Clear the dropdown before appending options
            $('#instructorsUpdate').empty();

            let instructorsAll = @json($instructors);
            // Populate the dropdown with instructors
            instructorsAll.forEach(instructor => {
                $('#instructorsUpdate').append(`
                    <option value="${instructor.id}" ${instructorIds.includes(instructor.id) ? 'selected' : ''}>
                        ${instructor.name}
                    </option>
                `);
            });


            // Initialize an array to store Gender IDs
            let genderIds = [];

            // Populate the genderIds array
            res.data.batch.genders.forEach(gender => {
                genderIds.push(gender.id);
            });

            // Clear the dropdown before appending options
            $('#gendersUpdate').empty();

            let gendersAll = @json($genders);
            // Populate the dropdown with genders
            gendersAll.forEach(gender => {
                $('#gendersUpdate').append(`
                    <option value="${gender.id}" ${genderIds.includes(gender.id) ? 'selected' : ''}>
                        ${gender.title}
                    </option>
                `);
            });

        }catch (e) {
            errorToast(e.response.data['message']);
        }
    }

    async function Update() {
        try {

            let banner = document.getElementById('banner').files[0];
            const instructors = Array.from(document.getElementById('instructorsUpdate').selectedOptions).map(option => option.value);
            const genders = Array.from(document.getElementById('gendersUpdate').selectedOptions).map(option => option.value);

            let formData = new FormData();
            formData.append('batch_no', $("#batchNoUpdate").val());
            formData.append('offer_date', $("#offerDateUpdate").val());
            formData.append('start_date', $("#startDateUpdate").val());
            formData.append('end_date', $("#endDateUpdate").val());
            formData.append('course_id', $("#courseUpdate").val());
            formData.append('coordinator', $("#coordinatorUpdate").val());
            formData.append('advisor', $("#advisorUpdate").val());
            formData.append('director', $("#directorUpdate").val());
            formData.append('lab_attendant', $("#labAttendantUpdate").val());
            formData.append('course_asset', $("#courseAssetUpdate").val());
            formData.append('cleaner', $("#cleanerUpdate").val());
            formData.append('guard', $("#guardUpdate").val());
            formData.append('shift_id', $("#shiftUpdate").val());
            formData.append('fees', $("#feesUpdate").val());
            instructors.forEach((id) => formData.append('instructorsUpdate[]', id));
            genders.forEach((id) => formData.append('gendersUpdate[]', id));
            formData.append('batch_status_id', $("#statusUpdate").val());

            if (banner) {
                formData.append('banner',bannerUpdate);
            }

            formData.append('updateId', $('#updateId').val())
            formData.append('filePath', $('#filePath').val())

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            let res = await axios.post('/batch-update',formData,config)

            if (res.status === 200) {
                $("#update_modal_close").click();
                document.getElementById("update_form").reset();
                successToast(res.data['message']);
                $('#batchNoUpdateError').text('');
                $('#offerDateUpdateError').text('');
                $('#startDateUpdateError').text('');
                $('#endDateUpdateError').text('');
                $('#courseUpdateError').text('');
                $('#shiftUpdateError').text('');
                $('#feesUpdateError').text('');
                $('#coordinatorUpdateError').text('');
                $('#advisorUpdateError').text('');
                $('#directorUpdateError').text('');
                $('#labAttendantUpdateError').text('');
                $('#courseAssetUpdateError').text('');
                $('#cleanerUpdateError').text('');
                $('#guardUpdateError').text('');
                $('#bannerUpdateError').text('');
                $('#instructorsUpdateError').text('');
                $('#gendersUpdateError').text('');
                $('#statusUpdateError').text('');
                await getList();
            } else {
                errorToast(res.data['message']);
            }

        } catch (error) {
            if (error.response.status === 422) {
                let errors = error.response.data.errors;
                $('#batchNoUpdateError').text(errors.batch_no ? errors.batch_no[0] : '');
                $('#offerDateUpdateError').text(errors.offer_date ? errors.offer_date[0] : '');
                $('#startDateUpdateError').text(errors.start_date ? errors.start_date[0] : '');
                $('#endDateUpdateError').text(errors.end_date ? errors.end_date[0] : '');
                $('#courseUpdateError').text(errors.course_id ? errors.course_id[0] : '');
                $('#shiftUpdateError').text(errors.shift_id ? errors.shift_id[0] : '');
                $('#feesUpdateError').text(errors.fees ? errors.fees[0] : '');
                $('#coordinatorUpdateError').text(errors.coordinator ? errors.coordinator[0] : '');
                $('#advisorUpdateError').text(errors.advisor ? errors.advisor[0] : '');
                $('#directorUpdateError').text(errors.director ? errors.director[0] : '');
                $('#labAttendantUpdateError').text(errors.lab_attendant ? errors.lab_attendant[0] : '');
                $('#courseAssetUpdateError').text(errors.course_asset ? errors.course_asset[0] : '');
                $('#cleanerUpdateError').text(errors.cleaner ? errors.cleaner[0] : '');
                $('#guardUpdateError').text(errors.guard ? errors.guard[0] : '');
                $('#bannerUpdateError').text(errors.banner ? errors.banner[0] : '');
                $('#instructorsUpdateError').text(errors.instructors ? errors.instructors[0] : '');
                $('#gendersUpdateError').text(errors.genders ? errors.genders[0] : '');
                $('#statusUpdateError').text(errors.batch_status_id ? errors.batch_status_id[0] : '');
            } else {
                errorToast(error.response.data['message']);
            }
        }


     }

</script>

@endpush
