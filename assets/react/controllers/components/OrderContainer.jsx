import React from "react"; 
import OrderCard from "./OrderCard";

function OrderContainer({ data }) {
  const orders = data;
  const renderOrders = orders?.map((order) => <OrderCard order={order} />);
  return <main className="d-flex justify-content-between">{renderOrders}</main>;
}

export default OrderContainer;
