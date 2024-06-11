<?php
    require "data.php";
    require "functions.php";

    $status = array_map(function($status) {
        return $status['status'];
    }, $statuses);
    
    if(isset($_GET['status'])){
        $invoices = filterInvoices($invoices, $_GET['status']);
        $status = $_GET['status'];
    }

    // var_dump($invoices)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Invoice Manager</title>
</head>
<body>
    <main class="container my-4">
        <nav class="mb-3">
            <div id="infoContainer">
                <h1>Invoice Manager</h1>
                <p>There are <?php echo count($invoices) ?> invoices</p>
            </div>
            <ul class="nav">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">All</a>
                </li>
                <?php foreach ($statuses as $status_row): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?status=<?php echo $status_row['status'] ;?>">
                            <?php echo ucfirst($status_row['status']); ?>
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
                <div class="row mb-2 border rounded align-items-center">
                    <div class="col-lg-2 col-md-3 col-6">
                        <div class="p-3 d-flex justify-content-center">
                            <p class="fw-bold m-0"><?php echo $invoice['number']; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6">
                        <div class="p-3 d-flex justify-content-center">
                            <p class="text-primary m-0"><?php echo $invoice['client']; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6">
                        <div class="p-3 d-flex justify-content-center">
                            <p class="m-0">$<?php echo $invoice['amount']; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6">
                        <div class="p-3 d-flex justify-content-center" >
                            <div class="w-75 py-1 px-3 rounded" style="background-color:<?php echo ($invoice['status'] === 'draft' || $invoice['status'] === 'paid') ? '#c9e3d8' : ($invoice['status'] === 'pending' ? '#fff1c5' : '#fff'); ?>">
                                <p class="rounded text-center m-0">
                                    <?php echo ucfirst($invoice['status']); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row col-lg-4">
                        <div class="col-6 col-lg-6 d-flex justify-content-center">
                            <a class="btn btn-primary" href="update.php?number=<?php echo $invoice['number']?>">Edit</a>
                        </div>
                        <div class="col-6 col-lg-6 d-flex justify-content-center">
                            <form action="delete.php" method="post">
                                <input type="hidden" name="number" value="<?php echo $invoice['number']; ?>">
                                <input type="submit" value="Delete" class="btn btn-danger">
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
</body>
</html>