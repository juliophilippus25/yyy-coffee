@extends('layouts.app')

@section('title', 'Payments')

@section('content')
    <section>
        <div class="card shadow mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="text-primary">Manage Payments</h3>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaymentModal"><i
                        class="ti ti-plus"></i>
                    Payment</button>
            </div>
            <div class="card-body">
                <table class="table table-hover table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th class="col-md-1">No</th>
                            <th class="col-md-4">Name</th>
                            <th class="col-md-2">Action</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>

        {{-- Add Modal --}}
        <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="#" method="POST" id="add_payment_form" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Payment Name <b
                                            style="color:Tomato;">*</b></label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Payment Name">
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="add_payment_btn" class="btn btn-primary">Add Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Add Modal --}}

        {{-- Edit Modal --}}
        <div class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="#" method="POST" id="edit_payment_form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="payment_id" id="payment_id">
                        <div class="modal-body p-4 bg">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Payment Name <b
                                            style="color:Tomato;">*</b></label>
                                    <input type="text" class="form-control" name="name" id="show-name"
                                        placeholder="Payment Name">
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="edit_payment_btn" class="btn btn-primary">Update
                                Payment</button>
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
                ajax: "{{ route('payments.index') }}",
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
            // add new payment ajax request
            $("#add_payment_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#add_payment_btn").text('Adding...');
                $.ajax({
                    url: '{{ route('payments.store') }}',
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
                                title: 'Payment added successfully.'
                            });
                            $('#myTable').DataTable().ajax.reload();
                        }
                        $("#add_payment_btn").text('Add payment');
                        $("#add_payment_form")[0].reset();
                        $("#addPaymentModal").modal('hide');
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
                        $("#add_payment_btn").text('Add Payment');
                    }
                });
            });

            // edit payment ajax request
            $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('payments.edit') }}',
                    method: 'GET',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $("#show-name").val(response.name);
                        $("#payment_id").val(response.id);
                    }
                });
            });

            // update payment ajax request
            $("#edit_payment_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#edit_payment_btn").text('Updating...');
                $.ajax({
                    url: '{{ route('payments.update') }}',
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
                                title: 'Payment updated successfully.'
                            });
                            $('#myTable').DataTable().ajax.reload();
                        }
                        $("#edit_payment_btn").text('Update Payment');
                        $("#edit_payment_form")[0].reset();
                        $("#editPaymentModal").modal('hide');
                        $('span.text-danger').text('');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $('span.text-danger').text('');

                            $.each(errors, function(key, value) {
                                $('#edit_payment_form input[name="' + key + '"]').next(
                                    'span.text-danger').text(value[0]);
                            });
                            Toast.fire({
                                icon: 'error',
                                title: 'Something went wrong!'
                            });

                        }
                        $("#edit_payment_btn").text('Update Payment');
                    }
                });
            });

            // delete payment ajax request
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
                            url: '{{ route('payments.delete') }}',
                            method: 'DELETE',
                            data: {
                                id: id,
                                _token: csrf
                            },
                            success: function(response) {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Payment has been deleted.'
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
