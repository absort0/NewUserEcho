<?php

class NewUserEcho {

	/**
	 * @param EchoEvent $event
	 * @return array
	 */
	public function locateUsersInList( EchoEvent $event ) {
		// Get the list of users
		$userIds = $this->getList( $event )->getUsers();

		// TODO: Check if users are in either in sysop or editor group
		return array_map( function ( $userId ) {
			return User::newFromId( $userId );
		}, $userIds );
	}

	public static function locateUsersInList() {
	}

}
