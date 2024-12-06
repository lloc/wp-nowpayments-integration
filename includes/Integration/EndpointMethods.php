<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Integration;

enum EndpointMethods: string {

	case ApiStatus            = 'v1/status';
	case AvailableCurrencies  = 'v1/currencies';
	case EstimatedPrice       = 'v1/estimate';
	case MinimumPaymentAmount = 'v1/min-amount';
	case Payment              = 'v1/payment';
	case PaymentStatus        = 'v1/payment/%s';
}
