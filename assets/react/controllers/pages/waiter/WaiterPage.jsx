import React, { useEffect, useState } from 'react'
import { getOrders } from '../../api/orders'

function WaiterPage({orders}) {

  const [order, setOrder] = useState(second)

   const fetchGetProduct = async () =>{
    try {
      const response = await getOrders();
      setOrder(response);
    } catch (error) {
      console.log(error);
    }

  }

  useEffect(() => {

    fetchGetProduct()
    
  }, [])
  

  return (
    <>
    
    
    </>
  )
}

export default WaiterPage