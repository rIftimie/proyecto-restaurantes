import React from "react"; 
import KitchenOrderCard from "./KitchenOrderCard";

function KitchenOrderContainer({ data, onHandleAccept, onHandleFinish, onHandleDecline }) {
  const orders = data;
  const renderOrders = orders?.map((order) => <KitchenOrderCard order={order} key={order.id} onHandleAccept={onHandleAccept} onHandleFinish={onHandleFinish} onHandleDecline={onHandleDecline}/>);
  return <main className="d-flex justify-content-between">{renderOrders}</main>;
}

export default KitchenOrderContainer;