<?php

namespace lloc\NowpaymentsIntegration\Rest;

class Service {

	private string $url;

	public function __construct( string $url ) {
		$this->url = trailingslashit( $url );
	}

	public function add_query_arg( array $args, string $endpoint ) {
		return esc_url( add_query_arg( $args, $this->url . $endpoint ) );
	}

}