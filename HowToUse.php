<?php

require_once('./App/Lib/Convert/Convert.php');

use App\Lib\Convert\Convert;

/**
 * This library depending on GMP Library.
 * Please turn on GMP Library in PHP setting.
 */

/**
 * you can use 4 convert type
 *
 * 1: Binarystring
 * 2: Decimal
 * 3: Hexadecimal (hex)
 * 4: Base64
 *
 */

// I want convert int to hex
$test_int = 421020;
$Lib = new Convert();
$Lib->Decimal($test_int);
$data_converted = $Lib->Hexadecimal();

// I want convert hex to int
$test_hex = '66c9c';
$Lib = new Convert();
$Lib->Hexadecimal($test_hex);
$data_converted = $Lib->Decimal();

// I want convert int to Base64
$test_int = 421020;
$Lib = new Convert();
$Lib->Decimal($test_int);
$data_converted = $Lib->Base64();

// I want convert int to Binarystring in Fixed length 32 bits
$test_int = 4210;
$Lib = new Convert(32);
$Lib->Decimal($test_int);
$data_converted = $Lib->Binarystring();

// I want convert int to Base64 in Fixed length 24 bits
// When you using Base64 converting, setting length<Multiples of 6> is Recommend.
// Because by specification Base64, when the bit length is not Multiples of 6, a number will be change.
$test_int = 4210;
$Lib = new Convert(24);
$Lib->Decimal($test_int);
$data_converted = $Lib->Base64();

// I want convert Base64 string to int
$test_base64 = 'zZO';
$Lib = new Convert();
$Lib->Base64($test_base64);
$data_converted = $Lib->Decimal();

// I want convert unsigned bigint or over to Binarystring
// you can use string to argument of Decimal() instead of int.
$test_unsignedBigint = '18446744073709551615';
$Lib = new Convert();
$Lib->Decimal($test_unsignedBigint);
$data_converted = $Lib->Binarystring();
