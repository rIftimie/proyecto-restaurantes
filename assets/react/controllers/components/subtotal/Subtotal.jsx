import React, { useState } from "react";
import DrawerSubtotal from "./DrawerSubtotal";
const Subtotal = ({ stripeKey, orderId }) => {
  const [isDrawerOpen, setIsDrawerOpen] = useState(false);

  const handleOpenDrawer = () => {
    if (isDrawerOpen) {
      setIsDrawerOpen(false);
    } else {
      setIsDrawerOpen(true);
    }
  };
  return (
    <div className="pagar">
      <div className="container d-flex justify-content-between border-bottom border-light border-top">
        <p className="fw-bold m-3">SubTotal</p>
        <p className="fw-bold m-3">300€</p>
      </div>
      <div className="container d-flex justify-content-center">
        <button
          onClick={handleOpenDrawer}
          type="button"
          className="btn btn-outline-success fw-bold m-3"
        >
          Pagar
        </button>
        <DrawerSubtotal
          isOpen={isDrawerOpen}
          setIsDrawerOpen={setIsDrawerOpen}
          stripeKey={stripeKey}
          orderId={orderId}
        />
      </div>
    </div>
  );
};

export default Subtotal;
