<div class="container-fluid admin_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between pt-4">
                    <div class="align-items-center col">
                        <h4>All Leave Applications</h4>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">

                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                </th>
                                <th class="bg-secondary text-white">Apply Date</th>
                                <th class="bg-secondary text-white">Start Date</th>
                                <th class="bg-secondary text-white">End Date</th>
                                <th class="bg-secondary text-white">Type</th>
                                <th class="bg-secondary text-white">Reason</th>
                                <th class="bg-secondary text-white">Status</th>
                                <th class="bg-secondary text-white">Signature</th>
                                @can(['edit-leave-application'])
                                    <th class="bg-secondary text-white">Action</th>
                                @endcan
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
                let res = await axios.get("/admin/leave-application/list");
                //    hideLoader();

                let tableList = $("#tableList");
                let myTable = $("#myTable");

                myTable.DataTable().destroy();
                tableList.empty();

                res.data.data.forEach(function (item, index) {
                    let statusBadge;
                    if (item.status === 'pending') {
                        statusBadge = '<span class="badge bg-primary">pending</span>';
                    } else if (item.status === 'approved') {
                        statusBadge = '<span class="badge bg-success">approved</span>';
                    } else {
                        statusBadge = `<span class="badge bg-danger">${item.status}</span>`;
                    }
                    let row = `<tr>
                                        <td>${item.apply_date}</td>
                                        <td>${item.start_date}</td>
                                        <td>${item.end_date}</td>
                                        <td>${item.type}</td>
                                        <td>${item.reason}</td>
                                        <td>${statusBadge}</td>
                                        <td>
                                            <img src="{{asset('${item.signature}')}}" style="width:100px; height:auto;" alt="Digital Signature">
                                        </td>
                                        @can(['edit-leave-application'])
                                                <td class="action">
                                                <div class="dropdown d-xl-none">
                                                    <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        @can('edit-leave-application')
                                                            <li><button data-id="${item.id}" class="text-success editBtn dropdown-item">Edit</button></li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                                @can('edit-leave-application')
                                                    <button data-id="${item.id}" class="d-none d-xl-inline-block btn btn-sm editBtn btn-sm btn-outline-success"><i class="fa fa-edit"></i></button>
                                                @endcan
                                            </td>
                                        @endcan
                                    </tr>`
                    tableList.append(row)
                })

                $('.editBtn').on('click', async function () {
                    let id = $(this).data('id');
                    await FillUpUpdateForm(id);
                    $("#update_modal").modal('show');
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
                            title: 'leave-applications List',
                            text: '<i class="fa fa-copy"></i>',
                            titleAttr: 'Copy',
                            className: 'btn btn-sm btn-outline-primary'
                        },
                        {
                            extend: 'excelHtml5',
                            title: 'leave-applications List',
                            text: '<i class="fa fa-file-excel"></i>',
                            titleAttr: 'Excel',
                            className: 'btn btn-sm btn-outline-success'
                        },
                        {
                            extend: 'print',
                            title: 'leave-applications List',
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