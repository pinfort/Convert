<?php

namespace App\Lib\Convert;

use Exception;

/**
* integer style convert Library
*/
class Convert
{
    public $bin_str;

    public $base64_encode_table = [
        '000000' => 'A',
        '000001' => 'B',
        '000010' => 'C',
        '000011' => 'D',
        '000100' => 'E',
        '000101' => 'F',
        '000110' => 'G',
        '000111' => 'H',
        '001000' => 'I',
        '001001' => 'J',
        '001010' => 'K',
        '001011' => 'L',
        '001100' => 'M',
        '001101' => 'N',
        '001110' => 'O',
        '001111' => 'P',
        '010000' => 'Q',
        '010001' => 'R',
        '010010' => 'S',
        '010011' => 'T',
        '010100' => 'U',
        '010101' => 'V',
        '010110' => 'W',
        '010111' => 'X',
        '011000' => 'Y',
        '011001' => 'Z',
        '011010' => 'a',
        '011011' => 'b',
        '011100' => 'c',
        '011101' => 'd',
        '011110' => 'e',
        '011111' => 'f',
        '100000' => 'g',
        '100001' => 'h',
        '100010' => 'i',
        '100011' => 'j',
        '100100' => 'k',
        '100101' => 'l',
        '100110' => 'm',
        '100111' => 'n',
        '101000' => 'o',
        '101001' => 'p',
        '101010' => 'q',
        '101011' => 'r',
        '101100' => 's',
        '101101' => 't',
        '101110' => 'u',
        '101111' => 'v',
        '110000' => 'w',
        '110001' => 'x',
        '110010' => 'y',
        '110011' => 'z',
        '110100' => '0',
        '110101' => '1',
        '110110' => '2',
        '110111' => '3',
        '111000' => '4',
        '111001' => '5',
        '111010' => '6',
        '111011' => '7',
        '111100' => '8',
        '111101' => '9',
        '111110' => '+',
        '111111' => '/',
    ];

    function __construct($length = null)
    {
        $this->length = $length;
    }

    public function Base64ChangeLastTwoCharacter($six_three=null, $six_four=null)
    {
        if (!is_null($six_three)) {
            $this->base64_encode_table['111110'] = $six_three;
        }

        if (!is_null($six_four)) {
            $this->base64_encode_table['111111'] = $six_four;
        }
    }

    public function Binarystring($bin_str = null)
    {
        if ($bin_str === null and $this->bin_str === null) {
            throw new Exception('Encode target undifined', 1);
        }

        if ($bin_str === null) {
            $bin_str = $this->bin_str;
        } else {
            $this->bin_str = $this->ZeroFill($bin_str);
        }

        return $bin_str;
    }

    public function Base64($base64_str = null)
    {
        if ($base64_str === null and $this->bin_str === null) {
            throw new Exception('Encode target undifined', 1);
        }

        if ($base64_str === null) {
            $base64_str = $this->Base64Encode();
        } else {
            $this->bin_str = $this->ZeroFill($this->Base64Decode($base64_str));
        }

        return $base64_str;
    }

    public function Decimal($dec_str = null)
    {
        if ($dec_str === null and $this->bin_str === null) {
            throw new Exception('Encode target undifined', 1);
        }

        if ($dec_str === null) {
            $dec_str = gmp_strval(gmp_init($this->bin_str, 2));
        } else {
            $this->bin_str = $this->ZeroFill(gmp_strval(gmp_init($dec_str), 2));
        }

        return $dec_str;
    }

    public function Hexadecimal($hex_str = null)
    {
        if ($hex_str === null and $this->bin_str === null) {
            throw new Exception('Encode target undifined', 1);
        }

        if ($hex_str === null) {
            $hex_str = gmp_strval(gmp_init($this->bin_str, 2), 16);
        } else {
            $this->bin_str = $this->ZeroFill(gmp_strval(gmp_init($hex_str, 16), 2));
        }

        return $hex_str;
    }

    private function Base64Encode()
    {
        $encoded = '';

        $bin_str = $this->bin_str;

        $str_arr = str_split($bin_str, 6);
        $count = 1;
        $tmp = '';
        foreach ($str_arr as $data) {
            $tmp .= $this->ChoiceFromBase64EncodeTable($data);
            $count++;
            if ($count === 4) {
                $encoded .= $tmp;
                $tmp = '';
                $count = 1;
            }
        }
        if (!($tmp === '')) {
            $encoded .= str_pad($tmp, 4, '=', STR_PAD_RIGHT);
        }

        return $encoded;
    }

    /**
     * choice character from table
     * @param string binary like string.
     *        the length must be 6.
     *        if the length is shorter than 6, this function will make
     *        the length to 6 by use zero fill<right>.
     * @return string<1> chosen character.
     */
    private function ChoiceFromBase64EncodeTable($key)
    {
        $strlen = strlen($key);

        if ($strlen > 6)
            throw new Exception("Invailed key for choice from encode table.", 1);

        if ($strlen != 6)
            $key = str_pad($key, 6, 0, STR_PAD_RIGHT);

        if (strlen($key) != 6)
            throw new Exception("Unexpected Error.\nInvailed key for choice from encode table.", 1);

        return $this->base64_encode_table[$key];
    }

    private function Base64Decode($base64_str)
    {
        $str_list = str_split($base64_str);

        $bin_str = '';
        foreach ($str_list as $data) {
            $bin_str .= array_search($data, $this->base64_encode_table);
        }

        return $bin_str;
    }

    private function ZeroFill($bin_str)
    {
        if (!($this->length === null)) {
            if (strlen($bin_str) > $this->length) {
                trigger_error('Binary string size larger than setting length.', E_USER_WARNING);
            }
            $bin_str = str_pad($bin_str, $this->length, 0, STR_PAD_LEFT);
        }

        return $bin_str;
    }
}