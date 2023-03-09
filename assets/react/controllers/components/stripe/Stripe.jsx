import React from 'react';
import { loadStripe } from '@stripe/stripe-js';
import StripeForm from './StripeForm';
import { Elements } from '@stripe/react-stripe-js';

const Stripe = ({ stripeKey }) => {
	const stripePromise = loadStripe(stripeKey);
	return (
		<Elements stripe={stripePromise}>
			<StripeForm />
		</Elements>
	);
};

export default Stripe;
