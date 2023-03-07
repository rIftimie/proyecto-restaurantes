import React, { useEffect, useState } from "react";
import Header from "../../components/products/Header";
import Products from "../../components/products/Products";
import "../../App.css"

const initialStateOrder={
  waiter_id: 1,
  restaurant_id: 1,
  table_order_id: 1,
  status: 0,
}
const ClientPage = ( {idres, idtable }) => {

  const [order, setOrder] = useState({})
  const [orderProducts, setOrderProducts] = useState([]);
  useEffect(() => {
    const orderCopy= { ...order };
    orderCopy.restaurant_id=idres;
    orderCopy.table_order_id=idtable;
    setOrder(orderCopy);
  }, [])
  

  return (
    <div>
      <Header />
      <Products idres={ idres } idtable={ idtable } orderProducts={ orderProducts } setOrderProducts={ setOrderProducts }/>
      <button
          type="button"
          className="btn btn-outline-success fw-bold m-3"
        >
          Pagar
      </button>
    </div>
  );
};

export default ClientPage;
