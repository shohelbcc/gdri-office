<div class="container-fluid admin_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between pt-4">
                    <div class="align-items-center col">
                        <h4>All Notices</h4>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th class="bg-secondary text-white" style="text-align: center; width: 10px !important;">
                                    #</th>
                                <th class="bg-secondary text-white">Title</th>
                                <th class="bg-secondary text-white">Published At</th>
                                <th class="bg-secondary text-white">Action</th>
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
                // Use the correct endpoint that returns has_read
                let res = await axios.get("/employee/notice/list");

                let tableList = $("#tableList");
                let myTable = $("#myTable");

                myTable.DataTable().destroy();
                tableList.empty();

                res.data.data.forEach(function (item, index) {
                    let publishedDate = item.published_at ? item.published_at.substring(0, 10) : '';
                    let row = `<tr>
                        <td style="text-align: center; width: 10px !important;">${++index}</td>
                        <td>${item.title}</td>
                        <td>${item.has_read}</td>
                        <td>
                            ${!item.has_read
                                ? `<button class="btn btn-sm editBtn btn-success" data-id="${item.id}">Mark as read</button>`
                                : `<button class="btn btn-sm btn-danger" disabled>Read</button>`}
                            <button data-id="${item.id}" class="btn btn-sm showBtn btn-primary"><i class="fa fa-eye"></i></button>
                        </td>
                    </tr>`;
                    tableList.append(row);
                });

                $('.editBtn').on('click', async function () {
                    let id = $(this).data('id');
                    await FillUpUpdateForm(id)
                    $("#update_modal").modal('show');
                })

                $('.showBtn').on('click', async function () {
                    let id = $(this).data('id');
                    await FillUpInfoForm(id);
                    $("#info_modal").modal('show');
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
                            title: 'Users List',
                            text: '<i class="fa fa-copy"></i>',
                            titleAttr: 'Copy',
                            className: 'btn btn-sm btn-outline-primary'
                        },
                        {
                            extend: 'excelHtml5',
                            title: 'Users List',
                            text: '<i class="fa fa-file-excel"></i>',
                            titleAttr: 'Excel',
                            className: 'btn btn-sm btn-outline-success'
                        },
                        {
                            extend: 'print',
                            title: 'Users List',
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