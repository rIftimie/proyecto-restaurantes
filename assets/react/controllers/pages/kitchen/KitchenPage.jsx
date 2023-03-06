import React, { useEffect, useState, useCallback } from 'react'
import { async } from 'regenerator-runtime';
import { acceptOrder, declineOrder, finishOrder, getOrders } from '../../api/orders'
import OrderContainer from '../../components/OrderContainer'

const KitchenPage = () => {

    const [orders, setOrder] = useState([]);

    const fetchGetOrders = async () =>{
     try {
       const response = await getOrders();
       setOrder(response.filter(order => order.status == 1 || order.status == 2));
      
       console.log(response.filter(order => order.status == 1 || order.status == 2));
     } catch (error) {
       console.log(error);
     }
 
   }

   async function handleAccept(od){
    try {
      await acceptOrder(od);
      setOrder(orders.map(order => od.id == order.id ? {...order, status: 2} : order));
    } catch (error) {
      console.error(error);
    }
  }

  async function handleFinish(od){
    try {
      await finishOrder(od);
      setOrder(orders.map(order => od.id == order.id ? {...order, status: 3} : order));
    } catch (error) {
      console.error(error);
    }
  }

  async function handleDecline(od){
    try {
      await declineOrder(od);
      setOrder(orders.map(order => od.id == order.id ? {...order, status: 5} : order))
    } catch (error) {
      console.error(error);
    }
  }
 
   useEffect(() => {
 
     fetchGetOrders()
     
   }, [])
   
  return (
    <div>
    {orders.length > 0  ?  <OrderContainer data={orders} onHandleAccept={handleAccept} onHandleFinish={handleFinish} onHandleDecline={handleDecline}/> : <h1>Loading ...</h1>}
    </div>
  

  )
}

export default KitchenPage;