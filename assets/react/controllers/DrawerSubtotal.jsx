import React from 'react'

function DrawerSubtotal(props) {
  return (
    <div className={`drawer ${props.isOpen ? 'open' : ''}`}>
      <p>Pago con tarjeta</p>
      <p>Paypal</p>
      <p>Pago en efectivo</p>
    </div>
  )
}

export default DrawerSubtotal