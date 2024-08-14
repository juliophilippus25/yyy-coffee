@extends('layouts.app')

@section('title', 'Users')

@section('content')
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
                        <th class="col-md-6">Name</th>
                        <th class="col-md-3">Status</th>
                        <th class="col-md-2">Action</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" id="add_user_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="roles" id="roles" value="Staff">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name<b style="color:Tomato;">*</b></label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Username<b style="color:Tomato;">*</b></label>
                            <input type="text" class="form-control" name="username" id="username"
                                placeholder="Username">
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password<b style="color:Tomato;">*</b></label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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

@section('script')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverside: true,
                responsive: true,
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
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            // Menentukan kelas tombol berdasarkan status
                            var buttonClass = data === 'active' ? 'btn-success' : 'btn-danger';
                            var buttonText = data === 'active' ? 'Active' : 'Inactive';

                            // Menghasilkan tombol dengan kelas yang sesuai
                            var toggleStatusButton =
                                '<button class="btn btn-sm ' + buttonClass +
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
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 200) {
                            // Tampilkan notifikasi sukses
                            Toast.fire({
                                icon: 'success',
                                title: 'User saved successfully.'
                            });

                            // Reload data di tabel
                            $('#myTable').DataTable().ajax.reload();

                            // Reset form dan tutup modal
                            $("#add_user_form")[0].reset();
                            $("#addUserModal").modal('hide');
                        } else {
                            // Tangani jika ada status lain yang tidak diharapkan
                            Toast.fire({
                                icon: 'error',
                                title: 'Failed to save user.'
                            });
                        }
                        $("#add_user_btn").text('Add User');
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan pesan error jika request gagal
                        console.error(xhr.responseText);
                        ToastF.fire({
                            icon: 'error',
                            title: 'Something went wrong!'
                        });
                        $("#add_user_btn").text('Add User');
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
                            url: '{{ route('users.delete') }}',
                            method: 'delete',
                            data: {
                                id: id,
                                _token: csrf
                            },
                            success: function(response) {
                                console.log(response);
                                Toast.fire(
                                    'User has been deleted.'
                                )
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
                    url: '{{ route('users.status') }}', // Pastikan route ini ada di backend
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: userId,
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            $('#myTable').DataTable().ajax.reload(); // Reload tabel DataTables
                            Toast.fire({
                                icon: 'success',
                                title: 'User status updated successfully.'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log('An error occurred:', xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
@endsection
