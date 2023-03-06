import React from "react"; 
import OrderCard from "./OrderCard";

function OrderContainer({ data ,onOrderStatusChange1,onOrderStatusChange2 }) {
  const orders = data;
  const renderOrders = orders.map((order) => <OrderCard order={order} onOrderStatusChange1={onOrderStatusChange1} onOrderStatusChange2={onOrderStatusChange2}  />);

  return <main className="d-flex justify-content-between">{renderOrders}</main>;
}

export default OrderContainer;