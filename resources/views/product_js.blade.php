{{-- bootstrap js cdn --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
{{-- jquery cdn --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
{{-- toaster cdn --}}
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{{-- sweetalert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
    $(document).ready(function(){

        // Add Product
        $(document).on('click', '.add_product', function(e){
            e.preventDefault();
            // let name = $('#name').val();
            // let title = $('#title').val();
            // let price = $('#price').val();

             let formData = new FormData($('#addProductForm')[0]);


            $.ajax({
                url:"{{ route('add.product') }}",
                method:'POST',
                data: formData,
                processData: false,  // required for image uploading
                contentType: false,  // required for image uploading
                success:function(res){
                    if(res.status=="success"){
                        $('#addModal').modal('hide');
                        $('#addProductForm')[0].reset();
                        $('.errormessage').html('');
                        $('.product-table-main').load(location.href+' .product-table-main');

                        Command: toastr["success"]("Product Added Successfully", "Success");
                    }
                },
                error:function(err){
                    $('.errormessage').html('');
                    let errors = err.responseJSON.errors;
                    // Show only the first error
                    let firstError = Object.values(errors)[0][0];
                    $('.errormessage').append('<span class="text-danger">'+firstError+'</span>');
                }
            });
        });


        // Show Product value in update form
        $(document).on('click', '.update_product_form', function(){
            let id = $(this).data('id');
            let name = $(this).data('name');
            let title = $(this).data('title');
            let price = $(this).data('price');


            $('#up_id').val(id);
            $('#up_name').val(name);
            $('#up_title').val(title);
            $('#up_price').val(price);
        });



        // Update Product
        $(document).on('click', '.update_product', function(e){
            e.preventDefault();
            let up_id = $('#up_id').val();
            let up_name = $('#up_name').val();
            let up_title = $('#up_title').val();
            let up_price = $('#up_price').val();

            // console.log(name+title+price);

            $.ajax({
                url:"{{ route('update.product') }}",
                method:'PUT',
                data:{
                    up_id:up_id,
                    up_name:up_name,
                    up_title:up_title,
                    up_price:up_price,
                },
                success:function(res){
                    if(res.status=="success"){
                        $('#updateModal').modal('hide');
                        $('#updateProductForm')[0].reset();
                        $('.product-table-main').load(location.href+' .product-table-main');

                        // Toaster sms
                        Command: toastr["success"]("Product Updated Successfull", "Success")
                    }

                },
                error:function(err){
                    $('.errormessage').html('');
                    let errors = err.responseJSON.errors;
                    // Show only the first error
                    let firstError = Object.values(errors)[0][0];
                    $('.errormessage').append('<span class="text-danger">'+firstError+'</span>');
                }
            })
        });



        // Show Product
        $(document).on('click', '.show_product', function () {
            let url = $(this).data('url');

            $('#productShowModal').modal('show');
            $('#modal-body').html('<div class="text-center"><div class="spinner-border text-primary"></div></div>');

            $.ajax({
                url: url,
                type: 'GET',
                success: function (res) {
                    $('#modal-body').html(`
                        <img src="/uploads/products/${res.image || 'no-image.jpg'}" class="img-fluid rounded mb-3" style="max-height:200px;">
                        <h5 class="text-primary">${res.name}</h5>
                        <p><strong>Title:</strong> ${res.title || 'N/A'}</p>
                        <p><strong>Price:</strong> <span class="text-danger fs-5">${Number(res.price).toLocaleString()} ৳</span></p>

                    `);
                },
                error: function () {
                    $('#modal-body').html('<div class="text-danger">Failed to load product!</div>');
                }
            });
        });



        // Delete Product
        $(document).on('click', '.delete_product', function (e) {
            e.preventDefault();

            const productId   = $(this).data('id');
            const productName = $(this).data('name') || 'this product';

            Swal.fire({
                title: 'Are you sure?',
                text: `You want to delete "${productName}"? This cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {

                    Swal.fire({
                        title: 'Deleting...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ route('delete.product') }}",
                        method: 'DELETE',
                        data: {
                            product_id: productId
                        },
                        success: function (res) {
                            if (res.status === 'success') {
                                // Refresh only the table
                                $('.product-table-main').load(location.href + ' .product-table-main');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Product deleted successfully.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed!',
                                text: 'Something went wrong. Please try again.',
                            });
                        }
                    });
                }
            });
        });




        // Ajax Pagination
        $(document).on('click', '.pagination a', function(e){
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1]
            product(page)
        });

        function product(page){
            $.ajax({
                url:"/pagination/paginate-data?page="+page,
                success:function(res){
                    $('.product-table-main').html(res);
                }
            })
        }


        // Search Product
        $(document).on('keyup', function(e){
            e.preventDefault();
            let search_string = $('#search').val();
            // console.log(search_string);

            $.ajax({
                url: "{{ route('product.search') }}",
                method: 'GET',
                data: {search_string:search_string},
                success: function(res) {
                    // console.log(res.status);

                    // Assuming that the HTML content is in the 'res' variable
                    $('.product-table-main').html(res.html);

                    if(res.status=='nothing_found'){
                        $('.product-table-main').html('<span class="text-danger">'+'Nothing Found'+'</span>');
                    }
                }
            });

        });

    });
</script>
