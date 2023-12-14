@extends('layouts.main_seller')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Pengiriman</h5>
                    <form id="addPengirimanForm">
                        @csrf
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Location</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                        </div>
                        <div class="mb-3">
                            <label for="estimasi" class="form-label">Estimasi (in days)</label>
                            <input type="number" class="form-control" id="estimasi" name="estimasi" required>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="addPengiriman()">Add</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pengiriman List</h5>
                    <table class="table" id="pengirimanTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Location</th>
                                <th>Estimasi</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengirimanData as $pengiriman)
                                <tr>
                                    <td>{{ $pengiriman->id }}</td>
                                    <td>{{ $pengiriman->lokasi }}</td>
                                    <td>{{ $pengiriman->estimasi }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary"
                                            onclick="editPengiriman({{ $pengiriman->id }})">Edit</button>
                                        <button type="button" class="btn btn-danger"
                                            onclick="deletePengiriman({{ $pengiriman->id }})">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addPengiriman() {
            var form = $('#addPengirimanForm');

            $.ajax({
                url: "{{ route('pengiriman.store') }}",
                method: "POST",
                data: form.serialize(),
                success: function(response) {
                    alert(response.success);

                    // Clear the table body
                    $('#pengirimanTable tbody').empty();

                    // Append the new data to the table
                    $.each(response.pengirimanData, function(index, pengiriman) {
                        var row = '<tr>' +
                            '<td>' + pengiriman.id + '</td>' +
                            '<td>' + pengiriman.lokasi + '</td>' +
                            '<td>' + pengiriman.estimasi + '</td>' +
                            '<td>' +
                            '<button type="button" class="btn btn-primary mr-2" onclick="editPengiriman(' +
                            pengiriman.id + ')">Edit</button>' +
                            '<button type="button" class="btn btn-danger" onclick="deletePengiriman(' +
                            pengiriman.id + ')">Delete</button>' +
                            '</td>' +
                            '</tr>';
                        $('#pengirimanTable tbody').append(row);
                    });

                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Failed to add Pengiriman. Please try again.');
                }
            });
        }


        function editPengiriman(id) {
            // Similar to addPengiriman, you can implement an edit function here
            // Fetch the data for the selected Pengiriman, populate the form, and handle the update
        }

        function deletePengiriman(id) {
            if (confirm("Are you sure you want to delete this Pengiriman?")) {
                $.ajax({
                    url: "{{ route('pengiriman.destroy', ['id' => ':id']) }}".replace(':id', id),
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        alert(response.success);
                        // Clear the table body
                        $('#pengirimanTable tbody').empty();

                        // Append the new data to the table
                        $.each(response.pengirimanData, function(index, pengiriman) {
                            var row = '<tr>' +
                                '<td>' + pengiriman.id + '</td>' +
                                '<td>' + pengiriman.lokasi + '</td>' +
                                '<td>' + pengiriman.estimasi + '</td>' +
                                '<td>' +
                                '<button type="button" class="btn btn-primary mr-2" onclick="editPengiriman(' +
                                pengiriman.id + ')">Edit</button>' +
                                '<button type="button" class="btn btn-danger" onclick="deletePengiriman(' +
                                pengiriman.id + ')">Delete</button>' +
                                '</td>' +
                                '</tr>';
                            $('#pengirimanTable tbody').append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('Failed to delete Pengiriman. Please try again.');
                    }
                });
            }
        }
    </script>
@endsection
