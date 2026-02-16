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

 
 <div style="margin-left:160px; margin-right:15px;">
   
    <h2 style="text-align:center;  text-decoration:">BARANGAY CLEARANCE</h2>

    <p><strong>TO WHOM IT MAY CONCERN:</strong></p>

    <p>
        This is to certify that Mr./Ms./Mrs. _______________________________, 
        ______ years old, ____________________, a native of __________________________, 
        and a resident of Zone/Purok ______________________________, Ubaldo D. Laya, Iligan City.
    </p>

    <p>
        This is to certify further that the above-mentioned person is known by this office and has the following:
    </p>

    <p>Remarks:</p>
    <ul>
        <li>( ) No Derogatory Record and is of Good Moral Character</li>
        <li>( ) Have Case Filed but Settled</li>
        <li>( ) Have Pending Case FILED</li>
        <li>( ) Have Case Filed Withdrawn/Dismissed</li>
    </ul>

    <p>Purpose: _______________________________</p>
    <p>Date Issued: ___________________________</p>

    <div class="signature">
        <p>__________________________</p>
        <p>Signature above Printed Name</p>
        <br><br>
       
    </div>
  <div style="margin-left:250px; margin-right:15px;">
  
    <p style="margin:0;"><strong>HON. ANTONIO P. FLORES, CSSP</strong></p>
    <p style="margin:0;">PUNONG BARANGAY</p>

</div><br><br><br><br>

   <div class="signature blurred" style="margin-right:250px; margin-right:15px;">
    <label>O.R No._______________</label><br>
    <label>Date Issued:______________</label><br>
    <label>Doc. Stamp Paid</label>
</div>

</div>

</body>
</html>
