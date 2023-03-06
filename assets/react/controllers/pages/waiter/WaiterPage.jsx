import React, { useEffect, useState } from "react";
import { getOrders } from "../../api/orders";

import OrderWaiterContainer from "./OrderWaiterContainer";

function WaiterPage() {
  const [orders, setOrders] = useState([]);
  useEffect(() => {
    getOrders()
      .then((json) => setOrders(json));
  }, []);
  
  
  return (
    <>
    <h1 className="text-center">Pedidos</h1>
      <OrderWaiterContainer useStateOrder={{orders, setOrders}}/>
    </>
  );
}

export default WaiterPage;
