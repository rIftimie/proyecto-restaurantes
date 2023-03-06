import React, { useEffect, useState, useCallback } from 'react'
import { async } from 'regenerator-runtime';
import { acceptOrder, declineOrder, finishOrder, getOrders } from '../../api/orders'
import KitchenOrderContainer from './KitchenOrderContainer';

const KitchenPage = () => {

    const [orders, setOrder] = useState([]);

    const fetchGetOrders = async () =>{
     try {
       const response = await getOrders();
       setOrder(response.filter(order => order.status == 1 || order.status == 2));
     } catch (error) {
       console.log(error);
     }
 
   }

   async function handleAccept(order){
    try {
      await acceptOrder(order);
      setOrder(orders.map(item => order.id == item.id ? {...item, status: 2} : item));
    } catch (error) {
      console.error(error);
    }
  }

  async function handleFinish(order){
    try {
      await finishOrder(order);
      setOrder(orders.filter(item => order != item));
    } catch (error) {
      console.error(error);
    }
  }

  async function handleDecline(order){
    try {
      await declineOrder(order);
      setOrder(orders.filter(item => order != item))
    } catch (error) {
      console.error(error);
    }
  }
 
   useEffect(() => {
 
     fetchGetOrders()
     
   }, [])
   
  return (
    <div>
    {orders.length > 0  ?  <KitchenOrderContainer data={orders} onHandleAccept={handleAccept} onHandleFinish={handleFinish} onHandleDecline={handleDecline}/> : <h1>Loading ...</h1>}
    </div>
  

  )
}

export default KitchenPage;