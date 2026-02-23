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
        background: white;
    }
    .blurred {
        filter: blur(4px);
        opacity: 0.7;
    }
    .officials-container {
        position: absolute;
        left: -5px;
        top: 80px;
        width: 180px;
        font-family: 'Bookman Old Style', serif;
        font-size: 8pt;
        line-height: 1.4;
        overflow-wrap: break-word;
        word-wrap: break-word;
        word-break: break-word;
    }
    .official-info {
        margin-bottom: 5px;
    }
    .committee {
        font-style: italic;
        font-size: 7.5pt;
    }
    
    /* Main content container with 2-space margins on both sides */
    .content-container {
        margin-left: 2em;      /* 2 spaces left margin */
        margin-right: 2em;     /* 2 spaces right margin */
        margin-top: 20px;
        position: relative;
        z-index: 1;
    }
    
    .signature-section {
        margin-left: 0;        /* Aligned left */
        margin-top: 40px;
    }
    
    .signature-official {
        margin-left: 320px;    /* Align official signature to the right */
        margin-top: 20px;
    }
    
    .or-section {
        margin-left: 0;        /* Aligned left */
        margin-top: 30px;
    }
    
    /* For the blurred O.R. section if needed on the right */
    .or-section-right {
        margin-left: 350px;    /* Alternative position on the right */
        margin-top: 30px;
    }
    
    @media print {
        .blurred {
            filter: blur(4px);
        }
        .content-container {
            margin-left: 2em;
            margin-right: 2em;
        }
    }
</style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    @if(Auth::user()->barangay_info_id==1)
        <img style="width:113%; margin-top:-50px; margin-left:-50px;"
             src="{{ asset('public/images/logo/header_ubaldo.png') }}"
             alt="Barangay Header">
    @endif
</div> 

<div class="content-container">
    <h2 style="text-align:center; margin-top: 20px; margin-bottom: 30px;">BARANGAY CLEARANCE</h2>

    @if(Auth::user()->barangay->photo)
        <div style="
            position: absolute;
            top: 25%; 
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.2;
            z-index: 0;
            pointer-events: none;
        ">
            <img src="{{ asset('public/barangay/logo/' . Auth::user()->barangay->barangay_name . '/' . Auth::user()->barangay->photo) }}" 
                 alt="{{ Auth::user()->barangay->barangay_name }} Logo" 
                 style="max-width: 550px; height: auto;">
        </div>
    @endif

    <p style="font-family:'Times New Roman', serif; font-size:14pt; margin-bottom: 25px;">TO WHOM IT MAY CONCERN:</p>

    <p style="font-size:12pt; line-height: 1.6; margin-bottom: 25px; text-align: justify;">
        This is to certify that <b>Mr./Ms./Mrs. {{$barangay_clearance->requestor->first_name}} {{$barangay_clearance->requestor->middle_initial}}. {{$barangay_clearance->requestor->last_name}},</b>
        {{ \Carbon\Carbon::parse($barangay_clearance->requestor->birthdate)->age }} years old, {{$barangay_clearance->requestor->civil_status}}, a native of {{$barangay_clearance->native}}, 
        and a resident of Zone/Purok {{$barangay_clearance->purok}}, @if(Auth::user()->barangay)@endif {{ Auth::user()->barangay->barangay_name }}, {{ Auth::user()->barangay->municipality->municipality_name }}.
    </p>

    <p style="font-size:12pt; margin-bottom: 20px;">
        This is to certify further that the above-mentioned person is known by this office and has the following:
    </p>

    <p style="font-size:12pt; margin-bottom: 10px;">Remarks:</p>
    
    <ul style="font-size:12pt; list-style:none; padding-left:20px; margin-bottom: 30px;">
        <li style="margin-bottom: 8px;">
            ({{ in_array('No Derogatory Record and is known of Good Moral Character', $barangay_clearance->character_status ?? []) ? '✓' : ' ' }}) 
            No Derogatory Record and is of Good Moral Character
        </li>
        <li style="margin-bottom: 8px;">
            ({{ in_array('Have Case Filed but Settled', $barangay_clearance->character_status ?? []) ? '✓' : ' ' }}) 
            Have Case Filed but Settled
        </li>
        <li style="margin-bottom: 8px;">
            ({{ in_array('Have Pending Case FILED', $barangay_clearance->character_status ?? []) ? '✓' : ' ' }}) 
            Have Pending Case FILED
        </li>
        <li style="margin-bottom: 8px;">
            ({{ in_array('Have Case Filed Withdrawn/Dismissed', $barangay_clearance->character_status ?? []) ? '✓' : ' ' }}) 
            Have Case Filed Withdrawn/Dismissed
        </li>
    </ul>

    <span style="font-size:12pt; margin-bottom: 20px;">
        Purpose: 
        <b>@if($barangay_clearance->purpose === 'Others')
            {{ $barangay_clearance->other_purpose }}
        @else
            {{ $barangay_clearance->purpose }}
        @endif</b>
    </span><br>

    <span style="font-size:12pt; margin-bottom: 40px;">
        Date Issued: <b>{{ \Carbon\Carbon::parse($barangay_clearance->date_issued)->format('M, d, Y') }}</b>
    </span>

    <div class="signature-section">
        <div style="margin-bottom: 5px;">__________________________</div>
        <div style="margin-bottom: 30px;">Signature above Printed Name</div>
    </div>
    
    <div class="signature-official">
        <p style="margin:0; border-bottom:1px solid black; display:inline-block; font-size:14pt;">
            @if($chairman)
            <strong>
                {{ strtoupper("HON {$chairman->first_name} {$chairman->middle_initial}. {$chairman->last_name}, CSSP") }}
            </strong>
            @endif
        </p>
        <p style="margin:0; font-size:12pt;">PUNONG BARANGAY</p>
    </div>
    
    <br><br>
    
    <div class="or-section blurred">
        <label>O.R No. _______________</label><br>
        <label>Date Issued: _______________</label><br>
        <label>Doc. Stamp Paid</label>
    </div>
    
    <br><br><br>
</div>

</body>
</html>