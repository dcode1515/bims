<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Death Certificate</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: "Bookman Old Style", serif;
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

    @media print {
        .blurred {
            filter: blur(4px);
        }
    }
</style>
</head>

<body>

<!-- ================= HEADER ================= -->
<div class="header">
    @if(Auth::user()->barangay_info_id==1)
        <img style="width:120%; margin-top:-50px; margin-left:-50px;"
             src="{{ asset('public/barangay/header/ubaldo.png') }}"
             alt="Barangay Header">
    @endif
</div>

<!-- ================= LEFT VERTICAL LINE ================= -->

<div style="position:absolute; left:195px; top:80px; width:400px; height:1990px;">
      <img style="width: 5%; height:50%;" src="{{ asset('public/barangay/header/line.jpg') }}" alt="Barangay Header">
</div>


<!-- ================= LEFT SIDE OFFICIALS ================= -->
<div class="officials-container">

    <p style="font-weight:bold;">SANGGUNIANG BARANGAY</p>

    {{-- Barangay Chairman --}}
    @if($chairman)
        <p style="font-weight:bold; color:#800000;">
            {{ $chairman->first_name }} {{ $chairman->middle_initial }}. {{ $chairman->last_name }}
        </p>
        <p>{{ $chairman->position->position ?? 'Barangay Chairman' }}</p>

        @if($chairman->commitee)
            <p>{{ $chairman->commitee->commitee }}</p>
        @endif
    @else
        <p style="font-weight:bold;">No Chairman Found</p>
        <p>Barangay Chairman</p>
    @endif

    <br>
    <p style="font-weight:bold;">BARANGAY KAGAWAD</p>

    @foreach($councilors as $councilor)
        <p>
            <strong style="color:#800000;">
                {{ $councilor->first_name }} {{ $councilor->middle_initial }}. {{ $councilor->last_name }}
            </strong><br>

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
            <strong style="color:#800000;">
                {{ $barangay_administrator->first_name }} {{ $barangay_administrator->middle_initial }}. {{ $barangay_administrator->last_name }}
            </strong><br>
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
            <strong style="color:#800000;">
                {{ $sk_chairman->first_name }} {{ $sk_chairman->middle_initial }}. {{ $sk_chairman->last_name }}
            </strong><br>
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
            <strong style="color:#800000;">
                {{ $secretary->first_name }} {{ $secretary->middle_initial }}. {{ $secretary->last_name }}
            </strong><br>
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
            <strong style="color:#800000;">
                {{ $treasurer->first_name }} {{ $treasurer->middle_initial }}. {{ $treasurer->last_name }}
            </strong><br>
            {{ $treasurer->position->position ?? 'Barangay Treasurer' }}

            @if($treasurer->commitee)
                <br>{{ $treasurer->commitee->commitee }}
            @endif
        </p>
    @endif

    <p style="margin-top:100px;">NOT VALID WITHOUT SEAL</p>

</div>


<!-- ================= MAIN CONTENT ================= -->
<div style="margin-left:230px; margin-right:35px;">

    <h2 style="text-align:center; font-size:24px; font-family:Elephant;">
        CERTIFICATION
    </h2>

    {{-- Watermark Logo --}}
    @if(Auth::user()->barangay->photo)
        <div style="
            position:absolute;
            top:40%;
            left:65%;
            transform:translate(-50%, -50%);
            opacity:0.15;
            z-index:0;
            pointer-events:none;">
            <img src="{{ asset('public/barangay/logo/' . Auth::user()->barangay->barangay_name . '/' . Auth::user()->barangay->photo) }}"
                 alt="Barangay Logo"
                 style="max-width:350px;">
        </div>
    @endif

    <p style="font-size:12pt;">TO WHOM IT MAY CONCERN:</p>

   <p style="font-size:12pt; margin-left:12px;  font-family:'Bookman Old Style', serif;">
This is to certify that the following are the details/information of the deceased:
    </p>

    <p style="font-size:12pt; margin-left:3px; text-align:justify; font-family:'Bookman Old Style', serif;">
           FIRST NAME : {{$death_certificate->deceased->first_name}}
    </p>
     <p style="font-size:12pt; margin-left:3px; text-align:justify; font-family:'Bookman Old Style', serif;">
           MIDDLE INITIAL: {{$death_certificate->deceased->middle_initial}}
    </p>
     <p style="font-size:12pt; margin-left:3px; text-align:justify; font-family:'Bookman Old Style', serif;">
           LAST NAME : {{$death_certificate->deceased->last_name}}
    </p>
    <p style="font-size:12pt; margin-left:3px; text-align:justify; font-family:'Bookman Old Style', serif;">
           AGE: {{ \Carbon\Carbon::parse($death_certificate->deceased->birthdate)->age }} Years Old

    </p>
    <p style="font-size:12pt; margin-left:3px; text-align:justify; font-family:'Bookman Old Style', serif;">
           HOME ADDRESS: {{$death_certificate->purok->purok_name}}, {{ $death_certificate->purok->households->first()->street ?? 'N/A' }}

    </p>
    <p style="font-size:12pt; margin-left:3px; text-align:justify; font-family:'Bookman Old Style', serif;">
           CIVIL STATUS 
    </p>
    <p style="font-size:12pt; margin-left:3px; text-align:justify; font-family:'Bookman Old Style', serif;">
           DATE OF DEATH 
    </p>
    <p style="font-size:12pt; margin-left:3px; text-align:justify; font-family:'Bookman Old Style', serif;">
           PLACE OF DEATH 
    </p>
    <p style="font-size:12pt; margin-left:3px; text-align:justify; font-family:'Bookman Old Style', serif;">
           FATHER'S NAME 
    </p>
    <p style="font-size:12pt; margin-left:3px; text-align:justify; font-family:'Bookman Old Style', serif;">
           MOTHER'S NAME 
    </p>


    <p>
     This certification is being issued upon the request of the / bereaved family for any legal purpose /s it may serve him/her best.
    </p>

    <!-- Signature -->
    <div style="margin-left:140px; margin-top:100px; font-size:14pt;">
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
    <div class="blurred" style="margin-top:70px; font-family:'Bookman Old Style', serif;">
        O.R No._______________<br>
        Date Issued:______________<br>
        Doc. Stamp Paid
    </div>

   

</div>

</body>
</html>
