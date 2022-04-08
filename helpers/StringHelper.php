<?php

namespace app\helpers;

class StringHelper
{
	/**
	 * Преобразование числа в строковое представление
	 *
	 * @param int $val Целое число
	 *
	 * @return string
	 */
	public static function convertToString(int $val)
	{
		$bit = 38; // 64
		$result = '';
		$range = '0123456789_abcdefghijklmnopqrstuvwxyz-ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		do $result .= $range[$val % $bit];
		while (($val /= $bit) >= 1);
		return strrev($result);
	}
}
