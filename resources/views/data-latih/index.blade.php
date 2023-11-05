@extends('layouts.app')

@section('title', 'Data Latih')

@section('content')
    {{-- add & import button --}}
    <div class="row mb-2">
        <div class="col-sm-12">
            <a href="{{ route('data-latih.import') }}" class="btn btn-primary">Import Data Latih</a>
        </div>
    </div>
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Open</th>
                <th>High</th>
                <th>Low</th>
                <th>Close</th>
                <th>Volume</th>
                <th>Market Cap</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_latih as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->open }}</td>
                    <td>{{ $item->high }}</td>
                    <td>{{ $item->low }}</td>
                    <td>{{ $item->close }}</td>
                    <td>{{ $item->volume }}</td>
                    <td>{{ $item->market_cap }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('js')
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

    </script>
@endsection