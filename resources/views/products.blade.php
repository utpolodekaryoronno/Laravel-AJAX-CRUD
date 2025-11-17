<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ajax Crud</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .table tbody td.action_icon {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 15px;
            padding: 15px 12px;
            height: 100%;
        }
        .action_icon .btn{
            height: 30px;
            width: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFF;
        }
        .pagination .page-link {
            border: none;
            color: #333;
            margin: 0 3px;
            border-radius: 5px !important;
        }

        .pagination .page-item.active .page-link {
            background: #0d6efd;
            color: white;
            font-weight: bold;
        }

        .pagination .page-item.disabled .page-link {
            color: #aaa;
        }

        .table tbody th,
        .table tbody td {
            vertical-align: middle !important;
        }




    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05) !important;
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
    .btn-group .btn {
        border-radius: 8px !important;
    }
    .badge {
        font-weight: 600;
    }

    </style>
</head>
  <body>
        <section class="py-3 bg-light">
            <div class="container">
                <div class="row justify-content-center">


                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary mb-3">
                            <i class="las la-boxes me-2"></i>
                            Laravel AJAX CRUD System
                        </h2>
                        <p class="text-muted">Manage your products with live search, add, edit, view & delete</p>
                    </div>

                    <!-- Action Bar -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mb-2">
                        <button type="button" class="btn btn-primary btn-lg shadow-sm modal-btn" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="las la-plus-circle me-2"></i> Add New Product
                        </button>

                        <div class="position-relative">
                            <input type="text" id="search" class="form-control form-control-lg ps-5" placeholder="Search products..." style="width: 350px;">
                            <i class="las la-search position-absolute top-50 start-3 ps-3 translate-middle-y text-muted"></i>
                        </div>
                    </div>

                    <div class="product-table-main">
                        <table class="table table-bordered mt-4">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Thumbnail</th>
                                <th scope="col">Name</th>
                                <th scope="col">Title</th>
                                <th scope="col" class="text-center">Price</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product )

                                    <tr>
                                    <th>{{ $loop->iteration }}</th>
                                        <td>
                                            @if ($product->image)
                                                <img src="{{ asset('uploads/products/' .$product->image) }}" alt="{{ $product->name }}"
                                                class="rounded border"
                                                style="width: 45px; height: 36px; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                            @else
                                                <p>N/A</p>
                                            @endif
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td class="text-center"><span class="badge bg-success fs-6 px-3 py-2">{{ $product->price }} ৳</span></td>
                                        <td class="action_icon">
                                            <a href="javascript:void(0);"
                                                type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#updateModal"
                                                data-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}"
                                                data-title="{{ $product->title }}"
                                                data-price="{{ $product->price }}"
                                                class="btn btn-info update_product_form">
                                                <i class="las la-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);"
                                                data-id="{{ $product->id }}"
                                                data-url="{{ route('product.show', $product->id) }}"
                                                class="btn btn-success show_product">
                                                <i class="las la-eye"></i>
                                            </a>

                                            <a href="javascript:void(0);"
                                                data-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}"
                                                class="btn btn-danger delete_product">
                                                <i class="las la-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                        {{ $products->links() }}


                        <!-- Info Text -->
                        <div class="text-center mt-4 text-muted small">
                            <i class="las la-clock"></i> Last updated: {{ now()->format('d M, Y') }} |
                            Total Products: <strong>{{ $products->total() }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    {{-- <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">

                    <!-- Header -->
                    <div class="text-center mb-5">
                        <h2 class="fw-bold text-primary mb-3">
                            <i class="las la-boxes me-2"></i>
                            Laravel AJAX CRUD System
                        </h2>
                        <p class="text-muted">Manage your products with live search, add, edit, view & delete</p>
                    </div>

                    <!-- Action Bar -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mb-4">
                        <button type="button" class="btn btn-primary btn-lg shadow-sm modal-btn" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="las la-plus-circle me-2"></i> Add New Product
                        </button>

                        <div class="position-relative">
                            <input type="text" id="search" class="form-control form-control-lg ps-5" placeholder="Search products..." style="width: 350px;">
                            <i class="las la-search position-absolute top-50 start-3 translate-middle-y text-muted"></i>
                        </div>
                    </div>

                    <!-- Product Table Card -->
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden product-table-main">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        <tr>
                                            <th class="text-center fw-semibold" width="6%">#</th>
                                            <th width="12%">Thumbnail</th>
                                            <th width="25%">Product Name</th>
                                            <th width="25%">Title</th>
                                            <th class="text-center" width="12%">Price</th>
                                            <th class="text-end pe-4" width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($products as $product)
                                            <tr class="border-start border-3 border-primary">
                                                <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($product->image && file_exists(public_path('uploads/products/'.$product->image)))
                                                        <img src="{{ asset('uploads/products/'.$product->image) }}"
                                                            alt="{{ $product->name }}"
                                                            class="rounded-3 shadow-sm border"
                                                            style="width: 70px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted border"
                                                            style="width: 70px; height: 60px; font-size: 11px;">
                                                            No Image
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="fw-semibold">{{ Str::limit($product->name, 40) }}</td>
                                                <td class="text-muted">{{ Str::limit($product->title ?? 'N/A', 50) }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-success fs-6 px-3 py-2">
                                                        {{ number_format($product->price) }} ৳
                                                    </span>
                                                </td>
                                                <td class="text-end pe-3">
                                                    <div class="btn-group" role="group">

                                                        <!-- Edit -->
                                                        <button type="button"
                                                                class="btn btn-warning btn-sm shadow-sm update_product_form"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#updateModal"
                                                                data-id="{{ $product->id }}"
                                                                data-name="{{ $product->name }}"
                                                                data-title="{{ $product->title ?? '' }}"
                                                                data-price="{{ $product->price }}"
                                                                data-image="{{ $product->image ?? '' }}"
                                                                title="Edit">
                                                            <i class="las la-edit"></i>
                                                        </button>

                                                        <!-- View -->
                                                        <button type="button"
                                                                class="btn btn-info btn-sm shadow-sm show_product"
                                                                data-url="{{ route('product.show', $product->id) }}"
                                                                title="View">
                                                            <i class="las la-eye"></i>
                                                        </button>

                                                        <!-- Delete -->
                                                        <button type="button"
                                                                class="btn btn-danger btn-sm shadow-sm delete_product"
                                                                data-id="{{ $product->id }}"
                                                                data-name="{{ $product->name }}"
                                                                title="Delete">
                                                            <i class="las la-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-5 text-muted">
                                                    <i class="las la-inbox fs-1 mb-3 d-block"></i>
                                                    <h5>No products found</h5>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="card-footer bg-white border-top-0 py-4">
                                {{ $products->onEachSide(1)->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                    <!-- Info Text -->
                    <div class="text-center mt-4 text-muted small">
                        <i class="las la-clock"></i> Last updated: {{ now()->format('d M, Y h:i A') }} |
                        Total Products: <strong>{{ $products->total() }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}





    @include('add_product_modal')

    @include('update_product_modal')

    @include('show_product_modal')

    @include('product_js')


  </body>
</html>
