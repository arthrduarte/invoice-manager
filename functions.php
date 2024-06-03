<?php 

    require_once 'data.php';

    function sanitize($data) {
        return array_map(function ($value) {
            return htmlspecialchars(stripslashes(trim($value)));
        }, $data);
    }

    function validate($invoice) {
        $fields = ['client', 'email', 'amount', 'status'];
        $errors = [];
        global $statuses;

        foreach ($fields as $field) {
            switch ($field) {
                case 'client':
                    if (empty($invoice[$field])) {
                        $errors[$field] = 'Client name is required';
                    } else if (strlen($invoice[$field]) > 255) {
                        $errors[$field] = 'Client name must be fewer than 255 characters';
                } else if (!preg_match('/^[a-zA-Z\s]+$/', $invoice[$field])) {
                        $errors[$field] = 'Client name must contain only letters and spaces';
                    }
                    break;
                case 'email':
                    if (empty($invoice[$field])) {
                        $errors[$field] = 'Email is required';
                    } else if (filter_var($invoice[$field], FILTER_VALIDATE_EMAIL) === false) {
                        $errors[$field] = 'Email must be a valid address';
                    }
                    break;
                case 'amount':
                    if (empty($invoice[$field])) {
                        $errors[$field] = 'Amount is required';
                    } else if (filter_var($invoice[$field], FILTER_VALIDATE_INT) === false) {
                        $errors[$field] = 'Amount must contain only numbers';
                    }
                    break;
                case 'status':
                    if (empty($invoice[$field])) {
                        $errors[$field] = 'Status is required';
                    } else if (!in_array($invoice[$field], $statuses)) {
                        $errors[$field] = 'Status must be in the list of statuses';
                    }
                    break;
            }
        }
        return $errors;
    }

    function updateInvoice($invoice){
        $new = [
            'number' => $invoice['number'],
            'amount' => $invoice['amount'],
            'status' => $invoice['status'],
            'client' => $invoice['client'],
            'email'  => $invoice['email']
        ];

        $_SESSION['invoices'] = array_map(function($i) use ($new){
            if($i['number'] === $new['number']){
                return $new;
            }
            return $i;
        }, $_SESSION['invoices']);
    
    header("Location: index.php");
    }

    function addInvoice($invoice){
        $newInvoice= [
            'number' => createInvoiceNumber(),
            'amount' => $invoice['amount'],
            'status' => $invoice['status'],
            'client' => $invoice['client'],
            'email'  => $invoice['email'],
        ];

        $_SESSION['invoices'][] = $newInvoice;

        header("Location: index.php");
    }

    function filterInvoices($invoices, $status) {
        if ($status === "all"){
            return $invoices;
        }

        return array_filter($invoices, function ($invoice) use ($status){
            return $invoice['status'] === $status;
        });
    }

    function createInvoiceNumber ($length = 5) {
        $letters = range('A', 'Z');
        $number = [];
        
        for ($i = 0; $i < $length; $i++) {
            array_push($number, $letters[rand(0, count($letters) - 1)]);
        }
        return implode($number);
    }

    function getInvoice($number){
        global $invoices;

        return $invoice = current(array_filter($invoices, function($invoice){
            return $invoice['number'] == $_GET['number'];
        }));
    }

  function deleteInvoice ($number) {
    global $invoices;

    $_SESSION['invoices'] = array_filter($_SESSION['invoices'], function ($invoice) use ($number) {
      return $invoice['number'] != $number;
    });

    return true;
  } 