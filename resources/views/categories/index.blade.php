@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <section>
        <div class="card shadow mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="text-primary">Manage Categories</h3>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal"><i
                        class="ti ti-plus"></i>
                    Category</button>
            </div>
            <div class="card-body">
                <table class="table table-hover table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th class="col-md-1">No</th>
                            <th class="col-md-9">Name</th>
                            <th class="col-md-2">Action</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>

        {{-- Add Modal --}}
        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="#" method="POST" id="add_category_form" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name <b style="color:Tomato;">*</b></label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Enter the category name">
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="add_category_btn" class="btn btn-primary">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Add Modal --}}

        {{-- Edit Modal --}}
        <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="#" method="POST" id="edit_category_form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category_id" id="category_id">
                        <div class="modal-body p-4 bg">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name <b style="color:Tomato;">*</b></label>
                                    <input type="text" class="form-control" name="name" id="show-name"
                                        placeholder="Enter the category name">
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="edit_category_btn" class="btn btn-primary">Update
                                Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Edit Modal --}}
    </section>

@section('script')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverside: true,
                responsive: true,
                ajax: "{{ route('categories.index') }}",
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'name',
                    name: 'name'
                }, {
                    data: 'action',
                    name: 'action'
                }]
            });
        });


        $(function() {
            // add new category ajax request
            $("#add_category_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#add_category_btn").text('Adding...');
                $.ajax({
                    url: '{{ route('categories.store') }}',
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
                                title: 'Category added successfully.'
                            });
                            $('#myTable').DataTable().ajax.reload();
                        }
                        $("#add_category_btn").text('Add category');
                        $("#add_category_form")[0].reset();
                        $("#addCategoryModal").modal('hide');
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
                        $("#add_category_btn").text('Add Category');
                    }
                });
            });

            // edit category ajax request
            $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('categories.edit') }}',
                    method: 'GET',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $("#show-name").val(response.name);
                        $("#category_id").val(response.id);
                    }
                });
            });

            // update category ajax request
            $("#edit_category_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#edit_category_btn").text('Updating...');
                $.ajax({
                    url: '{{ route('categories.update') }}',
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
                                title: 'Category updated successfully.'
                            });
                            $('#myTable').DataTable().ajax.reload();
                        }
                        $("#edit_category_btn").text('Update Category');
                        $("#edit_category_form")[0].reset();
                        $("#editCategoryModal").modal('hide');
                        $('span.text-danger').text('');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $('span.text-danger').text('');

                            $.each(errors, function(key, value) {
                                $('#edit_category_form input[name="' + key + '"]').next(
                                    'span.text-danger').text(value[0]);
                            });
                            Toast.fire({
                                icon: 'error',
                                title: 'Something went wrong!'
                            });

                        }
                        $("#edit_category_btn").text('Update Category');
                    }
                });
            });

            // delete category ajax request
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
                            url: '{{ route('categories.delete') }}',
                            method: 'DELETE',
                            data: {
                                id: id,
                                _token: csrf
                            },
                            success: function(response) {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Category has been deleted.'
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
