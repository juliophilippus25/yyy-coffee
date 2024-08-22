@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <section>
        <div class="card shadow mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="text-primary">Manage Products</h3>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal"><i
                        class="ti ti-plus"></i>
                    Product</button>
            </div>
            <div class="card-body">
                <table class="table table-hover table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th class="col-md-1">No</th>
                            <th class="col-md-5">Name</th>
                            <th class="col-md-4">Category</th>
                            <th class="col-md-2">Action</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>

        {{-- Add Modal --}}
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="#" method="POST" id="add_product_form" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name <b style="color:Tomato;">*</b></label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Enter the product name">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category <b
                                            style="color:Tomato;">*</b></label>
                                    <select class="form-select" aria-label="Default select example" name="category_id">
                                        <option hidden disabled selected value>Select a category product</option>
                                        @foreach ($category as $data)
                                            <option value="{{ $data->id }}">
                                                {{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description <b
                                            style="color:Tomato;">*</b></label>
                                    <textarea class="form-control" name="description" id="description" rows="3"
                                        placeholder="Enter the product description"></textarea>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price <b style="color:Tomato;">*</b></label>
                                    <input type="text" class="form-control" name="price" id="price"
                                        placeholder="Enter the product price" onkeypress="return isNumberKey(event)">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Product
                                        Image</label>
                                    <div class="col-md-12">
                                        <div>
                                            <small style="color:Tomato;">
                                                <em>
                                                    Upload image in jpg/jpeg/png format and maximum image size
                                                    2mb
                                                </em>
                                            </small>
                                            <input class="form-control" type="file" id="imgInp" name="image"
                                                accept="image/*">
                                        </div>
                                    </div>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="add_product_btn" class="btn btn-primary">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Add Modal --}}

        {{-- Edit Modal --}}
        <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="#" method="POST" id="edit_product_form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" id="product_id">
                        <input type="hidden" name="product_image" id="product_image">
                        <div class="modal-body p-4 bg">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name <b style="color:Tomato;">*</b></label>
                                    <input type="text" class="form-control" name="name" id="show-name"
                                        placeholder="Enter the product name">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category <b
                                            style="color:Tomato;">*</b></label>
                                    <select class="form-select" aria-label="Default select example" name="category_id"
                                        id="category_id">
                                        <option hidden disabled selected value>Select a category product</option>
                                        @foreach ($category as $data)
                                            <option value="{{ $data->id }}">
                                                {{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description <b
                                            style="color:Tomato;">*</b></label>
                                    <textarea class="form-control" name="description" id="show-description" rows="3"
                                        placeholder="Enter the product description"></textarea>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price <b style="color:Tomato;">*</b></label>
                                    <input type="text" class="form-control" name="price" id="show-price"
                                        placeholder="Enter the product price" onkeypress="return isNumberKey(event)">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="profileImage" class="form-label">Product
                                        Image</label>
                                    <div class="mb-2" id="image"></div>
                                    <div class="col-md-12">
                                        <div>
                                            <small style="color:Tomato;">
                                                <em>
                                                    Upload image in jpg/jpeg/png format and maximum image size
                                                    2mb
                                                </em>
                                            </small>
                                            <input class="form-control" type="file" id="imgInp" name="image"
                                                accept="image/*">
                                        </div>
                                    </div>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="edit_product_btn" class="btn btn-primary">Update
                                Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Edit Modal --}}

        {{-- Show Modal --}}
        <div class="modal fade" id="showProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div>
                        <table class="table table-borderless table-striped">

                            <tbody>
                                <tr>
                                    <td class="fw-bold">Name</td>
                                    <td class="col-md-1">:</td>
                                    <td id="productName"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Category</td>
                                    <td class="col-md-1">:</td>
                                    <td id="productCategory"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Description</td>
                                    <td class="col-md-1">:</td>
                                    <td id="productDescription"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Price</td>
                                    <td class="col-md-1">:</td>
                                    <td id="productPrice"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Image</td>
                                    <td class="col-md-1">:</td>
                                    <td id="productImage"></td>
                                </tr>
                            </tbody>

                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Show Modal --}}

    </section>

@section('script')
    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }

        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverside: true,
                responsive: true,
                ajax: "{{ route('products.index') }}",
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'name',
                    name: 'name'
                }, {
                    data: 'category.name',
                    name: 'category.name'
                }, {
                    data: 'action',
                    name: 'action'
                }]
            });
        });


        $(function() {
            // add new product ajax request
            $("#add_product_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#add_product_btn").text('Adding...');
                $.ajax({
                    url: '{{ route('products.store') }}',
                    method: 'POST',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status == 200) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Product added successfully.'
                            });
                            $('#myTable').DataTable().ajax.reload();
                        }
                        $("#add_product_btn").text('Add product');
                        $("#add_product_form")[0].reset();
                        $("#addProductModal").modal('hide');
                        $('span.text-danger').text('');
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.errors;

                        $('span.text-danger').text('');

                        $.each(errors, function(key, value) {
                            $('#' + key).next('span.text-danger').text(value[0]);
                        });
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong!'
                        });
                        $("#add_product_btn").text('Add Product');
                    }
                });
            });

            // edit product ajax request
            $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('products.edit') }}',
                    method: 'GET',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $("#show-name").val(response.name);
                        $("#show-description").val(response.description);
                        $("#category_id").val(response.category_id);
                        $("#show-price").val(response.price);
                        $("#product_id").val(response.id);
                        if (response.image) {
                            $("#image").html(
                                `<img src="/storage/images/products/${response.image}" width="100" class="img-fluid img-thumbnail" alt="Product Image">`
                            );
                        } else {
                            $("#image").text('No image available');
                        }
                        $("#product_image").val(response.avatar);
                    }
                });
            });

            function formatIDR(amount) {
                var number = parseFloat(amount);
                if (isNaN(number)) {
                    return 'Rp 0';
                }
                return 'IDR ' + number.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            // show product ajax request
            $(document).on('click', '.showIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('products.show') }}',
                    method: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        $("#productName").text(response.name);
                        $("#productDescription").text(response.description);
                        $("#productCategory").text(response.category.name);
                        $('#productPrice').text(formatIDR(response.price));
                        if (response.image) {
                            $("#productImage").html(
                                `<img src="/storage/images/products/${response.image}" width="100" class="img-fluid img-thumbnail" alt="Product Image">`
                            );
                        } else {
                            $("#productImage").text('No image available');
                        }
                    }
                });
            });

            // update product ajax request
            $("#edit_product_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#edit_product_btn").text('Updating...');
                $.ajax({
                    url: '{{ route('products.update') }}',
                    method: 'POST',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status == 200) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Product updated successfully.'
                            });
                            $('#myTable').DataTable().ajax.reload();
                        }
                        $("#edit_product_btn").text('Update Product');
                        $("#edit_product_form")[0].reset();
                        $("#editProductModal").modal('hide');
                        $('span.text-danger').text('');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $('span.text-danger').text('');

                            $.each(errors, function(key, value) {
                                $('#edit_product_form input[name="' + key + '"]').next(
                                    'span.text-danger').text(value[0]);
                            });
                            Toast.fire({
                                icon: 'error',
                                title: 'Something went wrong!'
                            });

                        }
                        $("#edit_product_btn").text('Update Product');
                    }
                });
            });

            // delete product ajax request
            $(document).on('click', '.deleteIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'No',
                    confirmButtonColor: '#5D87FF',
                    cancelButtonColor: '#FA896B',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('products.delete') }}',
                            method: 'DELETE',
                            data: {
                                id: id,
                                _token: csrf
                            },
                            success: function(response) {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Product has been deleted.'
                                });
                                $('#myTable').DataTable().ajax.reload();
                            }
                        });
                    }
                })
            });

        });
    </script>
@endsection

@endsection
