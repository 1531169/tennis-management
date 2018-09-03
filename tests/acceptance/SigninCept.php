<?php 
$I = new AcceptanceTester($scenario);
$I->am('player');
$I->wantTo('login to website');
$I->lookForwardTo('access website features for logged-in players');
$I->amOnPage('/login');
$I->fillField('username', 'c.reinhard');
$I->fillField('password', 'fisch');
$I->click('Login');
$I->see('Dashboard', '.row');