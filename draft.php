<?php 
    require "data.php";
    require "functions.php";
    $invoices = filterInvoices($invoices, "draft");
    require "template.php";
