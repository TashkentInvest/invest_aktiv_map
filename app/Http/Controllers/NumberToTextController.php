<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NumberToTextController extends Controller
{
    private $units = array("bir", "ikki", "uch", "to'rt", "besh", "olti", "yetti", "sakkiz", "to'qqiz");
    private $teens = array("o'n", "o'n bir", "o'n ikki", "o'n uch", "o'n to'rt", "o'n besh",
                           "o'n olti", "o'n yetti", "o'n sakkiz", "o'n to'qqiz");
    private $tens = array("yigirma", "o'ttiz", "qirq", "ellik", "oltmish", "yetmish", "sakson", "to'qson");
    private $hundreds = array("yuz", "ikki yuz", "uch yuz", "to'rt yuz", "besh yuz", "olti yuz", "yetti yuz", "sakkiz yuz", "to'qqiz yuz");
    private $thousands = array("ming", "ming", "ming");
    private $millions = array("million", "million", "million");
    private $milliards = array("milliard", "milliard", "milliard");
    private $femailThousands = array("bir", "ikki");

    public function convert(Request $request)
    {
        $value = $request->input('value');
        if ($this->isValidValue($value)) {
            $text = $this->transformToText($value);
        } else {
            $text = "Kiritilgan qiymat noto'g'ri yoki ruxsat etilgan diapazonga kirmaydi";
        }

        return view('pages.number_to_text', compact('text'));
    }

    private function isValidValue($value)
    {
        if ($value == '0' || (preg_match("/^-{0,1}[1-9]{1,1}[0-9]{1,9}$/", $value, $matcher) && abs($matcher[0]) <= 2147483647)) {
            return true;
        }
        return false;
    }

    private function transformToText($value)
    {
        $tempValue = $this->prepareValue($value);
        if ($tempValue[1] == 0) {
            return "nol";
        }
        $text = "";
        $value = $tempValue[1];

        if ($value >= 1000000000) {
            $text .= $this->getTextByDigitClass($value, 1000000000);
        }
        if ($value >= 1000000) {
            $text .= $this->getTextByDigitClass($value, 1000000);
        }
        if ($value >= 1000) {
            $text .= $this->getTextByDigitClass($value, 1000);
        }
        if ($value >= 1) {
            $text .= $this->getTextByDigitClass($value, 1);
        }
        if ($tempValue[0]) {
            $text = $tempValue[0] . " " . $text;
        }
        return $text;
    }

    private function prepareValue($value)
    {
        $value = trim($value);
        $value = str_replace(" ", "", $value);
        $number = array();
        if ($value[0] == '-') {
            $number[] = 'minus';
            $number[] = intval(substr($value, 1));
        } else {
            $number[] = '';
            $number[] = intval(substr($value, 0));
        }
        return $number;
    }

    private function getTextByDigitClass($value, $digitClass)
    {
        $tempText = "";
        $temp = $value / $digitClass;
        $temp %= 1000;
        $triade = $temp;
        if ($triade >= 100) {
            $tempText .= $this->hundreds[$triade / 100 - 1] . " ";
            $triade %= 100;
        }
        if ($triade >= 10) {
            if (intval($triade / 10) == 1) {
                $tempText .= $this->teens[$triade - 10] . " ";
            } else {
                $tempText .= $this->tens[$triade / 10 - 2] . " ";
                $triade %= 10;
            }
        }
        if ($triade >= 1 && $triade < 10) {
            if ($digitClass == 1000 && ($triade == 1 || $triade == 2)) {
                $tempText .= $this->femailThousands[$triade - 1] . " ";
            } else {
                $tempText .= $this->units[$triade - 1] . " ";
            }
        }
        if ($temp) {
            switch ($digitClass) {
                case 1000:
                    $tempText .= $this->addDigitClassName($this->thousands, $triade);
                    break;
                case 1000000:
                    $tempText .= $this->addDigitClassName($this->millions, $triade);
                    break;
                case 1000000000:
                    $tempText .= $this->addDigitClassName($this->milliards, $triade);
                    break;
            }
        }
        return $tempText;
    }

    private function addDigitClassName($digitClassArr, $lastNumber)
    {
        $tempText = "";
        switch ($lastNumber) {
            case 1:
                $tempText .= $digitClassArr[0] . " ";
                break;
            case 2:
            case 3:
            case 4:
                $tempText .= $digitClassArr[1] . " ";
                break;
            default:
                $tempText .= $digitClassArr[2] . " ";
                break;
        }
        return $tempText;
    }
}
