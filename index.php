<?php
    session_start();
    require "data.php";
    require "functions.php";

    if (!isset($_SESSION['invoices'])) {
        $_SESSION['invoices'] = $invoices;
    }

    if(isset($_GET['status'])){
        $invoices = filterInvoices($_SESSION['invoices'], $_GET['status']);
        $status = $_GET['status'];
    } else {
        $invoices = filterInvoices($_SESSION['invoices'], "all");
    }
    
    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['amount']) && isset($_POST['status'])){
        $newInvoice = [
            'number' => getInvoiceNumber(),
            'amount' => $_POST['amount'],
            'status' => $_POST['status'],
            'client' => $_POST['name'],
            'email'  => $_POST['email'],
        ];

        $_SESSION['invoices'][] = $newInvoice;
        $invoices = $_SESSION['invoices'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Invoice Manager | <?php echo ucfirst($status) ;?></title>
</head>
<body>
    <main class="container my-4">
        <nav class="mb-3">
            <div id="infoContainer">
                <h1>Invoice Manager</h1>
                <p>There are <?php echo count($invoices) ?> invoices</p>
            </div>
            <ul class="nav">
                <?php foreach ($statuses as $status): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?status=<?php echo $status ;?>">
                            <?php echo ucfirst($status); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <li class="nav-item">
                    <a class="nav-link" href="add.php">Add ></a>
                </li>        
            </ul>
        </nav>
        <section>
            <?php foreach ($invoices as $invoice): ?>
                <div class="row mb-2 border rounded">
                    <div class="col-md-3 col-3">
                        <div class="p-3 d-flex align-items-center justify-content-between">
                            <p class="fw-bold m-0"><?php echo $invoice['number']; ?></p>
                        </div>
                    </div>
                    <div class="col-md-3 col-3">
                        <div class="p-3 d-flex align-items-center">
                            <p class="text-primary m-0"><?php echo $invoice['client']; ?></p>
                        </div>
                    </div>
                    <div class="col-md-3 col-3">
                        <div class="p-3 d-flex align-items-center justify-content-center">
                            <p class="m-0">$<?php echo $invoice['amount']; ?></p>
                        </div>
                    </div>
                    <div class="col-md-3 col-3">
                        <div class="p-3 d-flex align-items-center justify-content-center" >
                            <span class="px-3" style="background-color:<?php echo ($invoice['status'] === 'draft' || $invoice['status'] === 'paid') ? '#c9e3d8' : ($invoice['status'] === 'pending' ? '#fff1c5' : '#fff'); ?>">
                                <p class="border rounded text-center m-0">
                                    <?php echo $invoice['status']; ?>
                                </p>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
</body>
</html>