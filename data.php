<?php 
  try{
    $dsn = 'mysql:host=localhost;dbname=invoice_manager';
    $db = new PDO($dsn, 'root', 'root');

    $invoices_result = $db->query("SELECT invoices.*, statuses.status FROM invoices JOIN statuses ON invoices.status_id = statuses.id ORDER BY invoices.id");
    $invoices = $invoices_result->fetchAll(PDO::FETCH_ASSOC);

    $statuses_result = $db->query("SELECT * FROM statuses");
    $statuses = $statuses_result->fetchAll(PDO::FETCH_ASSOC);
  
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "</br>";
    exit();
  }

  // $statuses = [
  //   [
  //     'id' => '1',
  //     'status' => 'draft',
  //   ],
  //   [
  //     'id' => '2',
  //     'status' => 'pending',
  //   ],
  //   [
  //     'id' => '3',
  //     'status' => 'paid',
  //   ]
  // ]
