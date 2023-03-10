import React, { useState } from "react";
import PayButton from "../../components/stripe/PayButton";
import Header from "../../components/products/Header";
import Products from "../../components/products/Products";
<<<<<<< Updated upstream
import "../../App.css"
=======
import "../../App.css";
import { postOrder } from "../../helpers/orders";

const initialStateOrder = {
  waiter_id: 1,
  restaurant_id: 1,
  table_order_id: 1,
  status: 0,
};
const ClientPage = ({ idres, idtable }) => {
  const [order, setOrder] = useState({});
  const [orderProducts, setOrderProducts] = useState([]);
  const [charge, setCharge] = useState(true);
  const [show, setShow] = useState(false);
  useEffect(() => {
    const orderCopy = { ...order };
    orderCopy.restaurant_id = idres;
    orderCopy.table_order_id = idtable;
    setOrder(orderCopy);
  }, []);

  const handleClickPay = async () => {
    if (orderProducts.length) {
      setCharge(false);
      await postOrder(orderProducts)
        .then((res) => {
          window.location.href =
            "http://localhost:8000/orders/pay/" + res[0].id;
        })
        .catch((error) => {
          setCharge(true);
          console.log(error);
        });
    }
  };
>>>>>>> Stashed changes

const ClientPage = () => {
  return (
    <div>
<<<<<<< Updated upstream
      <Header />
      <Products />
      <PayButton />
=======
      {charge && show && <Header />}
      {charge && (
        <Products
          idres={idres}
          idtable={idtable}
          orderProducts={orderProducts}
          setOrderProducts={setOrderProducts}
          setShow={setShow}
        />
      )}
      {charge && show && (
        <button
          type="button"
          className="btn btn-outline-success fw-bold m-3"
          onClick={handleClickPay}
        >
          Pagar
        </button>
      )}
      {!show && charge && <p>Loading...</p>}
>>>>>>> Stashed changes
    </div>
  );
};

export default ClientPage;
