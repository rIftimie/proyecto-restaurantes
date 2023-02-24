import React from 'react';

function OrderCard({ order }) {
  return (
    <div>
      <p>Order ID: {order.id}</p>
      <p>Items:</p>
      <ul>
        {order.orderProducts.map(orderProduct => (
          <li key={orderProduct.id}>{orderProduct.productName}</li>
        ))}
      </ul>
    </div>
  );
}

export default OrderCard;