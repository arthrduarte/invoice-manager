<?php 
    require "data.php";
    require "functions.php";
    $invoices = filterInvoices($invoices, "all");
    require "template.php";
