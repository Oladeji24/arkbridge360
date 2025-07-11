@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Top Referrers Leaderboard</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Referral Code</th>
                <th>Referrals</th>
                <th>Prize</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topReferrers as $i => $referrer)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $referrer['first_name'] ?? '' }} {{ $referrer['surname'] ?? '' }}</td>
                <td>{{ $referrer['referral_code'] }}</td>
                <td>{{ $referrer['referral_count'] ?? 0 }}</td>
                <td>
                    @if($i==0) 🥇 ₦2.5M
                    @elseif($i==1) 🥈 ₦1.5M
                    @elseif($i==2) 🥉 ₦1M
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
