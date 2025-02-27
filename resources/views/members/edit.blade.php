@extends('members.layouts.app')

@section('content')
<div class="container">
    <h2>Edit Member</h2>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $member->name }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $member->email }}" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $member->phone }}" required>
        </div>

        <h5>Addresses</h5>
        @foreach ($member->addresses as $address)
            <div class="address-group mt-3">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="address_type_id">Address Type:</label>
                        <select class="form-select" name="address_type_id" required>
                            @foreach ($addressTypes as $type)
                                <option value="{{ $type->id }}" {{ $type->id == $address->address_type_id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="street">Street:</label>
                    <input class="form-control w-100" type="text" name="street" value="{{ $address->street }}" required>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="city">City:</label>
                        <input class="form-control" type="text" name="city" value="{{ $address->city }}" required>
                    </div>
        
                    <div class="mb-3 col-md-4">
                        <label for="state">State:</label>
                        <input class="form-control" type="text" name="state" value="{{ $address->state }}" required>
                    </div>
    
                    <div class="mb-3 col-md-4">
                        <label for="zip">Zip Code:</label>
                        <input class="form-control" type="text" name="zip" value="{{ $address->zip }}" maxlength="5" required>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="form-group">
            <label for="status">Member Status:</label>
            <select name="status" id="status" class="form-control">
                @foreach(\App\Models\Member::getStatuses() as $status)
                    <option value="{{ $status }}" {{ $member->status == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>
        

        <div class="my-3">
            <label>Profile Image</label>
            @if($profileImage->documents()->exists())
                @if ($profileImage = $profileImage->documents->first())
                    <div>
                        <img src="{{ asset('documents/' . $profileImage->file_path) }}" width="100">
                        <p>Current Profile Image</p>
                    </div>
                @endif
            @endif
            <input type="file" name="profile_image" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            @if (isset($proofOfAddress))
                @if ($proofOfAddress->documents()->exists())    
                    <label>Documents</label>
                    @foreach ($proofOfAddress->documents as $document)
                        <p><a href="{{ asset('documents/' . $document->file_path) }}" target="_blank">View Proof of Address</a></p>
                    @endforeach
                @endif
                <p>Current Proof of Address</p>
            @endif
            <input type="file" name="proof_of_address" class="form-control" accept=".pdf,image/*">
        </div>

        <button type="submit" class="btn btn-warning mb-2">Update</button>
    </form>
</div>
@endsection
