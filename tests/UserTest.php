<?php declare(strict_types=1);
require __DIR__ . "/../src/User.php";
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{   
    public function testGetUsername(): void {
        $testUser = new User("Dave", "Dave@example.com");

        $username = $testUser->getUsername();

        $this->assertSame($username, "Dave");
    }

    public function testSetEmailWithCorrectFormat(): void {
        $testUser = new User("Dave", "Dave@example.com");

        $testUser->setEmail("valid@example.com");

        $reflection = new ReflectionClass($testUser);
        $property = $reflection->getProperty('email');
        $property->setAccessible(true);

        $this->assertEquals("valid@example.com", $property->getValue($testUser));
    }

    public function testSetEmailWithIncorrectFormat(): void {
        $testUser = new User("Dave", "Dave@example.com");

        $this->expectOutputString("Invalid email format");
        $testUser->setEmail("invalid-email");

        $reflection = new ReflectionClass($testUser);
        $property = $reflection->getProperty('email');
        $property->setAccessible(true);

        $this->assertEquals("Dave@example.com", $property->getValue($testUser));
    }

    public function testCheckIsAdmin(): void {
        $testUser = new User("Dave", "Dave@example.com");
        $testAdmin = new Admin("Frida", "Frida@example.com");

        $this->assertSame($testUser->checkIsAdmin(), false);
        $this->assertSame($testAdmin->checkIsAdmin(), true);
    }

    public function testAdminDeletingUser(): void {
        $testUser = new User("Henry", "Henry@example.com");
        $testAdmin = new Admin("Frida", "Frida@example.com");

        $this->expectOutputString("User Henry has been deleted");
        $testAdmin->deleteUser($testUser);
    }

    public function testUserAuthenticate(): void {
        $this->expectOutputString("User authenticated");
        User::authenticate();
    }

    public function testGuestUserAuthenticate(): void {
        $this->expectOutputString("Guest access granted");
        GuestUser::authenticate();
    }

    public function testGuestUserName(): void {
        $guestUser = new GuestUser();

        $username = $guestUser->getUsername();

        $this->assertSame($username, "Guest");
    }

    public function testAdminDisplayingUsers(): void {
        $testAdmin = new Admin("Frida", "Frida@example.com");

        ob_start();

        try {
            $testAdmin->displayUsers();
            $output = ob_get_clean();

            $expectedOutput = "Alice</br>Bob</br>Charlie</br>Anna</br>Gary</br>";

            $this->assertEquals($expectedOutput, $output);
        } catch (\Throwable $e) {
            if (ob_get_level() > 0) {
                ob_end_clean();
            }
            throw $e;
        }
    }

    public function testAdminCheckingUserRoles(): void {
        $testAdmin = new Admin("Frida", "Frida@example.com");

        ob_start();

        try {
            $testAdmin->checkUserRole();
            $output = ob_get_clean();

            $expectedOutput = "Alice is user</br>Bob is user</br>Charlie is user</br>Anna is admin</br>Gary is admin</br>";

            $this->assertEquals($expectedOutput, $output);
        } catch (\Throwable $e) {
            if (ob_get_level() > 0) {
                ob_end_clean();
            }
            throw $e;
        }
    }
}
