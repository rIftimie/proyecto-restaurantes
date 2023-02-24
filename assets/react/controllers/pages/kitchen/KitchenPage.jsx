import React, { useState } from 'react';
import OrderCard from './OrderCard';

function KitchenPage({ paidOrders }) {
  const [orders, setOrders] = useState(paidOrders);

  return (
    <>
      {orders.map(order => (
        <OrderCard key={order.id} order={order} />
      ))}
    </>
  );
}

export default KitchenPage;