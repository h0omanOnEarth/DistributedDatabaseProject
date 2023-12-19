@extends('layouts.main_admin')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

@section('manage_transactions')

<div class="container mt-5">
    <form action="{{ route('create.cronjob') }}" method="post">
        @csrf
        <h2>Time Picker Cron Job</h2>
        <div class="form-group">
            <label for="timePicker">Select Time:</label>
            <input type="time" class="form-control" id="timePicker" name="timePicker">
        </div>
        <div class="form-group">
            <label for="name_cronjob">Cron Job Name</label>
            <input type="text" class="form-control" id="name_cronjob" name="name_cronjob">
        </div>
        <div class="form-group">
            <button class="mt-3 btn btn-dark w-100" id="buttoncreate">Create</button>
        </div>
    </form>
</div>

<div class="row justify-content-center">
    <div class="col-sm-12">
        <h2>LIST CRONJOB</h2>
        <div class="table-responsive">
            <table class="table table-dark custom-table">
                <thead>
                    <tr>
                        <th scope="col">JOB_NAME</th>
                        <th scope="col">JOB_ACTION</th>
                        <th scope="col">START_DATE</th>
                        <th scope="col">REPEAT_INTERVAL</th>
                        <th scope="col">ENABLED</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($raw as $item)
                    <tr>
                        <td>{{ $item->job_name }}</td>
                        <td>{{ $item->job_action }}</td>
                        <td>{{ $item->start_date }}</td>
                        <td>{{ $item->repeat_interval }}</td>
                        <td>{{ $item->enabled }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js scripts (required for Bootstrap components) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Get the time picker element
    var timePicker = document.getElementById('timePicker');

    // Add an event listener for the 'change' event
    timePicker.addEventListener('change', function () {
        // Log the value to the console
        console.log('Selected Time:', timePicker.value);
    });
</script>
@endsection
