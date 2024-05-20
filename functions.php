<?php 

    function filterInvoices($invoices, $status) {
        if ($status === "all"){
            return $invoices;
        }

        return array_filter($invoices, function ($invoice) use ($status){
            return $invoice['status'] === $status;
        });
    }
    function getInvoiceNumber ($length = 5) {
    $letters = range('A', 'Z');
    $number = [];
    
    for ($i = 0; $i < $length; $i++) {
        array_push($number, $letters[rand(0, count($letters) - 1)]);
    }
    return implode($number);
    }
?>