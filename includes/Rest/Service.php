<?php

namespace lloc\NowpaymentsIntegration\Rest;

class Service {

	private string $url;

	public function __construct( string $url ) {
		$this->url = $url;
	}

	public function get( string $endpoint ) {
		return esc_url( trailingslashit( $this->url ) . $endpoint );
	}

}