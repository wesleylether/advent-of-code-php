## About Advent of Code

Wesley's solutions to the advent of code puzzels

### How to run
pull repository and install composer and npm packages.

To run a puzzle execute:
```
php artisan advent:of:code <year> <day> (--one or --two)
```

examples

```shell
php artisan advent:of:code 2020 1

# to run only part 2
php artisan advent:of:code 2020 2 --two
```

### How to create
in the folder `storage/app/<year>/<day>/input` you can add the input values.
These files need to exist.

then in the folder `app/AdventOfCode/year<year>/Day<day>.php` you can create classes that extend `app/AdventOfCode/BaseAdventOfCodeDay.php`
