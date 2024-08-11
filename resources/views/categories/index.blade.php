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
                <tbody>
                    @forelse ($categories as $category)
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>Button Action</td>
                    @empty
                        <tr class="">
                            <td colspan="16">
                                <strong class="text-dark">
                                    <center>No data avalaible.</center>
                                </strong>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
