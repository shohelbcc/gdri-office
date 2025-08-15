<div class="container-fluid admin_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>All Batch</h4>
                    </div>
                    <div class="align-items-center col">
                        <span id="createbtn">
                            @can('Create Batch')
                            <button type="button" data-bs-toggle="modal" data-bs-target="#create_modal" class="float-right btn btn-sm btn-secondary m-0">
                                <i class="fa fa-plus"></i>
                                Add New Batch
                            </button>
                            @endcan
                        </span>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">
                    <table class="table table-striped" id="tableData">
                        <thead>
                            <tr class="bg-light">
                                <th>#</th>
                                @if(auth()->user()->can('Update Batch') || auth()->user()->can('Delete Batch'))
                                <th>Action</th>
                                @endif
                                <th>Batch Name</th>
                                <th>Course Name</th>
                                @if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin'))
                                <th>Branch</th>
                                @endif
                                <th>Course Type</th>
                                <th>Course For Whom</th>
                                <th>Banner</th>
                                <th>Offer Date</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Instructors</th>
                                <th>Genders</th>
                                <th>Fees</th>
                                <th>Shift</th>
                                <th>Course Asset</th>
                                <th>Coordinator</th>
                                <th>Advisor</th>
                                <th>Director</th>
                                <th>Lab Attendant</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="tableList">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>

    getList();
async function getList() {

   try {
    //    showLoader();
       let res = await axios.get("/batch-list");
    //    hideLoader();

       let tableList = $("#tableList");
       let tableData = $("#tableData");

       tableData.DataTable().destroy();
       tableList.empty();

       res.data.data.forEach(function (item,index) {
           let row = `<tr>
                    <td>${ ++index }</td>
                    @if(auth()->user()->can('Update Batch') || auth()->user()->can('Delete Batch'))
                    <td>
                        @can('Update Batch')
                        <button data-id="${item.id}" data-path="${item.banner}" class="btn btn-sm editBtn btn-sm btn-outline-success m-1"><i class="fa fa-edit"></i></button>
                        @endcan
                        @can('Delete Batch')
                        <button data-id="${item.id}" data-path="${item.banner}" class="btn btn-sm deleteBtn btn-sm btn-outline-danger m-1"><i class="fa fa-trash"></i></button>
                        @endcan
                    </td>
                    @endif
                    <td>${item.batch_no}</td>
                    <td>${item.course?.short_name}</td>
                    @if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin'))
                    <td>${item.course?.branch?.name}</td>
                    @endif
                    <td>${item.course.category?.title}</td>
                    <td>${item.course.course_for_whom?.title}</td>
                    <td><img src="${item.banner}" alt="" style="width: 40px"></td>
                    <td>${item.offer_date}</td>
                    <td>${item.start_date}</td>
                    <td>${item.end_date}</td>
                    <td>${item.instructors.map(instructor => instructor.name).join(', ')}</td>
                    <td>${item.genders.map(gender => gender.title).join(', ')}</td>
                    <td>${item.fees}</td>
                    <td>${item.shift?.title}</td>
                    <td>${item.course_asset}</td>
                    <td>${item.coordinator}</td>
                    <td>${item.advisor}</td>
                    <td>${item.director}</td>
                    <td>${item.lab_attendant}</td>
                    <td>${item.batch_status?.title}</td>
                 </tr>`
           tableList.append(row)
    })

        $('.editBtn').on('click', async function () {
               let id = $(this).data('id');
               let filePath = $(this).data('path');
               await FillUpUpdateForm(id,filePath)
               $("#update_modal").modal('show');
           })

        $('.deleteBtn').on('click',function () {
            let id = $(this).data('id');
            let filePath = $(this).data('path');
            $("#delete_modal").modal('show');
            $("#deleteId").val(id);
            $("#deleteFilePath").val(filePath);
        })

       new DataTable('#tableData',{
           order:[[0,'desc']],
           lengthMenu:[10,15,20,30],
            responsive: {
                breakpoints: [
                    { name: 'desktop', width: Infinity },
                    { name: 'tablet', width: 1024 },
                    { name: 'phone', width: 480 }
                ]
            },
       });

   }catch (e) {
       unauthorized(e.response.status)
   }

}


</script>
@endpush
