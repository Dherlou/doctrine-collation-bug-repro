# Reproduction example for https://github.com/doctrine/dbal/issues/5338

## execution environment preparation
1. copy `.env.example` to `.env`
2. specify your database credentials in the `.env`
3. run `composer install`

## doctrine/dbal-only testing
1. test without charset specified:
   - execute `php test_case_dbal.php` as is
   - generates diff
2. test with charset specified:
   - uncomment marked charset definition in `test_case_dbal.php:40`
   - execute `php test_case_dbal.php`
   - generates no diff

## cross-check for correct DBAL-example code with doctrine/orm and doctrine/migrations
0. execute doctrine/dbal-only test above so that the testing table is created
1. test without charset specified:
   - execute `vendor/bin/doctrine-migrations diff` as is
   - migration is generated
2. test with charset specified:
   - add `"charset"="utf8mb4"` to the entity's name column options `src/Entity/Test.php:test_case_dbal.php:20` (see line below it)
   - execute `vendor/bin/doctrine-migrations diff`
   - no migration is generated