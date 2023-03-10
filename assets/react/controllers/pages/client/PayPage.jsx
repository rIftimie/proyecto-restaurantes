import React from "react";
import Subtotal from "../../components/subtotal/Subtotal";
import Products from "../../components/products/Products";

const PayPage = ({ stripeKey , orderId, orderProducts }) => {
  console.log(orderProducts);
  return (
    <>
      <div>
        {" "}
        <Products  />{" "}
      </div>
      <div>
        {" "}
        <Subtotal stripeKey={stripeKey} orderId={ orderId } />{" "}
      </div>
    </>
  );
};

export default PayPage;
