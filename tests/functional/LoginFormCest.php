<?php

use app\models\Identity;
use Codeception\Exception\ModuleException;

class LoginFormCest
{
    public function _before(FunctionalTester $I): void
    {
        $I->amOnRoute('site/login');
    }

    public function openLoginPage(FunctionalTester $I): void
    {
        $I->see('Login', 'h1');

    }

    // demonstrates `amLoggedInAs` method

    /**
     * @throws ModuleException
     */
    public function internalLoginById(FunctionalTester $I): void
    {
        $I->amLoggedInAs(100);
        $I->amOnPage('/');
        $I->see('Logout (admin)');
    }

    // demonstrates `amLoggedInAs` method

    /**
     * @throws ModuleException
     */
    public function internalLoginByInstance(FunctionalTester $I): void
    {
        $I->amLoggedInAs(Identity::findByUsername('admin'));
        $I->amOnPage('/');
        $I->see('Logout (admin)');
    }

    public function loginWithEmptyCredentials(FunctionalTester $I): void
    {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function loginWithWrongCredentials(FunctionalTester $I): void
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'admin',
            'LoginForm[password]' => 'wrong',
        ]);
        $I->expectTo('see validations errors');
        $I->see('Incorrect username or password.');
    }

    public function loginSuccessfully(FunctionalTester $I): void
    {
        $I->submitForm('#login-form', [
            'LoginForm[username]' => 'admin',
            'LoginForm[password]' => 'admin',
        ]);
        $I->see('Logout (admin)');
        $I->dontSeeElement('form#login-form');              
    }
}