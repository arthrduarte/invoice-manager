<?php 

    function filterInvoices($invoices, $status) {
        if ($status === "all"){
            return $invoices;
        }

        return array_filter($invoices, function ($invoice) use ($status){
            return $invoice['status'] === $status;
        });
    }
?>