<?php

use Strukt\Ssl\{KeyPair, KeyPairBuilder, Cipher};
use PHPUnit\Framework\TestCase;

class CipherTest extends TestCase{

	public function setUp(){

		$this->message = "Hi, my is what? My is who? My name is (Tski tski) Slim Shady!";
	}

	public function testKeyPairBuilderEncryptDecrypt(){

		$builder = new KeyPairBuilder();

		$c = new Cipher($builder);
		$encrypted = $c->encrypt($this->message);
		$decrypted = $c->decrypt($encrypted);

		$builder->freeKey();

		$this->assertEquals($this->message, $decrypted);
	}

	public function testKeyPairEncrypDecryptNoPass(){

		$this->markTestSkipped('Requires private key file.');

		$path = sprintf("file:///%s", realpath("fixture/no-pass/pri.pem"));

		$keys = new KeyPair($path);

		$c = new Cipher($keys);
		$encrypted = $c->encrypt($this->message);
		$decrypted = $c->decrypt($encrypted);

		$keys->freeKey();

		$this->assertEquals($this->message, $decrypted);
	}

	public function testKeyPairEncryptDecryptWithPass(){

		$this->markTestSkipped('Requires private key file.');

		$path = sprintf("file:///%s", realpath("fixture/pass/pri.pem"));

		$keys = new KeyPair($path, "p@55w0rd");

		$c = new Cipher($keys);
		$encrypted = $c->encrypt($this->message);
		$decrypted = $c->decrypt($encrypted);

		$keys->freeKey();

		$this->assertEquals($this->message, $decrypted);
	}
}