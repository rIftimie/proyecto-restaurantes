import React from "react";
import { useState, useEffect } from "react";
import { getOrders } from "../Api/Orders";

const Orders = () => {

  const [orders, setOrders] = useState([]);
  // console.log(getUsers());
  useEffect(() => {
    getOrders()
          .then((json) => setOrders(json))
  }, []);

  
  return (
      <div>
          {orders.map((order) => (
              <div key={order.id}>
                  
                  <p>Id: {order.id}</p>
                  <p>Status: {order.status}</p>
                  <p>Order_date: {new Date(order.order_date).toLocaleString()}</p>
                  <p>Note: {order.note}</p>
              </div>
          ))}
          {/* <p>{users}</p> */}
      </div>
  );
};


export default Orders;
