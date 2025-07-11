@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Referral History</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($referrals as $ref)
            <tr>
                <td>{{ $ref['first_name'] ?? $ref['full_name'] }}</td>
                <td>{{ $ref['email'] ?? '' }}</td>
                <td>{{ $ref['created_at'] ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
