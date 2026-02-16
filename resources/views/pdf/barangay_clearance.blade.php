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

<div style="position:absolute; left:-20px; margin-top: -0px;  font-family:'Bookman Old Style', serif; font-size:8pt; line-height:1.4;">

    <p style="font-weight:bold;">SANGGUNIANG BARANGAY</p>
    

    <p style="font-weight:bold;">ANTONIO P. FLORES</p>
    <p>Barangay Chairman</p>

    <br>
    <p style="font-weight:bold;">BARANGAY KAGAWAD</p>

    <p><strong>MARGARET D. CASAS</strong><br>
    Livelihood & PWD</p>

    <p><strong>ALAN M. BADELLES</strong><br>
    Senior Citizen & Agriculture</p>

    <p><strong>JEROMEL R. AREOLA</strong><br>
    BDRR, Finance & Infrastructure</p>

    <p><strong>ROBERT V. CAPANGPANGAN</strong><br>
    Transportation, Communication, Peace & Order</p>

    <p><strong>WILMA P. ALSONADO</strong><br>
    Health & Sanitation, Social Services</p>

    <p><strong>FERLINA C. OTASA</strong><br>
    Women’s, Education & Environment</p>

    <p><strong>SANTOS M. BINERBA</strong></p>

    <p><strong>JHON DELL D. TABANIA</strong><br>
    Sports</p>

    <br>

    <p><strong>RHIENNA STEPHANIE A. CATIG</strong><br>
    Barangay Secretary</p>

    <br>

    <p><strong>RACHEL GRACE S. VILLAVER</strong><br>
    Barangay Treasurer</p>
   
      <p style="font-family:'Bookman Old Style; font-size:8pt; margin-top: 100px;" >NOT VALID WITHOUT SEAL</p>

</div>


 <div style="margin-left:230px; margin-right:35px;">
    <h2 style="text-align:center;  margin-top: -0px;">BARANGAY CLEARANCE</h2>

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
        [{{ in_array('No Derogatory Record and is known of Good Moral Character', $barangay_clearance->character_status ?? []) ? '●' : ' ' }}] 
        No Derogatory Record and is of Good Moral Character
    </li>

    <li>
        [{{ in_array('Have Case Filed but Settled', $barangay_clearance->character_status ?? []) ? '●' : ' ' }}] 
        Have Case Filed but Settled
    </li>

    <li>
        [{{ in_array('Have Pending Case FILED', $barangay_clearance->character_status ?? []) ? '●' : ' ' }}] 
        Have Pending Case FILED
    </li>

    <li>
        [{{ in_array('Have Case Filed Withdrawn/Dismissed', $barangay_clearance->character_status ?? []) ? '●' : ' ' }}] 
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
    <strong >HON. ANTONIO P. FLORES, CSSP</strong>
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
