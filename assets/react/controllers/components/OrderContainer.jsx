import React from 'react'
import OrderCard from './OrderCard'

function OrderContainer({orders}) {
  return (
    
    <div>{
    
        orders.map( (order) =>{
          <OrderCard key={order.id} orderData={order}/>
          
        })
      
    }</div>
  )
}

export default OrderContainer