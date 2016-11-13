<?php
/**
 * Created by PhpStorm.
 * User: melle
 * Date: 13-11-2016
 * Time: 00:24
 */

namespace console\controllers;


use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class RbacController extends Controller
{
    /**
     * Sets up the RBAC rules for this application
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        if($this->confirm('Remove all authorization data, including (roles,permissions,rules,assignments)', false)) {
            $auth->removeAll();
            $this->stdout("\n[".date('H:i:s')."] removed all authorization data\n", Console::FG_YELLOW);
        }

        // Default user can browse projects and guides, and comment
        $userRole = $auth->createRole('user');
        $auth->add($userRole);
        $this->stdout("[".date('H:i:s')."] user role created\n", Console::FG_GREEN);

        // Admin can CRUD projects and guides
        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);
        $this->stdout("[".date('H:i:s')."] admin role created\n", Console::FG_GREEN);

        // Admin has all privileges that user has and/or more
        $auth->addChild($adminRole, $userRole);
        $this->stdout("[".date('H:i:s')."] created hierarchy\n", Console::FG_GREEN);

    }
}