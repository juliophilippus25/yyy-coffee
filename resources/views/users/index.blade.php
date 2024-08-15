@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <section>
        <div class="card shadow mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="text-primary">Manage Users</h3>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="ti ti-plus"></i>
                    User</button>
            </div>
            <div class="card-body">
                <table class="table table-hover table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th class="col-md-1">No</th>
                            <th class="col-md-3">Name</th>
                            <th>Phone</th>
                            <th class="col-md-3">Status</th>
                            <th class="col-md-2">Action</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>

        {{-- Add Modal --}}
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="#" method="POST" id="add_user_form" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Name<b style="color:Tomato;">*</b></label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                                <span class="text-danger"></span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="username" class="form-label">Username<b style="color:Tomato;">*</b></label>
                                <input type="text" class="form-control" name="username" id="username"
                                    placeholder="Username">
                                <span class="text-danger"></span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="phone" class="form-label">Phone<b style="color:Tomato;">*</b></label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone"
                                    onkeypress="return isNumberKey(event)">
                                <span class="text-danger"></span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password<b style="color:Tomato;">*</b></label>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Password">
                                <span class="text-danger"></span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="form-label">Confirmation Password<b
                                        style="color:Tomato;">*</b></label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="password_confirmation" placeholder="Confirmation Password">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="add_user_btn" class="btn btn-primary">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Add Modal --}}
    </section>

@section('script')
    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        function togglePassword() {
            var x = document.getElementById("password");
            var y = document.getElementById("password_confirmation");
            if (x.type === "password" && y.type === "password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }

        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverside: true,
                // responsive: true,
                ajax: "{{ route('users.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            // Menentukan kelas tombol berdasarkan status
                            var buttonClass = data === 'active' ? 'btn-success' : 'btn-danger';
                            var buttonText = data === 'active' ? 'Active' : 'Inactive';

                            // Menghasilkan tombol dengan kelas yang sesuai
                            var toggleStatusButton =
                                '<button class="btn btn-sm rounded-3 ' + buttonClass +
                                ' toggle-status" data-id="' +
                                row.id + '" data-status="' + data + '">' +
                                buttonText +
                                '</button>';
                            return toggleStatusButton;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
            });
        });

        $(function() {
            // add new user ajax request
            $("#add_user_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#add_user_btn").text('Adding...');
                $.ajax({
                    url: '{{ route('users.store') }}',
                    method: 'POST',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 200) {
                            Toast.fire({
                                icon: 'success',
                                title: 'User added successfully.'
                            });

                            $('#myTable').DataTable().ajax.reload();

                            $("#add_user_form")[0].reset();
                            $("#addUserModal").modal('hide');
                        }
                        $('span.text-danger').text('');
                        $("#add_user_btn").text('Add User');
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
                        $("#add_user_btn").text('Add User');
                    }
                });
            });

            // delete user ajax request
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
                            url: '{{ route('users.delete') }}',
                            method: 'DELETE',
                            data: {
                                id: id,
                                _token: csrf
                            },
                            success: function(response) {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'User has been deleted.'
                                });
                                $('#myTable').DataTable().ajax.reload();
                            }
                        });
                    }
                })
            });

            $(document).on('click', '.toggle-status', function() {
                var userId = $(this).data('id');
                var currentStatus = $(this).data('status');
                var newStatus = currentStatus === 'active' ? 'inactive' : 'active';

                $.ajax({
                    url: '{{ route('users.status') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: userId,
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            $('#myTable').DataTable().ajax.reload();
                            Toast.fire({
                                icon: 'success',
                                title: 'User status updated successfully.'
                            });
                        }
                    },
                    error: function(xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong!'
                        });
                    }
                });
            });
        });
    </script>
@endsection
@endsection
