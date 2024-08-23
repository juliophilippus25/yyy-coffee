@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
    <section>
        <div class="card shadow mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="text-primary">Manage Transactions</h3>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal"><i
                        class="ti ti-plus"></i>
                    Transaction</button>
            </div>
            <div class="card-body">
                <table class="table table-hover table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th class="col-md-5">Transaction</th>
                            <th class="col-md-5">Customer Name</th>
                            <th class="col-md-2">Action</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </section>

@section('script')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverside: true,
                responsive: true,
                ajax: "{{ route('transactions.index') }}",
                columns: [{
                    data: 'id',
                    name: 'id'
                }, {
                    data: 'name',
                    name: 'name'
                }, {
                    data: 'action',
                    name: 'action'
                }]
            });
        });
    </script>
@endsection

@endsection
