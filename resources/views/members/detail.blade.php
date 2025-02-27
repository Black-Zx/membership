@extends('members.layouts.app')

@section('content')
<div class="bg-dark me-md-3 p-3 p-md-5 text-white overflow-hidden">
    <div class="my-3 py-3 text-center">
        <h2>Member Details</h2>
    </div>

    <div class="bg-light shadow-sm mx-auto p-3 text-black" style="width: 80%; border-radius: 21px; ">
        <div class="row">
            <div class="col-md-9">
                <p><strong>Name:</strong> {{ $member->name }}</p>
                <p><strong>Email:</strong> {{ $member->email }}</p>
                <p><strong>Phone:</strong> {{ $member->phone }}</p>
                <p><strong>Referral Code:</strong> {{ $member->referral_code }}</p>
                <p><strong>Status:</strong> {{ $member->status }}</p>
                @foreach ($addresses as $address)
                    <p><strong>Address:</strong> {{ $address->street }}, {{ $address->city }}, {{ $address->state }}, {{ $address->zip }} </p>
                @endforeach
                <p><strong>Referral By:</strong>
                    <a href="" data-bs-toggle="modal" data-bs-target="#refferalByModal">
                        @if (isset($member->referrer))
                            {{ $member->referrer->name }}
                        @endif
                    </a> 
                </p>

                @if (isset($member->referrer))
                    <!-- Modal -->
                    <div class="modal fade" id="refferalByModal" tabindex="-1" aria-labelledby="refferalByModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="refferalByModalLabel">Referring Member`s
                                        Information</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Name:</strong> {{ $member->referrer->name }}</p>
                                    <p><strong>Email:</strong> {{ $member->referrer->email }}</p>
                                    <p><strong>Referral Code:</strong> {{ $member->referrer->referral_code }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
    
            <div class="col-md-3">
                @if (isset($profile_image))
                    @foreach ($profile_image as $image)
                        <img src="{{ asset('documents/' . $image->file_path) }}" alt="profile image" width="100%">
                    @endforeach
                @endif
            </div>
        </div>

        <div class="mt-5">
            @if (isset($documents))
                @if ($documents->documents()->exists())    
                    <h4>Documents</h4>
                    @foreach ($documents->documents as $document)
                        <p><a href="{{ asset('documents/' . $document->file_path) }}" target="_blank">View Document</a></p>
                    @endforeach
                @endif
            @endif
            
            <a href="{{ route('members.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
