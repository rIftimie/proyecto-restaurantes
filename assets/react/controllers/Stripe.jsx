import React from 'react'
import { loadStripe } from '@stripe/stripe-js'
import { Elements } from '@stripe/react-stripe-js';
import StripeForm from './StripeForm';

const stripePromise = loadStripe('pk_test_51MZHIPAek27wJPNXWbKoI35L1X1xoQrGydSmkdnwvf3h81m9DEmrlgbmiLcd66cPSESr5XFyvoBD2kO2rf2GhDkC009v3wNISy');

const Stripe = () => {
  return (
    <Elements stripe={stripePromise}>
      <StripeForm />
    </Elements>
  )
}

export default Stripe