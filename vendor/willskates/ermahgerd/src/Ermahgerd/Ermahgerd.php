<?php

namespace Ermahgerd;

class Ermahgerd
{

	protected static $reserved = array(
		'AWESOME' => 'ERSUM',
	    'BANANA' => 'BERNERNER',
	    'BAYOU' => 'BERU',
	    'FAVORITE' => 'FRAVRIT',
	    'FAVOURITE' => 'FRAVRIT',
	    'GOOSEBUMPS' => 'GERSBERMS',
	    'LONG' => 'LERNG',
	    'MY' => 'MAH',
	    'THE' => 'DA',
	    'THEY' => 'DEY',
	    'WE\'RE' => 'WER',
	    'YOU' => 'U',
	    'YOU\'RE' => 'YER'
	);

	protected static $punctuation = array(
		'+',
		',',
		'.',
		'-',
		'\'',
		'"',
		'&',
		'!',
		'?',
		':',
		';',
		'#',
		'~',
		'=',
		'/',
		'$',
		'£',
		'^',
		'(',
		')',
		'{',
		'}',
		'_',
		'<',
		'>'
	);

	public static function getReservedTerms()
	{
		return self::$reserved;
	}

	public function translate($word)
	{
		$word = strtoupper($word);
		return $this->translateWord($word);
	}

	protected function translateWord($word)
	{
		
		if ( isset(self::$reserved[$word]) ) {
			return self::$reserved[$word];
		}

		if ( strpos($word, ' ') ) {

			$word = strtoupper($word);
			$word = explode(' ', $word);

			foreach ( $word as $k => $v ) {
				$word[$k] = $this->translateWord($v);
			}

			return implode(' ', $word);

		}

		$originalWord = $word;

		$prefix = false;
		$suffix = false;

		preg_match_all('/^\W+/', $word, $prefixes);
		preg_match_all('/\W+$/', $word, $suffixes);
		
		if ( isset($prefixes[0][0]) ) {
			$word = str_replace($prefixes[0], '', $word);
			$prefix = implode('', $prefixes[0]);
		} 

		if ( isset($suffixes[0][0]) ) {
			$word = str_replace($suffixes[0], '', $word);
			$suffix = implode('', $suffixes[0]);
		}

		$word = str_replace(self::$punctuation, '', $word);

		$len = strlen($word);

		if ( $len == 1 ) {
			return $word;
		}

		if ( $len > 2 ) {
			$word = preg_replace('/[AEIOU]$/', '', $word);
		}

		$word = preg_replace('{(.)\1+}',         '$1',    $word);
		$word = preg_replace('/[AEIOUY]{2,}/i',  'E',     $word);
		$word = preg_replace('/OW/', 			 'ER',    $word);
		$word = preg_replace('/AKES/', 			 'ERKS',  $word);
		$word = preg_replace('/[AEIOUY]/', 		 'ER',    $word);
		$word = preg_replace('/ERH/', 			 'ER',    $word);
		$word = preg_replace('/MER/', 			 'MAH',   $word);
		$word = preg_replace('/ERNG/', 			 'IN',    $word);
		$word = preg_replace('/ERPERD/', 		 'ERPED', $word);
		$word = preg_replace('/MAHM/', 			 'MERM',  $word);
		$word = preg_replace('/[AEIOUY]r(?! )/', 'E',     $word);

		if ( strlen($originalWord) && $originalWord[0] == 'Y' ) {
			$word = 'Y' . $word;
		}

		$word = preg_replace('{(.)\1+}', '$1', $word);

		if ( substr($originalWord,-3,3) == 'LOW' && substr($word, -3, 3) == 'LER' ) {
			$word = preg_replace('/LER$/', 'LO', $word);
		}

		if ( $prefix ) {
			$word = $prefix . $word;
		}

		if ( $suffix ) {
			$word .= $suffix;
		}

		$word = preg_replace('{(.)\1+}', '$1', $word);

		return $word;

	}

}