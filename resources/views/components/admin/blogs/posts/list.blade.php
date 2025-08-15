<div class="container-fluid admin_page">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between pt-4">
                    <div class="align-items-center col">
                        <h4>All Posts</h4>
                    </div>
                    <div class="align-items-center col">
                        <span id="createbtn">
                            @can('create-admin-blog-post')
                                <button type="button" data-bs-toggle="modal" data-bs-target="#create_modal"
                                class="float-right btn btn-sm btn-success m-0">
                                <i class="fa fa-plus"></i>
                                Add New
                            </button>
                            @endcan
                        </span>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">

                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th class="bg-secondary text-white" style="text-align: center; width: 10px !important;">#</th>
                                @can(['edit-admin-blog-post', 'delete-admin-blog-post'])
                                <th class="bg-secondary text-white">Action</th>
                                @endcan
                                <th class="bg-secondary text-white">Post Title</th>
                                <th class="bg-secondary text-white">Featured Image</th>
                                <th class="bg-secondary text-white">Created By</th>
                                <th class="bg-secondary text-white">Category</th>
                                <th class="bg-secondary text-white">Authors</th>
                                <th class="bg-secondary text-white">Tags</th>
                                <th class="bg-secondary text-white">Status</th>
                                <th class="bg-secondary text-white">Published At</th>
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
                let res = await axios.get("/admin/blog/post/list");
                //    hideLoader();

                let tableList = $("#tableList");
                let myTable = $("#myTable");

                myTable.DataTable().destroy();
                tableList.empty();

                res.data.data.forEach(function (item, index) {
                    let authors = item.authors.map(a => `<span class='badge bg-primary me-1'>${a.name}</span>`).join(' ');
                    let tags = item.tags.map(t => `<span class='badge bg-primary me-1'>${t.name}</span>`).join(' ');
                    let row = `<tr>
                                    <td style="text-align: center; width: 10px !important;">${++index}</td>
                                    @can(['edit-admin-blog-post', 'delete-admin-blog-post'])
                                        <td class="action">
                                        <div class="dropdown d-xl-none">
                                            <a class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                @can('edit-admin-blog-post')
                                                    <li><button data-id="${item.id}" data-path="{{asset('${item.featured_image}')}}" class="text-success editBtn dropdown-item">Edit</button></li>
                                                @endcan
                                                @can('delete-admin-blog-post')
                                                    <li><button data-id="${item.id}" data-path="{{asset('${item.featured_image}')}}" class="text-danger deleteBtn dropdown-item">Delete</button></li>
                                                @endcan
                                            </ul>
                                        </div>
                                        @can('edit-admin-blog-post')
                                            <button data-id="${item.id}" data-path="{{asset('${item.featured_image}')}}" class="d-none d-xl-inline-block btn btn-sm editBtn btn-sm btn-outline-success"><i class="fa fa-edit"></i></button>
                                        @endcan
                                        @can('delete-admin-blog-post')
                                            <button data-id="${item.id}" data-path="{{asset('${item.featured_image}')}}" class="d-none d-xl-inline-block btn btn-sm deleteBtn btn-sm btn-outline-danger mx-1"><i class="fa fa-trash"></i></button>
                                        @endcan
                                    </td>
                                    @endcan
                                    <td>${item.title}</td>
                                    <td>
                                        <img src="{{asset('${item.featured_image}')}}" style="width:100px; height:auto;" alt="Digital Signature">
                                    </td>
                                    <td>${item.created_by.name}</td>
                                    <td>${item.blog_category.name}</td>
                                    <td>${authors}</td>
                                    <td>${tags}</td>
                                    <td><span class='badge ${item.status == 'published' ? 'bg-success' : 'bg-danger'} me-1'>${item.status}</span></td>
                                    <td>${item.published_at}</td>
                                </tr>`
                    tableList.append(row)
                })
                
                $('.editBtn').on('click', async function () {
                    let id = $(this).data('id');
                    let filePath = $(this).data('path');
                    await FillUpUpdateForm(id, filePath);
                    $("#update_modal").modal('show');
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