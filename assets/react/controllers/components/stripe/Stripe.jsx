import React from 'react'
import { loadStripe } from '@stripe/stripe-js'
import StripeForm from './StripeForm';
import { Elements } from '@stripe/react-stripe-js';

const Stripe = ({ stripeKey, orderId }) => {
	const stripePromise = loadStripe(stripeKey);
	return (
		<Elements stripe={stripePromise}>
			<StripeForm orderId={ orderId } />
		</Elements>
	);
};


export default Stripe