@extends('HeaderView')
@section('content')
    <div class="container">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Doc No</th>
                        <th>Doc Date</th>
                        <th>Customer Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item => $value)
                        <tr>
                            <td>{{ $value['doc_number'] }}</td>
                            <td>{{ $value['doc_date'] }}</td>
                            <td>{{ $value['name'] }}</td>
                            <td>
                                <button type="button">Edit</button>
                                <button type="button">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
