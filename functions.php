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
        
        $status = array_map(function($status) {
            return $status['status'];
        }, $statuses);

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
                    } else if (!in_array($invoice[$field], $status)) {
                        $errors[$field] = 'Status must be in the list of statuses';
                    }
                    break;
            }
        }
        return $errors;
    }

    function updateInvoice($invoice){
        global $db, $statuses;

        $status_id = null;
        foreach($statuses as $status){
            if($status['status'] == $invoice['status']){
                $status_id = $status['id'];
                break;
            }
        }

        $new = [
            'number' => $invoice['number'],
            'amount' => $invoice['amount'],
            'status' => $invoice['status'],
            'client' => $invoice['client'],
            'email'  => $invoice['email']
        ];

        $sql = "UPDATE invoices SET amount = :amount, status_id = :status_id, client = :client, email = :email WHERE number = :number";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':number' => $new['number'],
            ':client' => $new['client'],
            ':email'  => $new['email'],
            ':amount' => $new['amount'],
            ':status_id' => $status_id,
        ]);
    
    header("Location: index.php");
    }

    function addInvoice($invoice){
        global $db, $statuses;

        $status_id = null;
        
        foreach($statuses as $status){
            if($status['status'] == $invoice['status']){
                $status_id = $status['id'];
                break;
            }
        }

        $newInvoice= [
            'number' => createInvoiceNumber(),
            'amount' => $invoice['amount'],
            'status' => $invoice['status'],
            'client' => $invoice['client'],
            'email'  => $invoice['email'],
        ];

        $sql = "INSERT INTO invoices (`number`, `client`, `email`, `amount`, `status_id`)
        VALUES (:number, :client, :email, :amount, :status_id)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':number' => $newInvoice['number'],
            ':client' => $newInvoice['client'],
            ':email'  => $newInvoice['email'],
            ':amount' => $newInvoice['amount'],
            ':status_id' => $status_id,
        ]);

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
    global $db, $invoices;

    $sql = "DELETE FROM invoices where number = :number";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':number', $number);
    $stmt->execute();

  } 