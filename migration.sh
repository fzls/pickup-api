#!/bin/bash
php artisan make:migration $(printf "create_%s_table" "$1") --create=$1
