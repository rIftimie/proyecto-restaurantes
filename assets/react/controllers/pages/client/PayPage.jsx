import React, { useState } from "react";
import Subtotal from "../../components/subtotal/Subtotal";
import Products from "../../components/products/Products";

const PayPage = ({ stripeKey , orderId, orderProducts }) => {
  const [show, setShow] = useState(false);
  return (
    <>
      <div>
        {" "}
        <Products setShow={setShow}/>{" "}
      </div>
      <div>
        {" "}
        <Subtotal stripeKey={stripeKey} orderId={ orderId } />{" "}
      </div>
    </>
  );
};

export default PayPage;
