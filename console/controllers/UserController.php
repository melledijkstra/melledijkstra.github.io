<?php

namespace console\controllers;


use common\models\User;
use yii\console\Controller;

class UserController extends Controller
{

    /**
     * Creates a user account with information given
     */
    public function actionCreateUser()
    {
        $userInfo = [];
        $userInfo['username'] = $this->prompt('Choose username:');
        $userInfo['email'] = $this->prompt('Choose email:');
        $userInfo['role'] = $this->prompt('Choose role (0,1):', [0, 1]);
        $userInfo['password'] = $this->prompt('Choose password:');

        foreach ($userInfo as $key => $value) {
            if (empty($value)) {
                echo "$key can't be empty!";
                exit;
            }
        }

        $user = new User([
            'username' => $userInfo['username'],
            'email' => $userInfo['email'],
            'password' => $userInfo['password'],
            'role' => $userInfo['role'],
        ]);

        $user->generateAuthKey();
        if ($user->save()) {
            echo "user '$user->username' created (role: $user->role)";
        } else {
            var_dump($user->errors);
            echo 'Some info was incorrect, try again...';
        }
    }

    /**
     * Change the password of a user
     */
    public function actionChangePassword()
    {
        $usernameOrEmail = $this->prompt('Username of email of user:');
        /** @var User $user */
        $user = User::find()->where([
            'OR',
            ['username' => $usernameOrEmail],
            ['email' => $usernameOrEmail],
        ])->one();

        if ($user === null) {
            echo 'User with this email or username does not exist';
        } else {
            echo "User found (username: $user->username, email: $user->email)\n";
            $password = $this->prompt('Type new password:');
            if (empty($password)) {
                echo "Password is empty\n";
                exit;
            }
            $user->setPassword($password);
            if ($user->save()) {
                echo "Password changed correctly\n";
            } else {
                echo 'Something went wrong';
                print_r($user->errors);
            }
        }
    }

}