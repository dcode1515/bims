<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Certificate of Residency</title>
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
        z-index: 2;
    }
    
    /* Main content container with 2-space margins */
    .content-container {
        margin-left: 2em;
        margin-right: 2em;
        margin-top: 20px;
        position: relative;
        z-index: 1;
    }
    
    .signature-section {
        margin-left: 310px;
        margin-top: 100px;
    }
    
    .or-section {
        margin-top: 70px;
    }
    
    .paragraph-text {
        font-size: 12pt;
        margin-left: 12px;
        text-align: justify;
        font-family: 'Bookman Old Style', serif;
        line-height: 1.6;
    }
    
    .applicant-signature {
        font-size: 12pt;
        margin-top: 60px;
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
        CERTIFICATE OF RESIDENCY
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
            @if($residency_certificate->requestor->sex === 'Male')
                Mr.
            @elseif($residency_certificate->requestor->sex === 'Female')
                Ms./Mrs.
            @endif
            {{ $residency_certificate->requestor->first_name }}
            {{ $residency_certificate->requestor->middle_initial }}.
            {{ $residency_certificate->requestor->last_name }}
        </b>,
        {{ \Carbon\Carbon::parse($residency_certificate->requestor->birthdate)->age }} years old, 
        {{ strtolower($residency_certificate->requestor->civil_status) }}, Filipino citizen, 
        whose specimen signature appears below, is a <b>{{ strtoupper($residency_certificate->resident_type) }}</b> of this Barangay.
    </p>

    <p class="paragraph-text">
        Based on the records of this office, he/she has been residing at 
        <b>Purok {{ $residency_certificate->purok->purok_name }}</b>, 
        {{ Auth::user()->barangay->barangay_name }}, {{ Auth::user()->barangay->municipality->municipality_name }} 
        since <b>{{ \Carbon\Carbon::parse($residency_certificate->requestor->date_of_residency)->format('F j, Y') }}</b>.
    </p>

    <p class="paragraph-text">
        This certification is being issued upon the request of 
        <b>{{ $residency_certificate->requestor->first_name }} {{ $residency_certificate->requestor->last_name }}</b> 
        for <b>{{ $residency_certificate->purpose }}</b> purposes.
    </p>

    @php
        $issuedDate = \Carbon\Carbon::parse($residency_certificate->date_issued);
    @endphp

    <p class="paragraph-text">
        Issued this <b>{{ $issuedDate->format('jS') }}</b> day of 
        <b>{{ strtoupper($issuedDate->format('F')) }} {{ $issuedDate->format('Y') }}</b> at 
        <b>{{ Auth::user()->barangay->barangay_name }}</b>, {{ Auth::user()->barangay->municipality->municipality_name }}.
    </p>

    <!-- Applicant Signature -->
  

   <div class="applicant-signature">
        <p style="margin:0; border-bottom:1px solid black; display:inline-block; font-size:14pt; font-family:'Bookman Old Style', serif;">
            @if($chairman)
                <strong>
                    {{ $residency_certificate->requestor->first_name }} {{ $residency_certificate->requestor->last_name }}
                </strong>
            @endif
        </p>
        <p style="margin:0; font-size:12pt; font-family:'Bookman Old Style', serif;">Signature Over Printed Name</p>
    </div>

    <!-- Punong Barangay Signature -->
    <div class="signature-section">
        <p style="margin:0; border-bottom:1px solid black; display:inline-block; font-size:14pt; font-family:'Bookman Old Style', serif;">
            @if($chairman)
                <strong>
                    {{ strtoupper("HON. {$chairman->first_name} {$chairman->middle_initial}. {$chairman->last_name}, CSSP") }}
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

    <br><br><br>
</div>

</body>
</html>