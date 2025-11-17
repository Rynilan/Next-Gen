<?php
use PHPUnit/Framework/TestCase;

public class LoginTest extends TestCase {
	public function testInvalidEmail() {
		$false = false;
		$pass = '12345678';
		$okay = true;
		$false |= valid_data('@.com', $pass, $okay);	
		$false |= valid_data('test@.com', $pass, $okay);	
		$false |= valid_data('@mail.com', $pass, $okay);	
		$false |= valid_data('testmail.com', $pass, $okay);	
		$false |= valid_data('test@mailcom', $pass, $okay);	
		$this->assertFalse(false, $false);
	}
}

?>
