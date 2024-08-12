@extends('layouts.app')

@section('title', 'Categories')

@section('breadcrumb')
    <div class="ms-auto">
        <ol class="breadcrumb ms-end">
            <li class="breadcrumb-item active" aria-current="page">Categories</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Categories</h5>
            <div class="row">
                <div class="my-3 col-4">
                    <a href="#" class="btn btn-primary btn-fw col-md-12"><i class="ti ti-plus"></i> Category</a>
                </div>
            </div>
            <table id="myTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Action</th>
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
                serverSide: true,
                ajax: "{{ route('categories.index') }}",
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
                        data: 'action',
                        name: 'action'
                    },
                ],
            });
        });
    </script>
@endsection

@endsection
