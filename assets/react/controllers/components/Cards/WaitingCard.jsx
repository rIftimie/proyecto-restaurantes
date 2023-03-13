import React from 'react'

const WaitingCard = ({ orderId }) => {
  return (
    <div style={{width: "450px"}} className="my-5 mx-auto p-1 w-75 border rounded-2 bg-success">
      <h2 className='text-center'>Su número de pedido es el:</h2>
      <h1 className='text-center'>{ orderId }</h1>
    </div>
  )
}

export default WaitingCard