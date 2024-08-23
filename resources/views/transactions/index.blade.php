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
                            <th class="col-md-5">Date</th>
                            <th class="col-md-5">Customer Name</th>
                            <th class="col-md-2">Action</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>

        {{-- Add Modal --}}
        <div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Transaction</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="#" method="POST" id="add_transaction_form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id" value="{{ $userId }}">
                        <div class="modal-body p-4">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Customer Name <b
                                            style="color:Tomato;">*</b></label>
                                    <input type="text" class="form-control" name="customer_name" id="customer_name"
                                        placeholder="Enter the customer name">
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="add_transaction_btn" class="btn btn-primary">Add Transaction</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Add Modal --}}

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
                    data: 'created_at',
                    name: 'created_at'
                }, {
                    data: 'customer_name',
                    name: 'customer_name'
                }, {
                    data: 'action',
                    name: 'action'
                }]
            });
        });

        $(function() {
            // add new transaction ajax request
            $("#add_transaction_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#add_transaction_btn").text('Adding...');
                $.ajax({
                    url: '{{ route('transactions.store') }}',
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
                                title: 'Transaction added successfully.'
                            });
                            $('#myTable').DataTable().ajax.reload();
                        }
                        $("#add_transaction_btn").text('Add transaction');
                        $("#add_transaction_form")[0].reset();
                        $("#addTransactionModal").modal('hide');
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
                        $("#add_transaction_btn").text('Add Transaction');
                    }
                });
            });

            // delete transaction ajax request
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
                            url: '{{ route('transactions.delete') }}',
                            method: 'DELETE',
                            data: {
                                id: id,
                                _token: csrf
                            },
                            success: function(response) {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Transaction has been deleted.'
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
