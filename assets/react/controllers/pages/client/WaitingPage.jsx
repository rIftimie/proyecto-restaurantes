import React from 'react'

const WaitingPage = ({ orderId }) => {
  return (
    <div>
      <h1>Su número de pedido es el:</h1>
      <h1>{ orderId }</h1>
    </div>
  )
}

export default WaitingPage