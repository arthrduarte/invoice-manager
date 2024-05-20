<?php
    require "data.php"
;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Invoice Manager | Add</title>
</head>
<body>
    <main class="container my-4">
        <nav class="mb-3">
            <div id="infoContainer">
                <h1>Invoice Manager</h1>
                <p>Create new invoices</p>
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
                <form action="index.php" method="post">
                    <div class="form-group mb-3">
                        <label for="name">Client name:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Client email:</label>
                        <input type="text" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="amount">Invoice Amount:</label>
                        <input type="number" id="amount" name="amount" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="status">Invoice Status:</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="paid">Paid</option>
                            <option value="pending">Pending</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                </form>
            </div>
        </section>
    </main>
</body>
</html>