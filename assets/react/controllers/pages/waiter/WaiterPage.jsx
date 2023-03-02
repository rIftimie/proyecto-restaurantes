import React, { useEffect, useState } from 'react'
import { getOrders } from '../../api/orders'
import OrderContainer from '../../components/OrderContainer'
function WaiterPage() {
  const [orders, setOrder] = useState([])

   const fetchGetProduct = async () =>{
    try {
      const response = await getOrders();
      setOrder(response);
     
      console.log(response);
    } catch (error) {
      console.log(error);
    }

  }

  useEffect(() => {

    fetchGetProduct()
    
  }, [])
  

  return (
    <>
      {/* <OrderContainer orders={orders}/> */}
     
    
    </>
  )
}

export default WaiterPage