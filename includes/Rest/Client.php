<?php

namespace lloc\NowpaymentsIntegration\Rest;

class Client {

	private Service $service;

	public function __construct( Service $service ) {
		$this->service = $service;
	}

	public function get( string $endpoint, array $args = [] ): object {
		return new Response( wp_remote_get( $this->service->add_query_arg( $args, $endpoint ) ) );
	}

	public function post( string $endpoint, array $args = [] ): object {
		return new Response( wp_remote_post( $this->service->add_query_arg( $args, $endpoint ) ) );
	}

}