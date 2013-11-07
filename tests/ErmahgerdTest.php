<?php

use Ermahgerd\Ermahgerd;

class StackTest extends PHPUnit_Framework_TestCase
{
    
    public function testTranslate()
    {

    	$ermahgerd = new Ermahgerd();

        foreach ( Ermahgerd::getReservedTerms() as $k => $v ) {
            $this->assertEquals($v, $ermahgerd->translate($k));
        }

    	$this->assertEquals('WER', $ermahgerd->translate('WE'));
    	$this->assertEquals('DERN', $ermahgerd->translate('DOWN'));
    	$this->assertEquals('PERNCERKS', $ermahgerd->translate('PANCAKES'));
    	$this->assertEquals('ER', $ermahgerd->translate('OH'));
    	$this->assertEquals('MAH', $ermahgerd->translate('MY'));
    	$this->assertEquals('FERLIN', $ermahgerd->translate('FALLING'));
    	$this->assertEquals('PERPED', $ermahgerd->translate('POOPED'));
    	$this->assertEquals('MERM', $ermahgerd->translate('MEME'));
    	$this->assertEquals('YERS', $ermahgerd->translate('YES'));
    	$this->assertEquals('YERLO', $ermahgerd->translate('YELLOW'));

        $english = file_get_contents(__DIR__ . '/_resources/acorn.txt');
        $erm = file_get_contents(__DIR__ . '/_resources/acorn_erm.txt');

        $translated = $ermahgerd->translate($english);

        $this->assertEquals($erm, $translated);

    }

}