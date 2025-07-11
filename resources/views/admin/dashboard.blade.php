@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Admin Dashboard</h2>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="display-6 fw-bold" id="totalUsers">{{ $totalUsers ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Paid Users</h5>
                    <p class="display-6 fw-bold text-success" id="paidUsers">{{ $paidUsers ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Referrals</h5>
                    <p class="display-6 fw-bold text-primary" id="totalReferrals">{{ $totalReferrals ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Conversion Rate</h5>
                    <p class="display-6 fw-bold text-info" id="conversionRate">{{ $conversionRate ?? 0 }}%</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Top Referrers</h5>
                    <ul class="list-group">
                        @foreach($topReferrers as $ref)
                        <li class="list-group-item">{{ $ref['first_name'] ?? $ref['full_name'] }} ({{ $ref['referral_count'] ?? 0 }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4">
        <h5>Registration Trend</h5>
        <canvas id="trendChart" height="100"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const trendLabels = {!! json_encode(array_keys($trend ?? [])) !!};
    const trendData = {!! json_encode(array_values($trend ?? [])) !!};
    const ctx = document.getElementById('trendChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: trendLabels,
            datasets: [{
                label: 'Registrations',
                data: trendData,
                borderColor: '#0056b3',
                backgroundColor: 'rgba(0,86,179,0.1)',
                fill: true,
            }]
        },
    });
    </script>
    <script>
function updateRealtimeDashboard() {
    fetch('/admin/realtime', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalUsers').textContent = data.totalUsers;
            document.getElementById('paidUsers').textContent = data.paidUsers;
            document.getElementById('totalReferrals').textContent = data.totalReferrals;
            document.getElementById('conversionRate').textContent = data.conversionRate + '%';
        });
}
setInterval(updateRealtimeDashboard, 60000); // update every minute
window.addEventListener('DOMContentLoaded', updateRealtimeDashboard);
</script>
    <a href="{{ route('admin.export') }}" class="btn btn-outline-primary mb-3">Export Users (CSV)</a>
    <form method="POST" action="{{ route('admin.notify') }}" class="mb-3 d-flex gap-2">
        @csrf
        <input type="email" name="email" class="form-control" placeholder="User Email" required>
        <input type="text" name="message" class="form-control" placeholder="Notification Message" required>
        <button type="submit" class="btn btn-info">Send Notification</button>
    </form>
    <form method="POST" action="{{ route('admin.push') }}" class="mb-3 d-flex gap-2">
        @csrf
        <input type="text" name="message" class="form-control" placeholder="Push Notification Message" required>
        <button type="submit" class="btn btn-warning">Send Push</button>
    </form>
    <form method="GET" action="{{ route('admin.report') }}" class="mb-3 d-flex gap-2">
        <select name="status" class="form-select" style="max-width:200px;">
            <option value="paid">Paid</option>
            <option value="pending">Pending</option>
            <option value="failed">Failed</option>
        </select>
        <button type="submit" class="btn btn-outline-info">Export Custom Report</button>
    </form>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Referral Code</th>
                <th>Payment Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <form method="POST" action="{{ route('admin.user.update') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user['id'] }}">
                    <td><input type="text" name="first_name" value="{{ $user['first_name'] ?? $user['full_name'] }}" class="form-control"></td>
                    <td><input type="email" name="email" value="{{ $user['email'] ?? '' }}" class="form-control"></td>
                    <td><input type="text" name="type" value="{{ $user['type'] ?? '' }}" class="form-control"></td>
                    <td><input type="text" name="referral_code" value="{{ $user['referral_code'] ?? '' }}" class="form-control"></td>
                    <td><input type="text" name="payment_status" value="{{ $user['payment_status'] ?? '' }}" class="form-control"></td>
                    <td>
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                        <form method="POST" action="{{ route('admin.impersonate') }}" style="display:inline;">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user['id'] }}">
                            <button type="submit" class="btn btn-sm btn-warning">Impersonate</button>
                        </form>
                    </td>
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if(session('status'))
        <div class="alert alert-success mt-3">{{ session('status') }}</div>
    @endif
</div>
@endsection
