@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="card shadow mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="text-primary">Manage Users</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal"><i class="ti ti-plus"></i>
                User</button>
        </div>
        <div class="card-body">
            <table class="table table-hover table-striped" id="myTable">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-6">Name</th>
                        <th class="col-md-3">Role</th>
                        <th class="col-md-2">Action</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>

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
                }, {
                    data: 'name',
                    name: 'name'
                }, {
                    data: 'roles',
                    name: 'roles'
                }, {
                    data: 'action',
                    name: 'action'
                }]
            });
        });
    </script>
@endsection
@endsection
