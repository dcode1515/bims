<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Building Permit</title>
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
        word-break: break-word;
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
        margin-left: 290px;    /* Align signature as shown in image */
        margin-top: 100px;
    }
    
    .or-section {
        margin-top: 70px;
    }
    
    .bp-number {
        margin-left: 440px;
        margin-top: 10px;
    }
    
    .paragraph-text {
        font-size: 12pt;
        margin-left: 12px;
        text-align: justify;
        font-family: 'Bookman Old Style', serif;
        line-height: 1.6;
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

<!-- ================= HEADER ================= -->
<div class="header">
   @if(Auth::user()->barangay_info_id==1)
        <img style="width:113%; margin-top:-50px; margin-left:-50px;"
             src="{{ asset('public/images/logo/header_ubaldo.png') }}"
             alt="Barangay Header">
    @endif
</div>

<!-- ================= MAIN CONTENT ================= -->
<div class="content-container">

    <h2 style="text-align:center; font-size:24px; font-family:Elephant; margin-top: 20px; margin-bottom: 30px;">
        BUILDING PERMIT
    </h2>

    {{-- Watermark Logo --}}
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

    <p class="paragraph-text">
        This is to certify that 
        <b>
            @if($building_permit->requestor->sex === 'Male')
                Mr.
            @elseif($building_permit->requestor->sex === 'Female')
                Ms.
            @endif
            {{ $building_permit->requestor->first_name }}
            {{ $building_permit->requestor->middle_initial }}.
            {{ $building_permit->requestor->last_name }}
        </b>,
        of legal age, a resident of {{ Auth::user()->barangay->barangay_name }}, {{ Auth::user()->barangay->municipality->municipality_name }}, 
        has requested Barangay Clearance for the purpose of <b><u>{{ $building_permit->purpose }}</u></b> 
        situated at <b>{{ $building_permit->purok->purok_name }}</b>, {{ Auth::user()->barangay->barangay_name }}, {{ Auth::user()->barangay->municipality->municipality_name }}.
    </p>

    <p class="paragraph-text">
        After due verification and consideration, it is hereby certified that the said owner has complied 
        with all the pertinent requirements and regulations of {{ Auth::user()->barangay->barangay_name }}, {{ Auth::user()->barangay->municipality->municipality_name }}. 
        Furthermore, the applicant <b>{{ $building_permit->case }}</b> in this Barangay.
    </p>

    <p class="paragraph-text">
        This clearance is issued upon the request of the applicant for submission 
        to the <b>{{ $building_permit->requirements_building }}</b>.
    </p>

    @php
        $issuedDate = \Carbon\Carbon::parse($building_permit->date_issued);
    @endphp
    
    <p class="paragraph-text">
        Issued this <b>{{ $issuedDate->format('jS') }}</b> day of <b>{{ strtoupper($issuedDate->format('F')) }}
        {{ $issuedDate->format('Y') }}</b> at {{ Auth::user()->barangay->barangay_name }}, 
        {{ Auth::user()->barangay->municipality->municipality_name }}, {{ Auth::user()->barangay->province->province_name }}, Philippines.
    </p>

    <!-- Signature -->
    <div class="signature-section">
        <p style="margin:0; border-bottom:1px solid black; display:inline-block; font-size:14pt; font-family:'Bookman Old Style', serif;">
            @if($chairman)
                <strong>
                    {{ strtoupper("HON {$chairman->first_name} {$chairman->middle_initial}. {$chairman->last_name}, CSSP") }}
                </strong>
            @endif
        </p>
        <p style="margin:0; font-size:12pt; font-family:'Bookman Old Style', serif;">PUNONG BARANGAY</p>
    </div>

    <!-- Footer Signatures -->
    <div class="or-section blurred">
        O.R No. _______________<br>
        Date Issued: _______________<br>
        Doc. Stamp Paid
    </div>

    <div class="bp-number blurred">
        BP #: {{ $building_permit->building_permit_no }}
    </div>

    <br><br><br>
</div>

</body>
</html>