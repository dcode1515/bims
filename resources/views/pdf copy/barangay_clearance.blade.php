<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Barangay Clearance</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: "Bookman Old Style", serif;
    }
    .blurred {
    filter: blur(4px); /* Adjust blur level (2px–6px) */
    opacity: 0.7;      /* Optional: makes it look lighter */
}
.officials-container {
    position: absolute;   /* keep it in fixed place */
    left: -5px;          /* adjust horizontal position */
    top: 80px;            /* adjust vertical start */
    width: 180px;         /* width of your text column */
    font-family: 'Bookman Old Style', serif;
    font-size: 8pt;
    line-height: 1.4;
    overflow-wrap: break-word;  /* wrap long text */
    word-wrap: break-word;      /* old browsers */
    word-break: break-word;     /* enforce breaking very long words */
}
.official-info {
    margin-bottom: 5px; /* spacing between officials */
}
.committee {
    font-style: italic;
    font-size: 7.5pt;  /* smaller if very long */
}

@media print {
    .blurred {
        filter: blur(4px);
    }
}

  
</style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    @if(Auth::user()->barangay_info_id==1)
    <img style="width: 120%; margin-top: -50px; margin-left: -50px;" src="{{ asset('public/barangay/header/ubaldo.png') }}" alt="Barangay Header">
    @endif

</div> 

 <!-- <div style="margin-left:90px; margin-top: -3px;" >
     <img style="width: 5%; height:50%;" src="{{ asset('public/barangay/header/line.jpg') }}" alt="Barangay Header">
</div> -->
<!-- LEFT SIDE OFFICIALS -->
 <!-- Vertical Line Separator -->
<div style="position:absolute; left:195px; top:80px; width:400px; height:1990px;">
      <img style="width: 5%; height:50%;" src="{{ asset('public/barangay/header/line.jpg') }}" alt="Barangay Header">
</div>
<div class="officials-container">
<div style="position:absolute; left:-20px; margin-top: -0px; font-family:'Bookman Old Style', serif; font-size:8pt; line-height:1.4;">

    <p style="font-weight:bold;">SANGGUNIANG BARANGAY</p>

    {{-- Barangay Chairman --}}
    @if($chairman)
        <p style="font-weight:bold; color: #800000;">
            {{ $chairman->first_name }} {{ $chairman->middle_initial }}. {{ $chairman->last_name }}
        </p>
        <p>{{ $chairman->position->position ?? 'Barangay Chairman' }}</p>

        {{-- Display committee if exists --}}
        @if($chairman->commitee)
            <p>{{ $chairman->commitee->commitee }}</p>
        @endif
    @else
        <p style="font-weight:bold;">No Chairman Found</p>
        <p>Barangay Chairman</p>
    @endif

    <br>
    <p style="font-weight:bold;">BARANGAY KAGAWAD</p>

    {{-- All Councilors --}}
    @foreach($councilors as $councilor)
        <p>
            <strong style="color: #800000;">{{ $councilor->first_name }} {{ $councilor->middle_initial }}. {{ $councilor->last_name }}</strong><br>

            {{-- Display committee if assigned --}}
            @if($councilor->commitee)
                {{ $councilor->commitee->commitee }}
            @else
                Committee not assigned
            @endif
        </p>
    @endforeach

    <br>

    {{-- Barangay Administrator --}}
    @if($barangay_administrator)
        <p>
            <strong style="color: #800000;">{{ $barangay_administrator->first_name }} {{ $barangay_administrator->middle_initial }}. {{ $barangay_administrator->last_name }}</strong><br>
            {{ $barangay_administrator->position->position ?? 'Barangay Administrator' }}

            @if($barangay_administrator->commitee)
                <br>{{ $barangay_administrator->commitee->commitee }}
            @endif
        </p>
        <br>
    @endif

    {{-- SK Chairman --}}
    @if($sk_chairman)
        <p>
            <strong style="color: #800000;">{{ $sk_chairman->first_name }} {{ $sk_chairman->middle_initial }}. {{ $sk_chairman->last_name }}</strong><br>
            {{ $sk_chairman->position->position ?? 'SK Chairman' }}

            @if($sk_chairman->commitee)
                <br>{{ $sk_chairman->commitee->commitee }}
            @endif
        </p>
        <br>
    @endif

    {{-- Barangay Secretary --}}
    @if($secretary)
        <p>
            <strong style="color: #800000;">{{ $secretary->first_name }} {{ $secretary->middle_initial }}. {{ $secretary->last_name }}</strong><br>
            {{ $secretary->position->position ?? 'Barangay Secretary' }}

            @if($secretary->commitee)
                <br>{{ $secretary->commitee->commitee }}
            @endif
        </p>
        <br>
    @endif

    {{-- Barangay Treasurer --}}
    @if($treasurer)
        <p>
            <strong style="color: #800000;">{{ $treasurer->first_name }} {{ $treasurer->middle_initial }}. {{ $treasurer->last_name }}</strong><br>
            {{ $treasurer->position->position ?? 'Barangay Treasurer' }}

            @if($treasurer->commitee)
                <br>{{ $treasurer->commitee->commitee }}
            @endif
        </p>
    @endif

    <p style="font-family:'Bookman Old Style', serif; font-size:8pt; margin-top: 100px;">
        NOT VALID WITHOUT SEAL
    </p>

</div>
</div>




 <div style="margin-left:230px; margin-right:35px;">
    <h2 style="text-align:center;  margin-top: -0px;">BARANGAY CLEARANCE</h2>

    @if(Auth::user()->barangay->photo)
        <div style="
            position: absolute;
            top: 30%; 
            left: 65%;
            transform: translate(-50%, -50%);
            opacity: 0.2;       /* Adjust opacity as needed */
            z-index: 0;         /* Make sure it stays behind text */
            pointer-events: none; /* So it doesn't block text selection */
        ">
            <img src="{{ asset('public/barangay/logo/' . Auth::user()->barangay->barangay_name . '/' . Auth::user()->barangay->photo) }}" 
                 alt="{{ Auth::user()->barangay->barangay_name }} Logo" 
                 style="max-width: 350px; height: auto;">
        </div>
    @endif

    <p style="font-family:'Times New Roman', serif; font-size:14pt;">TO WHOM IT MAY CONCERN:</p>

    <p style="font-size:12pt;">
        This is to certify that Mr./Ms./Mrs. {{$barangay_clearance->requestor->first_name}} {{$barangay_clearance->requestor->middle_initial}}. {{$barangay_clearance->requestor->last_name}},
        {{ \Carbon\Carbon::parse($barangay_clearance->requestor->birthdate)->age }} years old, {{$barangay_clearance->requestor->civil_status}}, a native of {{$barangay_clearance->native}}, 
        and a resident of Zone/Purok {{$barangay_clearance->purok}},  @if(Auth::user()->barangay )@endif {{ Auth::user()->barangay->barangay_name }}, {{ Auth::user()->barangay->municipality->municipality_name }}.
    </p>

    <p style="font-size:12pt;">
        This is to certify further that the above-mentioned person is known by this office and has the following:
    </p>

    <p style="font-size:12pt;">Remarks:</p>
  <ul style="font-size:12pt; list-style:none; padding-left:0;">

    <li>
        ({{ in_array('No Derogatory Record and is known of Good Moral Character', $barangay_clearance->character_status ?? []) ? '✓' : ' ' }}) 
        No Derogatory Record and is of Good Moral Character
    </li>

    <li>
        ({{ in_array('Have Case Filed but Settled', $barangay_clearance->character_status ?? []) ? '✓' : ' ' }}) 
        Have Case Filed but Settled
    </li>

    <li>
        ({{ in_array('Have Pending Case FILED', $barangay_clearance->character_status ?? []) ? '✓' : ' ' }}) 
        Have Pending Case FILED
    </li>

    <li>
        ({{ in_array('Have Case Filed Withdrawn/Dismissed', $barangay_clearance->character_status ?? []) ? '✓' : ' ' }}) 
        Have Case Filed Withdrawn/Dismissed
    </li>

</ul>


  <p style="font-size:12pt;">
    Purpose: 
    @if($barangay_clearance->purpose === 'Others')
        {{ $barangay_clearance->other_purpose }}
    @else
        {{ $barangay_clearance->purpose }}
    @endif
</p>


    <p style="font-size:12pt;">Date Issued: {{ \Carbon\Carbon::parse($barangay_clearance->date_issued)->format('M, d, Y') }}

</p>

    <div class="signature" style="font-size:12pt;">
        <p>__________________________</p>
        <p>Signature above Printed Name</p>
        <br><br>
       
    </div>
  <div style="margin-left:150px; margin-right:15px;" >
 <p style="margin:0; border-bottom:1px solid black; display:inline-block;" style="font-size:14pt;">
    @if($chairman)
    <strong>
        {{ strtoupper("HON {$chairman->first_name} {$chairman->middle_initial}. {$chairman->last_name}, CSSP") }}
    </strong>
@endif

</p>
<p style="margin:0;" style="font-size:12pt;">PUNONG BARANGAY</p>


</div><br><br><br><br>

   <div class="signature blurred" style="margin-right:250px; margin-right:15px;">
    <label>O.R No._______________</label><br>
    <label>Date Issued:______________</label><br>
    <label>Doc. Stamp Paid</label>
</div>

</div>

</body>
</html>
