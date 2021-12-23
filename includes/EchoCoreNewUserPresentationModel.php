<?php

class EchoCoreNewUserPresentationModel extends EchoEventPresentationModel {
	public function canRender() {
		return true;
	}

	public function getIconType() {
		return 'user-rights-progressive';
	}

	public function getHeaderMessage() {
		$msg = $this->getMessageWithAgent( 'notification-header-newuser' );
		$msg->params( $this->getTruncatedTitleText( $this->event->getTitle(), true ) );
		$msg->params( $this->getViewingUserForGender() );
		return $msg;
	}

	public function getPrimaryLink() {
		return $this->getPageLink(
			$this->getSpecial( 'Special:ListUsers' ),
			'newuserecho-special-listusers',
			true
		);
	}

}
