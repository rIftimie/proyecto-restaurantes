import { CardElement, useElements, useStripe } from '@stripe/react-stripe-js'
import axios from 'axios';
import React from 'react'
import { payOrder2 } from './api/pay';

const StripeForm = () => {
  const stripe = useStripe();
  const elements = useElements();
  const handleSubmit = async (e) => {
    e.preventDefault();
    const {error, paymentMethod} = await stripe.createPaymentMethod({
      type: 'card',
      card: elements.getElement(CardElement),
    })

    if(!error){
      const id= paymentMethod.id;
      const amount = 800;
      const description = "Pago del pedido 1";
      await payOrder2({ amount , description , id  }) 
      .then((response) => {
        window.location.href = 'http://localhost:8000/orders/completed'
      })
      .catch((error) => {
        console.log(error);
      })
    }
  }
  return (
    <form onSubmit={handleSubmit}>
      <div className='form-group'>
        <CardElement className='form-control text-black'/>
      </div>
      <button
          onClick={handleSubmit}
          type="button"
          className="btn btn-outline-success"
        >
          Pagar
        </button>
    </form>
  )
}

export default StripeForm