import React, { useState } from "react";
import Subtotal from "../../components/subtotal/Subtotal";
import Products from "../../components/products/Products";

const PayPage = ({ stripeKey , orderId, order }) => {
  const [show, setShow] = useState(false);
  const [orderProducts, setOrderProducts] = useState([]);
  return (
    <>
      <div>
        {" "}
        <Products setShow={ setShow } order={ order } paying={ true } orderId={ orderId } orderProducts={ orderProducts } setOrderProducts={ setOrderProducts } />{" "}
      </div>
      <div>
        {" "}
        <Subtotal orderProducts={ orderProducts } stripeKey={ stripeKey } orderId={ orderId } />{" "}
      </div>
    </>
  );
};

export default PayPage;
