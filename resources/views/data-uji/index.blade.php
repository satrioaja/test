@extends('layouts.app')

@section('title', 'Data Uji')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-12">
            <select name="filter" id="filter" class="form-control">
                @foreach ($pengujian as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $filter ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
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
            @foreach ($data_uji as $item)
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

            $('#filter').on('change', function() {
                window.location.href = "{{ route('data-uji.index') }}?filter=" + $(this).val();
            });
        });

    </script>
@endsection