<div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update User</h6>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_form">
                    <div class="container">
                        <div class="row">

                            <input type="hidden" id="updateId">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="nameUpdate" placeholder="Name">
                                <small id="nameUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email<span class="text-danger ml-1">*</span></label>
                                <input type="email" class="form-control" id="emailUpdate" placeholder="Email">
                                <small id="emailUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone<span class="text-danger ml-1">*</span></label>
                                <input type="text" class="form-control" id="phoneUpdate" placeholder="Phone">
                                <small id="phoneUpdateError" class="text-danger"></small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password<span class="text-success ml-1">Optional</span></label>
                                <input type="password" class="form-control" id="passwordUpdate" placeholder="Password">
                                <small id="passwordUpdateError" class="text-danger"></small>
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

    async function FillUpUpdateForm(id){
        try {

            $('#updateId').val(id);
            let res = await axios.post("/admin/user/by-id",{id:id})

            $('#nameUpdate').val(res.data.row.name);
            $('#emailUpdate').val(res.data.row.email);
            $('#phoneUpdate').val(res.data.row.phone);
            $('#passwordUpdate').val(res.data.row.password);
        }catch (e) {
            errorToast(e.response.data['message']);
        }
    }

    async function Update() {
        try {
            let formData = new FormData();
            formData.append('name', $("#nameUpdate").val());
            formData.append('email', $("#emailUpdate").val());
            formData.append('phone', $("#phoneUpdate").val());
            formData.append('password', $("#passwordUpdate").val());

            formData.append('updateId', $('#updateId').val())

            // const config = {
            //     headers: {
            //         'content-type': 'multipart/form-data'
            //     }
            // }

            // let res = await axios.post('/batch-update',formData,config)
            let res = await axios.post('/admin/user/update',formData)

            if (res.status === 200) {
                $("#update_modal_close").click();
                document.getElementById("update_form").reset();
                successToast(res.data['message']);
                $('#nameUpdateError').text('');
                $('#emailUpdateError').text('');
                $('#phoneUpdateError').text('');
                $('#passwordUpdateError').text('');
                await getList();
            } else {
                errorToast(res.data['message']);
            }

        } catch (error) {
            if (error.response.status === 422) {
                let errors = error.response.data.errors;
                $('#nameUpdateError').text(errors.name ? errors.name[0] : '');
                $('#emailUpdateError').text(errors.email ? errors.email[0] : '');
                $('#phoneUpdateError').text(errors.phone ? errors.phone[0] : '');
                $('#passwordUpdateError').text(errors.password ? errors.password[0] : '');
            } else {
                errorToast(error.response.data['message']);
            }
        }


     }

</script>

@endpush
