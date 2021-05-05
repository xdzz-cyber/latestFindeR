<?php

require_once __DIR__ ."/../model/ClientUser.php";

use PHPUnit\Framework\TestCase;


class UserTest extends TestCase
{

    protected function setUp(): void
    {
    }

    protected function tearDown(): void
    {
    }


    public function clientsEmailProvider(): array
    {
        return [
            ["firstClient@gmail.com"],
            ["secondClient@gmail.com"]
        ];
    }

    /**
     * @dataProvider clientsEmailProvider
     * @param $emails
     */


    public function testUserExistsByEmail($emails){
        foreach (func_get_args() as $email){
            $emailExists = ClientUser::findUserByEmail($email)["client_email"];
            $this->assertIsString($emailExists);
        }
    }
}