## Beyond incorporating the invoice_manager database, what other refactoring did you do for this part of the project?
I had to change my navbar, since I updated the previous $statuses array to contain an item called "all". Now it's fixed.

## In your own words, why is it important to use prepared statements and when should you use them?
They reduce the risk of errors, and prevent SQL injection. We should use prepared statements everytime an input is requested from the user, because we shouldn't trust their inputs.

## How did using a database to manage the data differ from using a session array? Which do you prefer and why?
With a database it seems to be easier. For this project, having a database helped to replace a lot of array methods that were necessaries before. Now with we can search in the database using SQL, which is more way more readable.