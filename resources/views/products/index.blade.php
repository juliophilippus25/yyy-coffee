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

    </section>

@endsection
