# Wireless Logic - Software Engineering Technical Test

## Purpose

This task is intended to test your ability to consume a webpage, process some data and present it.
We are looking for concise, testable, clean, well commented code and that you have chosen the
right tools for the right job. We will also be looking at your app structure as a whole.

### Business requirements

build a console application that scrapes the following website
url https://wltest.dns-systems.net/ and returns a JSON array of all the product options on the page.

Each element in the JSON results array should contain ‘option title, ‘description’, ‘price’ and
‘discount’ keys corresponding to items in the table. The items should be ordered by annual price
with the most expensive package first.

### Installation (docker)
- `make build`

### Running
- `make up`
- `make bash`
- `./vendor/bin/phpunit tests`
- `bin/console app:list-options`

### Solution notes
- it is not specified what the `discount` is. Is it a monetary value, is it a percentage of the price, does it refer to monthly vs annual payment periods? etc.
- it is not specified what the `description` consists of
- for sake of simplicity, no additional library was used for handling monetary values, on a real project it would be sensible to do so. e.g. https://github.com/moneyphp/money
- the solution is obviously over-engineered, as usually expected from technical tests
- tests are minimalistic for brevity reasons, a lot more negative scenarios should be written in a real world scenario
- data scraping from websites is based on guesses and assumptions, which can be simply wrong - it's never a reliable data source
- the requirements don't specify the output to contain information about payment period (monthly / annual) so it was not included
- the requirements don't specify that the price should be expressed annually, although that's something I'd suggest

### What is not covered
- caching
- persistence
- exception/error handling