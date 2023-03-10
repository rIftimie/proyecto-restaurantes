import React, { useEffect, useState } from "react";
import { getOrders } from "../../helpers/orders";
import { getProducts } from "../../helpers/kitchen";
import KitchenOrderContainer from "./KitchenOrderContainer";
import "./kitchen.css";
import SelectProducts from "./SelectProducts";

function KitchenPage({ restaurant_id }) {
  const [orders, setOrders] = useState([]);
  const [products, setProducts] = useState([]);

  const fetchGetOrders = async () => {
    // console.log('fetch');
    const response = await getOrders();
    setOrders(
      response.filter((order) => order.status == 1 || order.status == 2)
    );
  };

  const fetchGetProducts = async () => {
    const response = await getProducts(restaurant_id);
    // console.log(response);
    // products.push(response);
    setProducts(response);
    // console.log(products);
  };

  useEffect(() => {
    fetchGetProducts();
    fetchGetOrders();
  }, []);
  return (
    <main>
      <h1 className="text-center title m-4 fw-bolder">COCINA</h1>
      {orders.length > 0 && products.length > 0 ? (
        <>
          <KitchenOrderContainer useStateOrder={{ orders, setOrders }} />
          <SelectProducts useStateProduct={{ products, setProducts }} />
        </>
      ) : (
        <h1>Loading ...</h1>
      )}
    </main>
  );
}

export default KitchenPage;
