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
        var isEditMode = false; // Flag to track whether the form is in Edit mode
        var editedId = null; // Variable to store the ID of the item being edited
        var isFormSubmitting = false; // Flag to track whether the form is currently being submitted

        function addPengiriman() {
            // Check if the form is already being submitted
            if (isFormSubmitting) {
                return;
            }

            var form = $('#addPengirimanForm');
            var addButton = $('#addPengirimanForm button');

            if (isEditMode) {
                // If in Edit mode, call updatePengiriman() instead of adding new data
                updatePengiriman(editedId);
                return;
            }

            // Set the flag to indicate that the form is being submitted
            isFormSubmitting = true;

            // Disable the button to prevent double submission
            addButton.prop('disabled', true);

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

                    // Enable the button after the operation is complete
                    addButton.prop('disabled', false);

                    // Reset the form submission flag
                    isFormSubmitting = false;

                    form[0].reset();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Failed to add Pengiriman. Please try again.');

                    // Enable the button in case of an error
                    addButton.prop('disabled', false);

                    // Reset the form submission flag
                    isFormSubmitting = false;
                }
            });
        }

        function editPengiriman(id) {
            // Check if the form is already being submitted
            if (isFormSubmitting) {
                return;
            }

            // Fetch data for the selected Pengiriman
            $.ajax({
                url: "{{ route('pengiriman.edit', ['id' => ':id']) }}".replace(':id', id),
                type: 'GET',
                success: function(response) {
                    // Populate the form fields
                    $('#lokasi').val(response.lokasi);
                    $('#estimasi').val(response.estimasi);

                    // Change button text to "Update"
                    $('#addPengirimanForm button').text('Update');
                    // Unbind previous click event and set a new one
                    $('#addPengirimanForm button').off('click').on('click', function() {
                        updatePengiriman(id);
                    });

                    // Set the flag to indicate Edit mode
                    isEditMode = true;
                    // Store the ID of the item being edited
                    editedId = id;
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Failed to fetch Pengiriman data. Please try again.');
                }
            });
        }

        function updatePengiriman(id) {
            // Check if the form is already being submitted
            if (isFormSubmitting) {
                return;
            }

            var form = $('#addPengirimanForm');
            var updateButton = $('#addPengirimanForm button');

            // Set the flag to indicate that the form is being submitted
            isFormSubmitting = true;

            // Disable the button to prevent double submission
            updateButton.prop('disabled', true);

            $.ajax({
                url: "{{ route('pengiriman.update', ['id' => ':id']) }}".replace(':id', id),
                method: "PUT",
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

                    // Reset the form after update
                    form[0].reset();
                    // Change button text to "Add"
                    $('#addPengirimanForm button').text('Add');
                    // Unbind previous click event and set a new one
                    $('#addPengirimanForm button').off('click').on('click', addPengiriman);

                    // Reset the flag and edited ID
                    isEditMode = false;
                    editedId = null;

                    // Enable the button after the operation is complete
                    updateButton.prop('disabled', false);

                    // Reset the form submission flag
                    isFormSubmitting = false;
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Failed to update Pengiriman. Please try again.');

                    // Enable the button in case of an error
                    updateButton.prop('disabled', false);

                    // Reset the form submission flag
                    isFormSubmitting = false;
                }
            });
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
