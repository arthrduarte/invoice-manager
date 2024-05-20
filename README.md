## What changes did you make when refactoring the project?
Well, I had to do everything in the requirements for part 2. My biggest issue was understanding that I had to parse $invoices to session and then parse it to $invoices again - I got stuck for probably more than 15min trying to figure out the session part.

## In your own words, what are the guidelines for knowing when to use $_POST over query strings and $_GET?
We should use $_POST when we are dealing with sensitive information. Choosing query string and $_GET makes it easy for breaches.

## What are some limitations to using sessions for persistent data? What could be done to overcome those limitations?
