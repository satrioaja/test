@extends('layouts.app')

@section('title', 'Pelatihan')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-12">
            <a href="{{ route('pelatihan.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i>
                Buat Model
            </a>
        </div>
    </div>
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>File Data Latih</th>
                <th>File Model</th>
                <th>Neuron</th>
                <th>Layer</th>
                <th>Learning Rate</th>
                <th>Epoch</th>
                <th>Batch Size</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pelatihan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->file_data_latih }}</td>
                    <td>{{ $item->file_model }}</td>
                    <td>{{ $item->neuron }}</td>
                    <td>{{ $item->layer }}</td>
                    <td>{{ $item->learning_rate }}</td>
                    <td>{{ $item->epoch }}</td>
                    <td>{{ $item->batch_size }}</td>
                    <td>
                        <form action="{{ route('pelatihan.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
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