@extends('members.layouts.app')

@section('content')
<div class="container">
    <h2>Member List</h2>
    
    <div class="d-flex flex-wrap align-items-center gap-3 my-3">
        <form method="GET" action="{{ route('members.index') }}" class="d-flex gap-2">
            <input type="text" name="search" placeholder="Search by name, email, referral code" value="{{ request('search') }}" class="form-control">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <form action="{{ route('export') }}" method="GET">
            <input type="text" name="search" placeholder="Search members..." value="{{ request('search') }}" hidden>
            <button type="submit" class="btn btn-success">Export CSV</button>
        </form>
        
        <form method="GET" action="{{ route('members.index') }}" class="w-25">
            <select name="status" class="form-control" onchange="this.form.submit()">
                <option value="all">All Statuses</option>
                @foreach(\App\Models\Member::getStatuses() as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>


    <table class="table table-hover">
        <thead class="border-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Referral Code</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->email }}</td>
                <td>{{ $member->referral_code }}</td>
                <td>
                    <span class="badge bg-{{ $member->status == 'approved' ? 'success' : ($member->status == 'pending' ? 'warning' : 'danger') }}">
                        {{ ucfirst($member->status) }}
                    </span>
                </td>
                <td class="d-flex flex-wrap align-items-center gap-2">
                    <a href="{{ route('members.show', $member->id) }}" class="btn btn-primary btn-sm">View</a>
                    <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form method="POST" action="{{ route('members.destroy', $member->id) }}" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $members->links() }}
</div>

@endsection
