import React, { useEffect, useState } from 'react'
import { getOrders } from '../../api/orders'
import OrderContainer from '../../components/OrderContainer'

const KitchenPage = () => {

    const [orders, setOrder] = useState([])

    const fetchGetOrders = async () =>{
     try {
       const response = await getOrders();
       setOrder(response.filter(order => order.status == 1 || order.status == 2));
      
       console.log(response.filter(order => order.status == 1 || order.status == 2));
     } catch (error) {
       console.log(error);
     }
 
   }
 
   useEffect(() => {
 
     fetchGetOrders()
     
   }, [])
   
  return (
    <div>
    {orders.length > 0  ?  <OrderContainer data={orders}/> : <h1>Loading ...</h1>}
    </div>
  

  )
}

export default KitchenPage