import React from "react";
import Subtotal from "../../components/subtotal/Subtotal";
import Products from "../../components/products/Products";

const PayPage = ({ stripeKey }) => {
  return (
    <>
      <div>
        {" "}
        <Products />{" "}
      </div>
      <div class="position-absolute bottom-0 m-5">
        {" "}
        <Subtotal stripeKey={stripeKey} />{" "}
      </div>
    </>
  );
};

export default PayPage;
