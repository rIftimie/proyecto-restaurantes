import React from 'react'
import Stripe from './Stripe'

function DrawerSubtotal(props) {
  return (
    <div className={`drawer ${props.isOpen ? 'open' : ''}`}>
      
      <p>Pago con tarjeta</p>
      <p>Pago en efectivo</p>
      <p>Paypal</p>
    </div>
  )
}

export default DrawerSubtotal