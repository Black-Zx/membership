<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\AddressType;
use App\Models\Document;
use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\StreamedResponse;

class MemberController extends Controller
{
    // Display a paginated list of members
    public function index(Request $request) {
        $query = Member::query();

        // Search functionality
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('referral_code', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
    

        $members = $query->paginate(5);

        return view('members.list', compact('members'));
    }

    // Show member registration form
    public function create(){
        $addressTypes = AddressType::all();

        $param=[
            'addressTypes' => $addressTypes
        ];
        
        return view('members.create', $param);
    }

    // Store a new member
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:members',
            'phone' => 'nullable',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'proof_of_address' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'referred_by' => 'nullable|exists:members,referral_code',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|string|max:20',
        ]);

        // Generate a unique referral code
        $referral_code = Str::random(8);

        if (isset($request->referred_by)) {
            $match = Member::where('referral_code', $request->referred_by)->first();
            $referred_by = $match->id;
        }

        $member = Member::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'referred_by' => $referred_by,
            'referral_code' => $referral_code,
        ]);

        $address = Address::create([
            'member_id' => $member->id,
            'address_type_id' => $request->address_type,
            'street' => $request->street,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
        ]);

        // Handle file uploads
        if ($request->hasFile('profile_image')) {
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $path = uniqid(). '.' .$extension;
            $request->file('profile_image')->move(public_path('documents/'), $path);
            
            Document::create([
                'file_path' => $path,
                'documentable_id' => $member->id,
                'documentable_type' => Member::class,
            ]);
        }

        if ($request->hasFile('proof_of_address')) {
            $extension = $request->file('proof_of_address')->getClientOriginalExtension();
            $path = uniqid(). '.' .$extension;
            $request->file('proof_of_address')->move(public_path('documents/'), $path);

            Document::create([
                'file_path' => $path,
                'documentable_id' => $address->id,
                'documentable_type' => Address::class,
            ]);
        }

        return redirect()->route('members.index')->with('success', 'Member registered successfully.');
    }

    // Show a specific member's details
    public function show(Member $member){
        $addresses = $member->addresses;

        $member_match = Member::find($member->id);
        if (isset($member_match)) {
            $profile_image = $member_match->documents; // Get all documents related to this address
        }

        $documents = Address::where('member_id', $member->id)->first();

        $params=[
            'member' => $member,
            'addresses' =>$addresses,
            'documents' =>$documents,
            'profile_image' =>$profile_image,
        ];
        return view('members.detail', $params);
    }

    // Show edit form
    public function edit(Member $member)
    {
        $profileImage = Member::find($member->id);   
        $proofOfAddress = Address::where('member_id', $member->id)->first();
        $addressTypes = AddressType::all();

        $params=[
            'member' => $member,
            'profileImage' => $profileImage,
            'proofOfAddress' => $proofOfAddress,
            'addressTypes' => $addressTypes,
        ];

        return view('members.edit', $params);
    }

    // Update member information
    public function update(Request $request, Member $member, Address $address)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'nullable',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|string|max:20',
            'status' => 'required|in:pending,approved,rejected,terminated',
        ]);

         // Update member details
        $member->update($request->only(['name', 'email', 'phone']));

        $member->addresses()->updateOrCreate(
            ['member_id' => $member->id],
            ['street' => $request->street, 'city' => $request->city, 'state' => $request->state, 'zip' => $request->zip, 'address_type_id' => $request->address_type_id],
        );

        // Handle file uploads
        if ($request->hasFile('profile_image')) {
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $path = uniqid(). '.' .$extension;
            $request->file('profile_image')->move(public_path('documents/'), $path);
            
            $member->documents()->updateOrCreate(
                ['documentable_id' => $member->id, 'documentable_type' => 'App\Models\Member'],
                ['file_path' => $path]
            );
        }

        if ($request->hasFile('proof_of_address')) {
            $extension = $request->file('proof_of_address')->getClientOriginalExtension();
            $path = uniqid(). '.' .$extension;
            $request->file('proof_of_address')->move(public_path('documents/'), $path);
            
            $member->documents()->updateOrCreate(
                ['documentable_id' => $address->id, 'documentable_type' => 'App\Models\Address'],
                ['file_path' => $path]
            );
        }

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    // Delete a member
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }

    public function export(Request $request)
    {
        $filename = "members.csv";
        $response = new StreamedResponse(function () use ($request) {
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, ['ID', 'Name', 'Phone', 'Email', 'Referral Code', 'Created At']);

            $query = Member::query();

            if ($request->has('search')) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('referral_code', 'like', '%' . $request->search . '%');
            }

            $members = $query->get();

            foreach ($members as $member) {
                fputcsv($handle, [
                    $member->id,
                    $member->name,
                    $member->phone,
                    $member->email,
                    $member->referral_code,
                    $member->created_at
                ]);
            }

            fclose($handle);
        });
        
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }

}
