@extends('HeaderView')
@section('content')
    <div class="container">
        <form action="javascript:;" id="detailForm" class="form-data" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="document_no">Document No:</label>
            <input type="number" id="document_no" name="document_no" value="{{ $document_no }}" readonly><br><br>
            <label for="customer_name">Customer Name:</label>
            <input type="text" id="customer_name" name="customer_name" required><br><br>
            <label for="customer_email">Customer Email:</label>
            <input type="email" id="customer_email" name="customer_email" required><br><br>
            <label for="document_date">Document Date:</label>
            <input type="date" id="document_date" name="document_date" value="{{ date('Y-m-d') }}" required><br><br>
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Item Name</th>
                            <th>Qty</th>
                            <th>Store</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item => $value)
                            <tr>
                                <td>{{ $value['id'] }}</td>
                                <td id="store_name">{{ $value['store_name'] }}</td>
                                <td id="qty">{{ $value['qty'] }}</td>
                                <td>
                                    <button type="button" id="add-store" class="btn btn-info btn-lg" data-toggle="modal"
                                        data-target="#myModal">Add Store Details</button>
                                </td>
                                <td>
                                    <button type="button" id="add-row">Add Row</button>
                                    <button type="button" id="remove-row">Remove Row</button>
                                </td>
                            </tr>

                            {{-- modal --}}
                            <div class="modal" id="myModal" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Store Details</h4>
                                        </div>
                                        <div class="modal-body">
                                            <label for="store">Store:</label>
                                            <input type="text" id="store" name="store"><br><br>
                                            <label for="qty">Qty:</label>
                                            <input type="number" id="qty" name="qty"><br><br>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary"
                                                data-dismiss="modal">Save</button>
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{-- modal --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn-primary">Save</button>
        </form>

    </div>

    <script>
        $('#detailForm').submit(function() {
            console.log($('td [id="store_name"]'));

            let formArray = $(this).serializeArray();
            console.log($(this).serializeArray());
            $.ajax({
                type: 'POST',
                url: "{{ route('store.store') }}",
                data: formArray,
                success: function(res) {
                    console.log(res);
                    if (res.status) {
                        swal({
                            title: "Success!",
                            text: res.message,
                            icon: "success",
                        });

                        $('td [id="store_name"]').html(res.status.store_details.store_name);
                        $('td [id="qty"]').html(res.status.store_details.qty);
                    } else {
                        swal({
                            title: "Error!",
                            text: res.message,
                            icon: "error",
                        });
                    }
                }
            })
        });
    </script>
@endsection
