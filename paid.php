<?php 
    require "data.php";
    require "functions.php";
    $invoices = filterInvoices($invoices, "paid");
    require "template.php";
