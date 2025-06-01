<?php

use yii\console\Application as ConsoleApplication;
use yii\web\Application as WebApplication;
use yii\web\User;

class Yii
{
    public static ConsoleApplication|__Application|WebApplication $app;
}

/**
 * @property User|__WebUser $user
 *
 */
class __Application
{
}

/**
 * @property app\models\Identity $identity
 */
class __WebUser
{
}
