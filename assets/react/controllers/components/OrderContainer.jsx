import React from "react"; 
import OrderCard from "./OrderCard";

function OrderContainer({ data, onHandleAccept, onHandleFinish, onHandleDecline }) {
  const orders = data;
  const renderOrders = orders?.map((order) => <OrderCard order={order} key={order.id} onHandleAccept={onHandleAccept} onHandleFinish={onHandleFinish} onHandleDecline={onHandleDecline}/>);
  return <main className="d-flex justify-content-between">{renderOrders}</main>;
}

export default OrderContainer;
