<div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Service</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_form">
                    <div class="container">
                        <div class="row">

                            <input type="hidden" id="updateId">

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Title <span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="titleUpdate" placeholder="Title" value="{{ old('title') }}">
                                <small id="titleUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description <span class="text-danger ml-1">*</span></label>
                                <textarea id="descriptionUpdate" class="form-control"></textarea>
                                <small id="descriptionUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="banner" class="form-label">Banner <span class="text-danger ml-1">*</span></label>
                                <div class="d-flex justify-content-center align-items-center bg-dark mb-1">
                                    <img id="bannerviewUpdate" src="{{ asset('images/default.png') }}" alt="Defauld Image" class="p-2 d-block" style="width: 150px; height: auto;">
                                </div>
                                <input name="bannerUpdate" oninput="bannerviewUpdate.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control">
                                <small id="bannerUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Status <span class="text-danger ml-1">*</span></label>
                                <select class="form-select" id="statusUpdate">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <small id="statusUpdateError" class="text-danger"></small>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button id="update_modal_close" class="btn btn-sm btn_dark" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Update()" id="update-btn" class="btn btn-sm btn_green">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>




@push('scripts')
<script>

        $(document).ready(function () {
            $('#descriptionUpdate').summernote({ height: 100 });
        });

    async function FillUpUpdateForm(id){
        try {

            $('#updateId').val(id);
            let res = await axios.post("/admin/services/by-id",{id:id})

            $('#titleUpdate').val(res.data.data.title);
            $('#descriptionUpdate').summernote('code', res.data.data.description);
            $('#bannerviewUpdate').attr('src', res.data.data.banner ? res.data.data.banner : '{{ asset("default.png") }}');
            $('#statusUpdate').val(res.data.data.status);
            $('#statusUpdate').trigger('change');
        }catch (e) {
            errorToast(e.response.data['message']);
        }
    }

    async function Update() {
        try {
            let formData = new FormData();
            formData.append('title', $("#titleUpdate").val());

            // Description
            let isEmptyDescription = $('#descriptionUpdate').summernote('isEmpty');
            let descriptionHtml = isEmptyDescription ? '' : $('#descriptionUpdate').summernote('code');
            formData.append('description', descriptionHtml);

            // Banner file (check if file selected)
            let bannerFile = $("input[name='bannerUpdate']").prop('files')[0];
            if (bannerFile) {
                formData.append('banner', bannerFile);
            }

            formData.append('status', $("#statusUpdate").val());
            formData.append('id', $('#updateId').val());

            let res = await axios.post('/admin/services/update', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });

            if (res.status === 200) {
                $("#update_modal").modal('hide');
                document.getElementById("update_form").reset();
                $('#descriptionUpdate').summernote('code', '');
                $('#bannerviewUpdate').attr('src', '{{ asset("images/default.png") }}');
                $('#titleUpdateError').text('');
                $('#descriptionUpdateError').text('');
                $('#bannerUpdateError').text('');
                $('#statusUpdateError').text('');
                successToast(res.data['message']);
                await getList();
            } else {
                errorToast(res.data['message']);
            }

        } catch (error) {
            if (error.response && error.response.status === 422) {
                let errors = error.response.data.errors;
                $('#titleUpdateError').text(errors.title ? errors.title[0] : '');
                $('#descriptionUpdateError').text(errors.description ? errors.description[0] : '');
                $('#bannerUpdateError').text(errors.banner ? errors.banner[0] : '');
                $('#statusUpdateError').text(errors.status ? errors.status[0] : '');
            } else {
                errorToast(error.response.data['message']);
            }
        }
     }

</script>

@endpush
