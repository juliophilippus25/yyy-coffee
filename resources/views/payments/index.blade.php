@extends('layouts.app')

@section('title', 'Payments')

@section('content')
    <section>
        <div class="card shadow mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="text-primary">Manage Payments</h3>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal"><i
                        class="ti ti-plus"></i>
                    Payment</button>
            </div>
            <div class="card-body">
                <table class="table table-hover table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th class="col-md-1">No</th>
                            <th class="col-md-4">Name</th>
                            <th class="col-md-5">Description</th>
                            <th class="col-md-2">Action</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>

    </section>

@endsection
