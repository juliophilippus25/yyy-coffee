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
                            <th class="col-md-5">Transaction Code</th>
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
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Transaction</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="#" method="POST" id="add_transaction_form" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4">
                            <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Customer Name <b
                                            style="color:Tomato;">*</b></label>
                                    <input type="text" class="form-control" name="customer_name" id="customer_name"
                                        placeholder="Enter the customer name">
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div></div>
                                        <button type="button" class="btn btn-outline-primary" onclick="openProductModal()">
                                            <i class="ti ti-plus"></i>
                                            Product</button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <table class="table" id="product-list">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Total Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dynamically added rows will appear here -->
                                        </tbody>
                                    </table>
                                    <div class="mt-3 d-none" id="total-amount-container">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div></div>
                                            <p>Total Amount Due: <span id="total-price"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="payment" class="form-label">Payment Method <b
                                            style="color:Tomato;">*</b></label>
                                    <select class="form-select" aria-label="Default select example" name="payment_id"
                                        id="payment_id">
                                        <option hidden disabled selected value>Select a payment method</option>
                                        @foreach ($payments as $payment)
                                            <option value="{{ $payment->id }}">
                                                {{ $payment->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="add_transaction_btn" class="btn btn-primary">Add
                                    Transaction</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Add Modal --}}

        <!-- Add Transaction_Product Modal -->
        <div class="modal fade" id="selectProductModal" tabindex="-1" aria-labelledby="selectProductLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="selectProductLabel">Select Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ formatIDR($product->price) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm select-product-btn"
                                                data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                                data-price="{{ $product->price }}" title="Add">
                                                <i class="ti ti-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">
                                            <center>No data available in table</center>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
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
                        data: 'transaction_code',
                        name: 'transaction_code'
                    }, {
                        data: 'customer_name',
                        name: 'customer_name'
                    }, {
                        data: 'action',
                        name: 'action'
                    }],
                    order: [
                        [0, 'desc']
                    ]
                });
            });

            function openProductModal() {
                // Show product modal without closing the main modal
                var selectProductModal = new bootstrap.Modal(document.getElementById('selectProductModal'));
                selectProductModal.show();
            }

            function formatIDR(amount) {
                var number = parseFloat(amount);
                if (isNaN(number)) {
                    return 'Rp 0';
                }
                return 'IDR ' + number.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            document.addEventListener('DOMContentLoaded', function() {
                // When the "Select" button is clicked
                document.querySelectorAll('.select-product-btn').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var productId = this.getAttribute('data-id');
                        var productName = this.getAttribute('data-name');
                        var productPrice = this.getAttribute('data-price');

                        // Check if the product is already in the table
                        if (document.querySelector(`#product-list [data-id="${productId}"]`)) {
                            Toast.fire({
                                icon: 'error',
                                title: 'Product already added.'
                            });
                            return;
                        }

                        // Add the product to the table in the main modal
                        var formattedPrice = formatIDR(productPrice);
                        var productRow = `<tr data-id="${productId}">
                                <td>${productName}</td>
                                <td><input type="number" class="form-control product-qty" data-price="${productPrice}" value="1" min="1"></td>
                                <td>${formattedPrice}</td>
                                <td><span class="product-total-price">${formattedPrice}</span></td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-product-btn" title="Delete"><i class="ti ti-trash"></i></button>
                                </td>
                              </tr>`;
                        document.querySelector('#product-list tbody').insertAdjacentHTML('beforeend',
                            productRow);

                        // Hide the product modal after selection
                        var selectProductModal = bootstrap.Modal.getInstance(document.getElementById(
                            'selectProductModal'));
                        selectProductModal.hide();

                        // Update the total price whenever the product quantity changes
                        updateTotalPrice();
                    });
                });

                // Function to update the total price when product quantity changes
                document.addEventListener('input', function(e) {
                    if (e.target && e.target.classList.contains('product-qty')) {
                        var qty = Math.max(1, e.target.value); // Ensure qty is not less than 1
                        var price = e.target.getAttribute('data-price');
                        e.target.value = qty; // Update input value
                        var totalPriceElement = e.target.closest('tr').querySelector('.product-total-price');
                        totalPriceElement.textContent = qty * price;
                        updateTotalPrice();
                    }
                });

                // Function to remove product from the list
                document.addEventListener('click', function(e) {
                    if (e.target && e.target.classList.contains('remove-product-btn')) {
                        e.target.closest('tr').remove();
                        updateTotalPrice();
                    }
                });

                // Function to update the total price and show/hide total amount
                function updateTotalPrice() {
                    var total = 0;
                    document.querySelectorAll('#product-list tbody tr:not(#no-data-row)').forEach(function(row) {
                        var quantityInput = row.querySelector('.product-qty');
                        var price = parseFloat(row.querySelector('td:nth-child(3)').textContent.replace(
                            /IDR\s|[.,]/g, ''));
                        var quantity = parseInt(quantityInput.value, 10);
                        var totalPriceCell = row.querySelector('.product-total-price');

                        var totalPrice = price * quantity;
                        totalPriceCell.textContent = formatIDR(totalPrice);

                        var totalAmountContainer = document.querySelector('#total-amount-container');
                        if (totalPrice > 0) {
                            totalAmountContainer.classList.remove('d-none');
                        } else {
                            totalAmountContainer.classList.add('d-none');
                        }

                        total += totalPrice;
                    });
                    document.getElementById('total-price').textContent = formatIDR(total);
                }

                // Submit form via AJAX
                $("#add_transaction_form").submit(function(e) {
                    e.preventDefault();

                    // Prepare form data
                    let formData = {
                        customer_name: $("#customer_name").val(),
                        payment_id: $("#payment_id").val(),
                        user_id: $("#user_id").val(),
                        products: []
                    };

                    // Collect product information from the UI
                    $("#product-list tbody tr").each(function() {
                        let productId = $(this).data('id');
                        let quantity = $(this).find('.product-qty').val();
                        let unitPrice = $(this).find('.product-qty').data('price');
                        let totalPrice = $(this).find('.product-total-price').text().trim();

                        formData.products.push({
                            id: productId,
                            quantity: parseInt(quantity),
                            unit_price: parseFloat(unitPrice),
                            total_price: parseFloat(totalPrice)
                        });
                    });

                    $("#add_transaction_btn").text('Adding...');
                    $.ajax({
                        url: '{{ route('transactions.store') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'application/json'
                        },
                        data: JSON.stringify(formData),
                        dataType: 'JSON',
                        success: function(response) {
                            if (response.status == 200) {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Transaction added successfully.'
                                });
                                $('#myTable').DataTable().ajax.reload();
                                $("#add_transaction_form")[0].reset();
                                $("#addTransactionModal").modal('hide');
                                $("#product-list tbody").html('');
                                $("#total-amount-container").html('');
                                $('span.text-danger').text('');
                            }
                            $("#add_transaction_btn").text('Add Transaction');
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

                // delete transaction_product ajax request
                $(document).on('click', '.deleteIcon', function(e) {
                    e.preventDefault();
                    let transactionCode = $(this).attr('transaction-code');
                    console.log('Transaction Code:', transactionCode); // Debug output
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
                                    transaction_code: transactionCode,
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
