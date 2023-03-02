import { CardElement } from '@stripe/react-stripe-js'
import React from 'react'

const StripeForm = () => {
  return (
    <form>
      <CardElement/>
    </form>
  )
}

export default StripeForm