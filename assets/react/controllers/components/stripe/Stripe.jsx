import React from 'react';
import { loadStripe } from '@stripe/stripe-js';
import StripeForm from './StripeForm';
import { Elements } from '@stripe/react-stripe-js';

const Stripe = ({ stripeKey, orderId, orderProducts }) => {
	const stripePromise = loadStripe(stripeKey);
	return (
		<Elements stripe={stripePromise}>
			<StripeForm orderId={ orderId } orderProducts={orderProducts} />
		</Elements>
	);
};

export default Stripe;
