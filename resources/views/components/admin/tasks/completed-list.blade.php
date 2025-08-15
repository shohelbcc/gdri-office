<div class="container-fluid admin_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between pt-4">
                    <div class="align-items-center col">
                        <h4>All Completed Task</h4>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">

                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th class="bg-secondary text-white" style="text-align: center; width: 10px !important;">#</th>
                                @can(['edit-admin-notice', 'delete-admin-notice'])
                                <th class="bg-secondary text-white">Action</th>
                                @endcan
                                <th class="bg-secondary text-white">Title</th>
                                <th class="bg-secondary text-white">Description</th>
                                <th class="bg-secondary text-white">Assigned Date</th>
                                <th class="bg-secondary text-white">Completed Date</th>
                                <th class="bg-secondary text-white">Priority</th>
                                <th class="bg-secondary text-white">Project</th>
                                <th class="bg-secondary text-white">Assigned To</th>
                                <th class="bg-secondary text-white">Assigned By</th>
                                <th class="bg-secondary text-white">Status</th>
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
                let res = await axios.get("/admin/task/list/completed");
                //    hideLoader();

                let tableList = $("#tableList");
                let myTable = $("#myTable");

                myTable.DataTable().destroy();
                tableList.empty();

                res.data.data.forEach(function (item, index) {
                    let assignees = item.assignees.map(user =>
                        `<span class="badge bg-primary me-1">${user.name})</span>`
                    ).join(' ');
                    let row = `<tr>
                                    <td style="text-align: center; width: 10px !important;">${++index}</td>
                                    @can(['edit-admin-notice', 'delete-admin-notice'])
                                        <td class="action">
                                        <div class="dropdown d-xl-none">
                                            <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                @can('delete-admin-notice')
                                                    <li><button data-id="${item.id}" class="text-danger deleteBtn dropdown-item">Delete</button></li>
                                                @endcan
                                            </ul>
                                        </div>
                                        @can('delete-admin-notice')
                                            <button data-id="${item.id}" class="d-none d-xl-inline-block btn btn-sm deleteBtn btn-sm btn-outline-danger mx-1"><i class="fa fa-trash"></i></button>
                                        @endcan
                                    </td>
                                    @endcan
                                    <td>${item.title}</td>
                                    <td>${item.description}</td>
                                    <td>${item.assigned_date}</td>
                                    <td>${item.completed_date ?? '-'}</td>
                                    <td>${item.priority}</td>
                                    <td>${item.project}</td>
                                    <td>${assignees}</td>
                                    <td>${item.assigner.name}</td>
                                    <td><span class="badge bg-success me-1">${item.status}</span></td>
                                </tr>`
                    tableList.append(row)
                })

                $('.deleteBtn').on('click', function () {
                    let id = $(this).data('id');
                    $("#delete_modal").modal('show');
                    $("#deleteId").val(id);
                })

                new DataTable('#myTable', {
                    order: [[0, 'desc']],
                    lengthMenu: [10, 15, 20, 30],
                    dom: `<"d-flex justify-content-between mb-2"
                                                        <"d-inline-flex align-items-center" f>
                                                        <"d-inline-flex align-items-center" l>
                                                        B
                                                    >
                                                    t
                                                    <"d-flex justify-content-between mt-2"<"info"i><"pagination"p>>
                                                    <"clear">`,
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            title: 'notices List',
                            text: '<i class="fa fa-copy"></i>',
                            titleAttr: 'Copy',
                            className: 'btn btn-sm btn-outline-primary'
                        },
                        {
                            extend: 'excelHtml5',
                            title: 'notices List',
                            text: '<i class="fa fa-file-excel"></i>',
                            titleAttr: 'Excel',
                            className: 'btn btn-sm btn-outline-success'
                        },
                        {
                            extend: 'print',
                            title: 'notices List',
                            text: '<i class="fa fa-print"></i>',
                            titleAttr: 'Print',
                            className: 'btn btn-sm btn-outline-warning'
                        }
                    ],
                    responsive: {
                        breakpoints: [
                            { name: 'desktop', width: Infinity },
                            { name: 'tablet', width: 1024 },
                            { name: 'phone', width: 480 }
                        ]
                    },
                });

            } catch (e) {
                unauthorized(e.response.status)
            }

        }


    </script>
@endpush