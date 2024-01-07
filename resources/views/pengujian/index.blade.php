@extends('layouts.app')

@section('title', 'Pengujian')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-12">
            <a href="{{ route('pengujian.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i>
                Lakukan Pengujian
            </a>
        </div>
    </div>
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Model</th>
                <th>File Data Uji</th>
                <th>File Hasil</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengujian as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->pelatihan->file_model }}</td>
                    <td>{{ $item->file_data_uji }}</td>
                    <td>{{ $item->file_hasil }}</td>
                    <td>
                        <form action="{{ route('pengujian.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <a class="btn-sm btn btn-primary"
                                href="{{ route('pengujian.chart', $item->id) }}"><i class="fas fa-eye"></i></a>
                            <button class="btn btn-sm btn-danger b"
                                onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
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