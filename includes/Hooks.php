<?php

/**
 * Hooks for NewUserEcho Extension
 */

use MediaWiki\MediaWikiServices;

class Hooks {

	/**
	 * Add event for account creation to Echo
	 *
	 * @param array &$notifications array of Echo notifications
	 * @param array &$notificationCategories array of Echo notification categories
	 * @param array &$icons array of icon details
	 *
	 */
	public static function onBeforeCreateEchoEvent(
		&$notifications, &$notificationCategories, &$icons
	) {
		$notificationCategories['new-user-echo'] = [
			'priority' => 3,
			'tooltip' => 'echo-pref-tooltip-new-user-created',
		];

		// Define the event
		$notifications['new-user-echo'] = [
			'category' => 'new-user-echo',
			'group' => 'positive',
			'section' => 'alert',
			'presentation-model' => EchoCoreNewUserPresentationModel::class,
			'bundle' => [
				'web' => false,
				'email' => false,
				'expandable' => false,
			],
			'user-locators' => [ 'NewUserEcho::locateUsersInList' ],
		];
	}

	/**
	 * Hook account creation
	 *
	 * @param User $user User that was created
	 * @param bool $autocreated Whether this was an auto-created account
	 */
	public static function onLocalUserCreated( $user, $autocreated ) {
		// Creating Echo event to send notification to Editors and Sysops
		EchoEvent::create( [ 'type' => 'new-user-echo' ] );

		# Opt in automatically for notification if new user in group editor or sysop
		$groups = $user->getGroups();
		if ( !$autocreated && ( in_array( 'sysop', $groups ) || in_array( 'editor', $groups ) ) {
			$userOptionsManager = MediaWikiServices::getInstance()->getUserOptionsManager();
			$userOptionsManager->setOption( $user, 'echo-subscriptions-email-newuser', true );
			$userOptionsManager->saveOptions( $user );
		}
	}
}
