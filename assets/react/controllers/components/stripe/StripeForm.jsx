import { CardElement, useElements, useStripe } from '@stripe/react-stripe-js';
import React from 'react';
import { payOrder2 } from '../../helpers/pay';

const StripeForm = ({ orderId, orderProducts }) => {
	const stripe = useStripe();
	const elements = useElements();
	const handleSubmit = async (e) => {
		e.preventDefault();
		const { error, paymentMethod } = await stripe.createPaymentMethod({
			type: 'card',
			card: elements.getElement(CardElement),
		});

		if (!error) {
			const id = paymentMethod.id;
			const amount = orderProducts.reduce((acc, obj)=> acc + obj.price*obj.quantity,0)*100;
			const description = 'Pago del pedido 1';
			await payOrder2( orderId, { amount, description, id, orderProducts })
				.then((response) => {
					if (response.ok) {
						window.location.href =
							`http://localhost:8000/orders/${orderId}/completed`;
					}
				})
				.catch((error) => {
					console.log(error);
				});
		}
	};
	return (
		<form onSubmit={handleSubmit}>
			<div className="form-group">
				<CardElement className="text-black form-control" />
			</div>
			<button
				onClick={handleSubmit}
				type="button"
				className="btn btn-outline-success"
			>
				Pagar
			</button>
		</form>
	);
};

export default StripeForm;
