<?php

class NewUserEcho {

	/**
	 * @param EchoEvent $event
	 * @return array
	 */
	public function locateUsersInList( EchoEvent $event ) {
		// Get the list of users
		// FIXME: not sure which users the event will have, in any case we can get all registered users
		$userIds = $this->getList( $event )->getUsers();

		// Only users members of the sysop and editor groups should be notified
		return array_map( function ( $userId ) {
			$user = User::newFromId( $userId );
			$groups = $user->getEffectiveGroups();
			if ( in_array( 'sysop', $groups ) || in_array( 'editor', $groups ) ) {
				return $user;
			}
		}, $userIds );
	}
}
