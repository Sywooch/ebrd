<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
	public function actionPlus()
	{
		$auth = Yii::$app->authManager;
		
//		$perm = $auth->getPermission('translate');
		$role = $auth->getRole('publisher');
//		$auth->addChild($role, $perm);
		
		$perm = $auth->createPermission('createItem');
		$auth->add($perm);
		$auth->addChild($role, $perm);
	}

	public function actionTranslator()
	{
		$auth = Yii::$app->authManager;
		
		$editor = $auth->getRole('editor');
		$translate = $auth->getPermission('translate');
		$auth->removeChild($editor, $translate);
		
		$translatorUa = $auth->getRole('translatorUa');
		$translatorPl = $auth->getRole('translatorPl');
		$translatorPt = $auth->getRole('translatorPt');
		$translatorTr = $auth->getRole('translatorTr');
		$translatorZh = $auth->getRole('translatorZh');
		$translatorEn = $auth->getRole('translatorEn');
		
		$auth->addChild($translatorEn, $translate);
		$auth->addChild($translatorZh, $translate);
		$auth->addChild($translatorPt, $translate);
		$auth->addChild($translatorPl, $translate);
		$auth->addChild($translatorUa, $translate);
		$auth->addChild($translatorTr, $translate);
	}

	public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // add "editItem" permission
        $editItem = $auth->createPermission('editItem');
        $editItem->description = 'Create and edit a item';
        $auth->add($editItem);

        // add "deleteItem" permission
        $deleteItem = $auth->createPermission('deleteItem');
        $deleteItem->description = 'Delete item';
        $auth->add($deleteItem);

		// add "translate" permission
		$translate = $auth->createPermission('translate');
		$translate->description = 'Allow to add translations';
		$auth->add($translate);
		
		// add "viewItem" permission
		$viewItem = $auth->createPermission('viewItem');
		$viewItem->description = 'Just view item';
		$auth->add($viewItem);
		
		// add "registered" role and give this role "viewItem" permission
		$registered = $auth->createRole('registered');
		$auth->add($registered);
		$auth->addChild($registered, $viewItem);
		
		// add "viewItem" permission to everyone, who have  "editItem" permission
		
		// add "translator" role and give this role "translate" permission
		$translator = $auth->createRole('translator');
		$auth->add($translator);
		$auth->addChild($translator, $translate);
		
        // add "editor" role and give this role the "editItem" permission
        // as well as the permissions of the "translator" role
        $editor = $auth->createRole('editor');
        $auth->add($editor);
        $auth->addChild($editor, $editItem);
		$auth->addChild($editor, $translator);
		
        // add "admin" role and give this role the "delete" permission
        // as well as the permissions of the "editor" and "translator" roles
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $deleteItem);
        $auth->addChild($admin, $editor);
		$auth->addChild($admin, $translator);

        // Assign roles to users. 5, 6, 7 and 8 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($admin, 22);
        $auth->assign($editor, 3);
		$auth->assign($translator, 7);
		$auth->assign($registered, 8);
    }
	
	/*
	 * Allow to view item to everyone, who can translate it
	 */
	public function actionFix()
	{
		$auth = Yii::$app->authManager;
		
		$superuser = $auth->getRole('editor');
		$role = $auth->createPermission('translate');
		$auth->add($role);
		$auth->addChild($superuser, $role);
	}
	
	public function actionSu($userId)
	{
		$auth = \Yii::$app->authManager;
		$admin = $auth->getRole('superuser');
		$auth->assign($admin, $userId);
	}
	
	public function actionExtra()
	{
		Yii::$app->authManager->removeAll();
		$this->createRoles();
		$this->createPermissions();
		$this->assignPermissions();
	}
	
	private function createRoles()
	{
		$auth = Yii::$app->authManager;
		
		$registered = $auth->createRole('registered');
		$auth->add($registered);
		
		$superuser = $auth->createRole('superuser');
		$auth->add($superuser);
		
		$admin = $auth->createRole('admin');
		$auth->add($admin);
		
		$publisher = $auth->createRole('publisher');
		$auth->add($publisher);
		
		$editor = $auth->createRole('editor');
		$auth->add($editor);
		
		$manager = $auth->createRole('manager');
		$auth->add($manager);
		
		$client = $auth->createRole('client');
		$auth->add($client);
		
		$translatorEn = $auth->createRole('translatorEn');
		$auth->add($translatorEn);
		
		$translatorUa = $auth->createRole('translatorUa');
		$auth->add($translatorUa);	
		
		$translatorPl = $auth->createRole('translatorPl');
		$auth->add($translatorPl);	
		
		$translatorPt = $auth->createRole('translatorPt');
		$auth->add($translatorPt);	
		
		$translatorTr = $auth->createRole('translatorTr');
		$auth->add($translatorTr);	
		
		$translatorTr = $auth->createRole('translatorZh');
		$auth->add($translatorTr);	
		
	}
	
	private function createPermissions()
	{
		$auth = Yii::$app->authManager;
			
		// add "viewItem" permission
		$permission = $auth->createPermission('viewItem');
		$permission->description = 'Allow to View Item';
		$auth->add($permission);
		
		// add "translate_en" permission
		$permission = $auth->createPermission('translate_en');
		$permission->description = 'Allow translate to English';
		$auth->add($permission);
		
		// add "translate_en" permission
		$permission = $auth->createPermission('translate_ua');
		$permission->description = 'Allow translate to Ukrainian';
		$auth->add($permission);
		
		// add "translate_en" permission
		$permission = $auth->createPermission('translate_tr');
		$permission->description = 'Allow translate to Turkish';
		$auth->add($permission);
		
		// add "translate_en" permission
		$permission = $auth->createPermission('translate_pl');
		$permission->description = 'Allow translate to Polish';
		$auth->add($permission);
		
		// add "translate_en" permission
		$permission = $auth->createPermission('translate_pt');
		$permission->description = 'Allow translate to Portuguese';
		$auth->add($permission);
		
		// add "translate_en" permission
		$permission = $auth->createPermission('translate_zh');
		$permission->description = 'Allow translate to Chinese';
		$auth->add($permission);
		
		// add "editItem" permission
		$permission = $auth->createPermission('editItem');
		$permission->description = 'Allow to edit items';
		$auth->add($permission);
		
		// add "publishItem" permission
		$permission = $auth->createPermission('publishItem');
		$permission->description = 'Allow to edit items';
		$auth->add($permission);
		
		// add "deleteItem" permission
		$permission = $auth->createPermission('deleteItem');
		$permission->description = 'Allow to edit items';
		$auth->add($permission);
		
		// add "clientActions" permission
		$permission = $auth->createPermission('clientActions');
		$permission->description = 'Allow to edit items';
		$auth->add($permission);
		
		// add "managerActions" permission
		$permission = $auth->createPermission('managerActions');
		$permission->description = 'Allow to edit items';
		$auth->add($permission);
		
		// add "manageUsers" permission
		$permission = $auth->createPermission('manageUsers');
		$permission->description = 'Allow to edit items';
		$auth->add($permission);
		
		// add "manageSuperusers" permission
		$permission = $auth->createPermission('manageSuperusers');
		$permission->description = 'Allow to edit items';
		$auth->add($permission);
	}
	
	private function assignPermissions()
	{
		$auth = Yii::$app->authManager;
		
		// Assign to "registered" role "viewItem" permisssions
		$registered = $auth->getRole('registered');
		$permission = $auth->getPermission('viewItem');
		$auth->addChild($registered, $permission);
		
		
		// Assign permissions to translators
		$role = $auth->getRole('translatorEn');
		$permission = $auth->getPermission('translate_en');
		$auth->addChild($role, $permission);
		
		$role = $auth->getRole('translatorUa');
		$permission = $auth->getPermission('translate_ua');
		$auth->addChild($role, $permission);
		
		$role = $auth->getRole('translatorPl');
		$permission = $auth->getPermission('translate_pl');
		$auth->addChild($role, $permission);
		
		$role = $auth->getRole('translatorPt');
		$permission = $auth->getPermission('translate_pt');
		$auth->addChild($role, $permission);
		
		$role = $auth->getRole('translatorTr');
		$permission = $auth->getPermission('translate_tr');
		$auth->addChild($role, $permission);
		
		$role = $auth->getRole('translatorZh');
		$permission = $auth->getPermission('translate_zh');
		$auth->addChild($role, $permission);
		
		// Assign children and permissions for "editor"
		$editor = $auth->getRole('editor');
		
		$child = $auth->getRole('translatorEn');
		$auth->addChild($editor, $child);
		
		$child = $auth->getRole('translatorUa');
		$auth->addChild($editor, $child);
		
		$child = $auth->getRole('translatorPl');
		$auth->addChild($editor, $child);
		
		$child = $auth->getRole('translatorPt');
		$auth->addChild($editor, $child);
		
		$child = $auth->getRole('translatorTr');
		$auth->addChild($editor, $child);
		
		$child = $auth->getRole('translatorZh');
		$auth->addChild($editor, $child);
		
		$permission = $auth->getPermission('editItem');
		$auth->addChild($editor, $permission);
	
		// Assign permissions for "client"
		$client = $auth->getRole('client');
		$permission = $auth->getPermission('clientActions');
		$auth->addChild($client, $permission);
		
		// Assign permissions for "manager"
		$manager = $auth->getRole('manager');
		$permission = $auth->getPermission('managerActions');
		$auth->addChild($manager, $permission);
		
		// Assign permissions for "publisher"
		$publisher = $auth->getRole('publisher');
		
		$permission = $auth->getPermission('publishItem');
		$auth->addChild($publisher, $permission);
		
		$permission = $auth->getPermission('deleteItem');
		$auth->addChild($publisher, $permission);
		
		// Assign permissions for "admin"
		$admin = $auth->getRole('admin');
		$permission = $auth->getPermission('manageUsers');
		$auth->addChild($admin, $permission);
		
		// Assign children for "superuser"
		$superuser = $auth->getRole('superuser');
		$auth->addChild($superuser, $registered);
		$auth->addChild($superuser, $client);
		$auth->addChild($superuser, $manager);
		$auth->addChild($superuser, $editor);
		$auth->addChild($superuser, $publisher);
		$auth->addChild($superuser, $admin);
	}
}