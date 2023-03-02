import React, { useEffect, useState } from "react";
import { getOrders } from "../../api/orders";

import OrderContainer from "../../components/OrderContainer";

function WaiterPage() {
  const [orders, setOrders] = useState([]);
  useEffect(() => {
    fetch("/api/orders")
      .then((response) => response.json())
      .then((json) => setOrders(json));
  }, []);

  return (
    <>
    <h1 className="text-center">Pedidos</h1>
      <OrderContainer data={orders} />
    </>
  );
}

export default WaiterPage;
