<?php 
    require "data.php";
    require "functions.php";
    $invoices = filterInvoices($invoices, "pending");
    require "template.php";
