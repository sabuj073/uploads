<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performa Invoice Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 210mm;
            height: 297mm;
            padding: 10mm;
            box-sizing: border-box;
            position: relative;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .invoice__number{
            font-weight: 600;
            margin-top: -35px !important
        }
        .header img {
            width: 100px;
            height: auto;
            top: 15%;
            left: 54px;
            transform: translate(-50%, -50%);
            position: absolute;
        }
        .info-right td {
            padding: 2px 0;
            border: 1px solid !important;
            padding-left: 8px !important;
        }
        .header h1 {
            margin: 0;
            z-index: 2;
        }
        .header p {
            margin: 5px 0;
            z-index: 2;
        }
        .content {
            margin-top: 20px;
            position: relative;
            z-index: 2;
        }
        .info-table, .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            position: relative;
            z-index: 2;
        }
        .info-table td, .items-table th, .items-table td {
            border: 1px solid black;
            padding: 2px;
        }
        .items-table td{
            text-align: center;
        }
        .left__td{
            text-align: left !important;
        }
        .info-table {
            margin-bottom: 20px;
        }
        .info-table td {
            width: 50%;
            vertical-align: top;
        }
        .info-left {
            text-align: left;
            border: 0;
        }
        .info-right table {
            width: 100%;
            border: none;
            border-collapse: collapse;
        }
        .info-right td {
            border: none;
            padding: 2px 0;
        }
        .items-table th {
            background-color: #f2f2f2;
        }
        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            position: relative;
            z-index: 2;
        }
        .text-right {
            text-align: right;
        }
        .noprint {
            display: block;
            position: absolute;
            right: 0;
            background-color: green;
            border-color: green;
            padding: 5px 10px;
            color: #ffffff;
            cursor: pointer;
        }


        /* New Css */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            font-size: 1.2em;
            font-weight: bold;
            padding: 10px;
            border: none;
        }
        .no-border {
            border: none;
        }
        .buyer-info, .seller-info {
            width: 50%;
        }
        .buyer-info {
            padding-right: 10px;
        }
        .seller-info {
            padding-left: 10px;
        }
        .contact-info {
            padding: 10px 0;
        }
        /* New Css */


        @media print {
            .noprint {
                display: none;
            }
        }
    </style>
</head>
<body>


    @php
            $invoice_data = getinvoicedetails($deliveryChallan->invoice_id);
        @endphp
<button class="noprint" onclick="window.print()">Print</button>


<div class="content">
    <table>
    <tr>
        <td colspan="2" class="header">PROFORMA INVOICE</td>
    </tr>
    <tr>
        <td>Proforma Invoice No:</td>
        <td>{{ sprintf('%04d', @$deliveryChallan->id) }}</td>
    </tr>
    <tr>
        <td>Date:</td>
        <td>{{ \Carbon\Carbon::parse($deliveryChallan->created_at)->format('j M Y') }}</td>
    </tr>
    <tr>
        <td>Buyer:</td>
        <td>{{ @$buyer->user->first_name." ".@$buyer->user->last_name }}</td>
    </tr>
    <tr>
        <td>REF:</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">
            <table>
                <tr>
                    <td class="buyer-info">
                        <strong>Messers (Buyer)</strong><br>
                {{ @$buyer->user->first_name." ".@$buyer->user->last_name }}<br>
                {!! @$buyer->address !!}<br>
                {!! @$buyer->note !!}<br>
                    </td>
                    <td class="seller-info">
                        <strong>S.S. PRINTERS</strong><br>
                        Ka-32, Shahjadpur, Gulshan,<br>
                        Dhaka-1212<br>
                        Cell: +880-1788800019<br><br>
                        <strong>To:</strong><br>
                        {{ @$buyer->company_name }}<br>
                         {{ @$provider->user->first_name." ".@$provider->user->last_name }}<br>
                {!! @$provider->address !!}<br>
                {!! @$provider->note !!}<br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            The BUYER agree to buy and the VENDOR agree to sell the following products/service(s) with the terms and conditions as stated
        </td>
    </tr>
</table>
      

    <table class="items-table">
        <tr>
            <th>Sl. No.</th>
            <th>PO Number (WFX)</th>
            <th>Description of Items</th>
            <th>Number of Units</th>
            <th>Price/Units</th>
            <th>TOTAL AMOUNT USD</th>
        </tr>
        @php
            $counter = 0;
            
function convertNumberToWords($number) {
    $hyphen = '-';
    $conjunction = ' and ';
    $separator = ', ';
    $negative = 'negative ';
    $decimal = ' point ';
    $dictionary = [
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'forty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
        100 => 'hundred',
        1000 => 'thousand',
        1000000 => 'million',
        1000000000 => 'billion',
        1000000000000 => 'trillion',
        1000000000000000 => 'quadrillion',
        1000000000000000000 => 'quintillion'
    ];
    
    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convertNumberToWords only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convertNumberToWords(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convertNumberToWords($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convertNumberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convertNumberToWords($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = [];
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return ucfirst($string);
}
            
            
        @endphp
        @php
            $totalunit = 0;
            $totalprice = 0;
            $totaltotal = 0;
        @endphp
        @foreach ($invoices as $data)
        @php 
            $counter++;
            $temp_counter = count($data->invoiceItems);
            $count_item = 0;
            $bool = true;
        @endphp
        <tr>
            <td rowspan="{{ count($data->invoiceItems)+1 }}">{{ $counter }}</td>
            <td rowspan="{{ count($data->invoiceItems)+1 }}">{{ $data->po_number }}</td>
             
             @foreach ($data->invoiceItems as $item)
                @if($count_item<=$temp_counter)
                    <tr>
                @endif
            <td class="left__td">{{ $item->product_name }} ({{ $item->variations }})</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->total }}</td>
         @if($count_item>=$temp_counter)
                    </tr>
                @endif
            @php  $count_item++;   @endphp
            
            
         @endphp
            
        @endforeach
        </tr>
        @if(isset($data))
            @php
                $totalunit += @$data->invoiceItems->sum('quantity') ;
                $totalprice += @$data->invoiceItems->sum('price');
                $totaltotal += @$data->invoiceItems->sum('total');
            @endphp
            @endif
         @endforeach
         @if(isset($data))
         <tr>
             <td colspan="3" class="text-right">Total</td>
             <td>{{ number_format($totalunit )}}</td>
             <td>{{ $totalprice }}</td>
             <td>{{ $totaltotal }}</td>
         </tr>
        @endif
    </table>
    @if(isset($data))
    <br>
    <b>In Words: {{ convertNumberToWords($totaltotal) }} dollars only</b>
    @endif
</div>


<div class="term-conditions">
    <h5><u>Terms & Conditions</u></h5>
     <ol>
        <li>Origin: Bangladesh</li>
        <li>
            Payment: By 100% confirmed and irrevocable at 120 days sight L/C in USD & MUST BE PAYMENT BY US $ ONLY AT MATURITY DATE.
        </li>
        <li>Offer validity: 45 days after issuing Proforma Invoice.</li>
        <li>Packing: Export Standard Packing</li>
        <li>Delivery: Within 5 days from PO Issue Date.</li>
        <li>
            Bank: United Commercial Bank Ltd., Hazi Abdul Hashem Market, 1st Floor, 27, Kamarpara, Uttara, Turag, Dhaka, Bangladesh
        </li>
        <li>Maturity date is to be counted from the date of PI submission.</li>
        <li>
            All charges of issuing bank including reimbursement, remittance, etc., will be on L/C applicant's account.
        </li>
        <li>Payment after export realization is not allowed.</li>
        <li>Partial delivery is to be allowed.</li>
        <li>VAT number: 003710187-0101</li>
    </ol>
</div>

<div class="signature">
    <p><br>Receiver's Signature</p>
    <p>
        <div class=""><img class="pad_signature" src="https://res.cloudinary.com/dvxrcnzae/image/upload/v1724492383/A_Signature_copy-01_ksmmoj.png">
    </div><br><br>Authorized Signature</p>
</div>

</body>
</html>

<script>
    $(document).ready(function() {
        // Uncomment the line below if you want the print dialog to open automatically on page load
        // window.print();
    });
</script>

<style>
    .pad_signature{
        width: 100px;
    position: absolute;
    right: 115px;
    top: -38px;
    }

    .content{
        margin-top:0px !important
    }
</style>
