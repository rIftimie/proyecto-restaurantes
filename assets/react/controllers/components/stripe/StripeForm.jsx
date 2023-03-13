import { CardElement, useElements, useStripe } from '@stripe/react-stripe-js';
import React, { useState } from 'react';
import { payOrder2 } from '../../helpers/pay';

const StripeForm = ({ orderId, orderProducts }) => {
  const [waiting, setWaiting] = useState(false);
	const stripe = useStripe();
	const elements = useElements();
	const handleSubmit = async (e) => {
    setWaiting(true);
    document.querySelector('.formPayment').classList.add('d-none');
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
							`http://localhost:8000/orders/${orderId}/watch`;
					}
				})
				.catch((error) => {
					console.log(error);
				});
		}
	};
	return (
		<>
      <form onSubmit={handleSubmit} className='formPayment'>
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
    {
      waiting && <h3>Loading...</h3>
    }

    </>
	);
};

export default StripeForm;
