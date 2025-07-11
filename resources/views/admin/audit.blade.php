@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Audit Logs</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Timestamp</th>
                <th>User</th>
                <th>Action</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log['created_at'] ?? '' }}</td>
                <td>{{ $log['user_email'] ?? '' }}</td>
                <td>{{ $log['action'] ?? '' }}</td>
                <td>{{ $log['details'] ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
