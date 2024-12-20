<?php

namespace lloc\Nowpayments\Services;

use lloc\Nowpayments\Integration\ApiStatus;

class ApiStatusService {

	public function __construct(
		private readonly ApiStatus $api_status
	) { }

	/**
	 * @return array<string, string>
	 */
	public function get_data(): array {
		$response = $this->api_status->get();

		return array(
			'status' => $response->get()['message'] ?? 'ko',
			'info'   => $this->api_status->get_client()->get_service()->info(),
		);
	}
}
