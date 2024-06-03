<?php
    require 'data.php';
    require 'functions.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $invoice = sanitize($_POST);
        $errors = validate($invoice);

        if(count($errors) === 0){
            updateInvoice($invoice);
        }
    } 

    if(isset($_GET['number'])){
        $invoice = current(array_filter($_SESSION['invoices'], function($invoice){
            return $invoice['number'] == $_GET['number'];
        }));

        if(!$invoice){
            header("Location: index.php");
        }
    } else {
        header("Location:index.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Invoice Manager | Update</title>
</head>
<body>
        <main class="container my-4">
        <nav class="mb-3">
            <div id="infoContainer">
                <h1>Invoice Manager</h1>
                <p>Updating invoice</p>
            </div>
            <ul class="nav">
                <?php foreach ($statuses as $status): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?status=<?php echo $status ;?>">
                            <?php echo ucfirst($status); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <section class="bg-light p-5">
            <div class="container">
                <form method="post">
                    <input type="hidden" id="number" name="number" value="<?php echo $invoice['number'] ?>">
                    
                    <div class="form-group mb-3">
                        <label for="name">Client name:</label>
                        <input type="text" id="client" name="client" class="form-control" value="<?php echo $invoice['client'] ?? '';?>">
                        <div class="error text-danger"><?php echo $errors['client'] ?? '' ;?></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Client email:</label>
                        <input type="text" id="email" name="email" class="form-control" value="<?php echo $invoice['email'] ?? '';?>">
                        <div class="error text-danger"><?php echo $errors['email'] ?? '' ;?></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="amount">Invoice Amount:</label>
                        <input type="number" id="amount" name="amount" class="form-control" value="<?php echo $invoice['amount'] ?? '';?>">
                        <div class="error text-danger"><?php echo $errors['amount'] ?? '' ;?></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="status">Invoice Status:</label>
                        <select name="status" id="status" class="form-control">
                            <?php foreach($statuses as $status): ?>
                            <option value="<?php echo $status?>" 
                            <?php if($status == $invoice['status']): ?> selected <?php endif; ?>
                                >
                                <?php echo $status; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="error text-danger"><?php echo $errors['status'] ?? '' ;?></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>