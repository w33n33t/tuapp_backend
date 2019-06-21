@echo off

:::: Commands ::::

:: DosKey ::

:: Creates a new alias
doskey dk=doskey $*	
:: Lists current aliases
doskey dkm=doskey /macros
:: Lists the command history
doskey dkh=doskey /history
:: Doskey Help
doskey dkhh=doskey /?

:::: Laravel ::::
doskey pa=php artisan $*
doskey par=php artisan routes
doskey pam=php artisan migrate
doskey pamr=php artisan migrate:refresh
doskey pamrb=php artisan migrate:rollback
doskey pamrs=php artisan migrate:refresh --seed
doskey pda=php artisan dumpautoload

doskey cu=composer update
doskey ci=composer install
doskey cda=composer dump-autoload
doskey cdao=composer dump-autoload -o
doskey cr=composer require $*
doskey crd=composer require --dev $*

doskey cc=codecept $*
doskey ccgu=codecept generate:cept unit $*
doskey ccgf=codecept generate:cept functional $*
doskey ccga=codecept generate:cept acceptance $*
doskey ccru=codecept --colors run unit $*
doskey ccrf=codecept --ansi run functional $*
doskey ccra=codecept run acceptance $*