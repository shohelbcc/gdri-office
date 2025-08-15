<div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Notice</h6>
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
                                <label class="form-label">Title<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="titleUpdate" placeholder="Title">
                                <small id="titleUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Details<span class="text-danger ml-1">*</span></label>
                                <textarea id="detailsUpdate" class="form-control"></textarea>
                                <small id="detailsUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Published At<span class="text-danger ml-1">*</span></label>
                                <input type="date" class="form-control" id="published_atUpdate" placeholder="Published At">
                                <small id="published_atUpdateError" class="text-danger"></small>
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
            $('#detailsUpdate').summernote({ height: 100 });
        });

    async function FillUpUpdateForm(id){
        try {

            $('#updateId').val(id);
            let res = await axios.post("/admin/notice/by-id",{id:id})
            let mrow = res.data.row

            $('#titleUpdate').val(mrow.title);
            $('#published_atUpdate').val(mrow.published_at ? mrow.published_at.substring(0, 10) : '');
            $('#detailsUpdate').summernote('code', mrow.details);
        }catch (e) {
            errorToast(e.response.data['message']);
        }
    }

    async function Update() {
        try {
            let formData = new FormData();
            formData.append('title', $("#titleUpdate").val());
            formData.append('published_at', $("#published_atUpdate").val());

            // Details
            let isEmptydetailsUpdate = $('#detailsUpdate').summernote('isEmpty');
            let detailsUpdateHtml = isEmptydetailsUpdate ? '' : $('#detailsUpdate').summernote('code');
            formData.append('details', detailsUpdateHtml);

            formData.append('updateId', $('#updateId').val())

            let res = await axios.post('/admin/notice/update',formData)

            if (res.status === 200) {
                $("#update_modal_close").click();
                document.getElementById("update_form").reset();
                $('#details').summernote('code', '');
                successToast(res.data['message']);
                $('#titleUpdateError').text('');
                $('#detailsUpdateError').text('');
                $('#published_atUpdateError').text('');
                await getList();
            } else {
                errorToast(res.data['message']);
            }

        } catch (error) {
            if (error.response.status === 422) {
                let errors = error.response.data.errors;
                $('#titleUpdateError').text(errors.title ? errors.title[0] : '');
                $('#detailsUpdateError').text(errors.details ? errors.details[0] : '');
                $('#published_atUpdateError').text(errors.published_at ? errors.published_at[0] : '');
            } else {
                errorToast(error.response.data['message']);
            }
        }


     }

</script>

@endpush
