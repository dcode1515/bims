@extends('layout.template')
@section('content')
 <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col">

             @if(Auth::user()->barangay)

    <p>Region: {{ Auth::user()->barangay->region->region_name }}</p>
    <p>Province: {{ Auth::user()->barangay->province->province_name }}</p>
    <p>Municipality: {{ Auth::user()->barangay->municipality->municipality_name }}</p>
    <p>Barangay: {{ Auth::user()->barangay->barangay_name }}</p>

    {{-- Display the barangay logo --}}
    @if(Auth::user()->barangay->photo)
        <div>
            <img src="{{ asset('public/barangay/logo/' . Auth::user()->barangay->barangay_name . '/' . Auth::user()->barangay->photo) }}" 
                 alt="{{ Auth::user()->barangay->barangay_name }} Logo" 
                 style="max-width: 150px; height: auto; border: 1px solid #ccc; padding: 5px;">
        </div>
    @else
        <p>No logo uploaded.</p>
    @endif

@else
    <p>No barangay assigned.</p>
@endif

                         
                        
    </div>
                    </div>

                </div>
            </div>

 
@endsection