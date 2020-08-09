<?php
/**
 */

namespace execut\cms\console;

use execut\cms\models\User;
use yii\console\Controller;
use yii\console\Exception;

class UsersController extends Controller
{
    public function actionCreateAdmin($login = 'admin', $password = 'password', $email = 'email@email.com') {
        $user = $this->findUserByLogin($login);
        if ($user) {
            throw new Exception('User with login ' . $login . ' is already exists');
        }
        $user = new User();
        $user->attributes = [
            'username' => $login,
            'password' => $password,
            'status' => User::STATUS_ACTIVE,
            'email' => $email,
        ];
        $user->generateAuthKey();
        if (!$user->save()) {
            throw new Exception('Failed to create user. Errors: ' . var_export($user->errors, true));
        }
    }

    public function actionDeleteAdmin($login = 'admin') {
        $user = $this->findUserByLogin($login);
        if (!$user) {
            throw new Exception('User with username "' . $login . " is not founded");
        }

        $user->delete();
    }

    /**
     * @param string $login
     * @return User|null
     */
    protected function findUserByLogin(string $login)
    {
        $user = User::findByUsername($login);
        return $user;
    }
}