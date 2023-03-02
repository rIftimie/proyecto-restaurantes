import React from 'react'

function DrawerSubtotal(props) {
  return (
    <div className={`drawer ${props.isOpen ? 'open' : ''}`}>
      <p>Paypal</p>
      <p>Stripe</p>
    </div>
  )
}

export default DrawerSubtotal