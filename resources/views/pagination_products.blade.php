<table class="table table-bordered mt-4">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Thumbnail</th>
        <th scope="col">Name</th>
        <th scope="col">Title</th>
        <th scope="col">Price</th>
        <th scope="col">Action</th>
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
                        style="width: 50px; height: 40px; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    @else
                        <p>N/A</p>
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->title }}</td>
                <td>{{ $product->price }}</td>
                <td class="action_icon">
                    <a href="javascript:void(0);"
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#updateModal"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-title="{{ $product->title }}"
                        data-price="{{ $product->price }}"
                        data-image="{{ $product->image }}"
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
